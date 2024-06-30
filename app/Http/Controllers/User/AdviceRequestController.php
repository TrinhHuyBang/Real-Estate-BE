<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repos\AdviceRequestRepo;
use App\Repos\BrokerAdviceRequestRepo;
use App\Repos\BrokerRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use App\Enums\BrokerAdviceRequestStatus;
use App\Jobs\sendMailForAcceptBrokerJob;
use App\Repos\BrokerReviewRepo;

class AdviceRequestController extends Controller
{
    use HandleJsonResponse;
    protected AdviceRequestRepo $adviceRequestRepo;
    protected BrokerAdviceRequestRepo $brokerAdviceRequestRepo;
    protected BrokerRepo $brokerRepo;
    protected BrokerReviewRepo $brokerReviewRepo;

    public function __construct(
        AdviceRequestRepo $adviceRequestRepo,
        BrokerAdviceRequestRepo $brokerAdviceRequestRepo,
        BrokerRepo $brokerRepo,
        BrokerReviewRepo $brokerReviewRepo)
    {
        $this->adviceRequestRepo= $adviceRequestRepo;
        $this->brokerAdviceRequestRepo= $brokerAdviceRequestRepo;
        $this->brokerRepo= $brokerRepo;
        $this->brokerReviewRepo = $brokerReviewRepo;
    }

    /**
     * Lấy danh sách các yêu cầu tư vấn của bản thân mình
     * get /
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function getListOwnerRequest(Request $request) {
        try {
            $search = $request->get('search');
            $type = $request->get('type');
            $postType = config("postType.$type");
            $status = $request->get('status');
            $status = config("requestStatus.$status");
            $advice_requests = $this->adviceRequestRepo->listByStatus($status, $postType, $search);
            foreach ($advice_requests as $advice_request) {
                $broker_advice_requests = $this->brokerAdviceRequestRepo->getByRequestIdAndStatus(
                    $advice_request->id,
                    [BrokerAdviceRequestStatus::ACCEPTED, BrokerAdviceRequestStatus::APPLIED]
                );
                $advice_request->countBroker = count($broker_advice_requests);
                $advice_request->brokerAvatar = $this->brokerAdviceRequestRepo->getAvatarBroker($advice_request->id);
            }
            return $this->handleSuccessJsonResponse($advice_requests);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Tạo mới một yêu cầu tư vấn
     * post /
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function createRequest(Request $request) {
        try {
            $data = $request->all();
            $data['user_id'] = auth()->user()->id;
            $advice_request = $this->adviceRequestRepo->create($data);
            if(!$advice_request) {
                throw new Exception('Tạo tin yêu cầu tư vấn không thành công');
            }
            return $this->handleSuccessJsonResponse($advice_request);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy thông tin chi tiết yêu cầu tư vấn
     * get /
     *
     * @param int $id
     * @return JsonResponse
     */

    public function detail($id) {
        try {
            $advice_request = $this->adviceRequestRepo->get($id);
            if(!$advice_request) {
                throw new Exception('Không tồn tại yêu cầu tư vấn có id ' . $id);
            }
            return $this->handleSuccessJsonResponse($advice_request);
        } catch (exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy thông tin broker được chấp nhận tư vấn tương ứng với request có id là $id
     * get /
     *
     * @param int $id
     * @return JsonResponse
     */

     public function getBrokerAccepted($id) {
        try {
            $broker = $this->brokerAdviceRequestRepo->getBrokerAccepted($id);
            if ($broker) {
                $broker = $this->brokerRepo->getBrokerDetail($broker, $broker->broker_request_id);
                return $this->handleSuccessJsonResponse([$broker]);
            }
            return $this->handleSuccessJsonResponse([]);
        } catch (exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy danh sách broker đăng ký vào request có id là $id
     * get /
     *
     * @param int $id
     * @return JsonResponse
     */

     public function listBrokerApplied($id) {
        try {
            $brokers = $this->brokerAdviceRequestRepo->listBrokerApplied($id);
            foreach ($brokers as $broker) {
                $broker = $this->brokerRepo->getBrokerDetail($broker);
            }
            return $this->handleSuccessJsonResponse($brokers);
        } catch (exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }


    /**
     * Lấy thông tin chi tiết yêu cầu tư vấn
     * put /
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deleteRequest($id) 
    {
        try {
            $advice_request = $this->adviceRequestRepo->edit($id, ['status' => config('requestStatus.deleted')]);
            if(!$advice_request) {
                throw new Exception('Cập nhật không thành công ' . $id);
            }
            return $this->handleSuccessJsonResponse($advice_request);
        } catch (exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Nhà môi giới đăng kí vào request
     * post /
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function apply(Request $request) {
        try {
            $request_id = $request->get('request_id');
            $user_id = auth()->user()->id;
            $broker_id = $this->brokerRepo->getByUserId($user_id);
            $broker_advice_request = $this->brokerAdviceRequestRepo->create([
                'request_id' => $request_id,
                'broker_id' => $broker_id->id
            ]);
            if(!$broker_advice_request) {
                throw new Exception('Đăng ký không thành công');
            }
            return $this->handleSuccessJsonResponse($broker_advice_request);
        } catch (exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Chọn người môi giới ứng với yêu cầu tư vấn
     * put /
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function acceptBroker(Request $request) {
        try {
            $user = auth()->user();
            $request_id = $request->get('request_id');
            $broker_id = $request->get('broker_id');
            $broker = $this->brokerRepo->getUserDetail($broker_id);
            $status = BrokerAdviceRequestStatus::ACCEPTED;
            $broker_advice_request = $this->brokerAdviceRequestRepo->editStatus($request_id, $broker_id, $status);
            if(!$broker_advice_request) {
                throw new Exception('Người môi giới chưa đăng kí hoặc yêu cầu tư vấn không tồn tại');
            }
            sendMailForAcceptBrokerJob::dispatch($user->name, $user->email, $user->phone, $broker->email, false)->onQueue('email');
            sendMailForAcceptBrokerJob::dispatch($broker->name, $broker->email, $broker->phone, $user->email, true)->onQueue('email');
            return $this->handleSuccessJsonResponse($broker_advice_request);
        } catch (exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Bỏ chọn nhà môi giới khỏi yêu cầu tư vấn
     * put /
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function deleteBroker(Request $request) {
        try {
            $request_id = $request->get('request_id');
            $broker_id = $request->get('broker_id');
            $rating = $request->get('rating');
            $review = $request->get('review');
            $broker_advice_request = $this->brokerAdviceRequestRepo->editStatus($request_id, $broker_id, BrokerAdviceRequestStatus::DELETED);
            if(!$broker_advice_request) {
                throw new Exception('Người môi giới chưa đăng kí hoặc yêu cầu tư vấn không tồn tại');
            }
            if($rating) {
                $brokerReview = $this->brokerReviewRepo->create([
                    'user_id' => auth()->user()->id,
                    'broker_id' => $broker_id,
                    'broker_request_id' => $broker_advice_request->id,
                    'rating' => $rating,
                    'review' => $review
                ]);
            }
            return $this->handleSuccessJsonResponse($broker_advice_request);
        } catch (exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Huỷ yêu cầu đăng ký tư vấn
     * delete /
     *
     * @param Int $id
     * @return JsonResponse
     */

     public function cancleRegistration($id) {
        try {
            $user_id = auth()->user()->id;
            $broker_id = $this->brokerRepo->getByUserId($user_id)->id;
            $broker_advice_request = $this->brokerAdviceRequestRepo->getByRequestIdAndBrokerId($id, $broker_id);
            $this->brokerAdviceRequestRepo->delete($broker_advice_request->id);
            return $this->handleSuccessJsonResponse();
        } catch (exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }


    /**
     * Lấy danh sách các yêu cầu tư vấn của bản thân mình
     * get /
     *
     * @param Request $request
     * @return JsonResponse
     */

     public function getListRequest(Request $request) {
        try {
            $type_id = $request->get('type_id');
            $province = $request->get('province');
            $district = $request->get('district');
            $search = $request->get('search');
            $project_id = $request->get('project_id');
            $type = $request->get('type');
            $data = [
                'province' => $province ? $province : "-",
                'district' => $district ? $district : "-",
                'type_id' => $type_id,
                'search' => $search,
                'type' => $type,
                'project_id' => $project_id,
            ];
            $broker_id = $this->brokerRepo->getByUserId(auth()->user()->id)->id;
            $except = $this->brokerAdviceRequestRepo->listRequestByBroker($broker_id);
            $advice_requests = $this->adviceRequestRepo->listByBroker($broker_id, $except, $data);
            return $this->handleSuccessJsonResponse($advice_requests);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy danh sách các yêu cầu tư vấn mà mình đã đăng ký (dành cho nhà tư vấn)
     * Có thể lọc theo các tab như tất cả, đã đăng ký, đang tư vấn và đã bị từ chối
     * get /
     *
     * @param Request $request
     * @return JsonResponse
     */

     public function listAppliedRequest(Request $request) {
        try {
            $search = $request->get('search');
            $type = $request->get('type');
            $postType = config("postType.$type");
            $status = $request->get('status');
            $status = config("brokerAdviceRequestStatus.$status");
            $broker_id = $this->brokerRepo->getByUserId(auth()->user()->id)->id;
            $advice_requests = $this->adviceRequestRepo->listAppliedRequestByBrokerId($broker_id, $status, $postType, $search);
            return $this->handleSuccessJsonResponse($advice_requests);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }


}
