<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BrokerRequestStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repos\BrokerRepo;
use App\Repos\UserRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AdminBrokerController extends Controller
{
    use HandleJsonResponse;
    protected UserRepo $userRepo;
    protected BrokerRepo $brokerRepo;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserRepo $userRepo, BrokerRepo $brokerRepo)
    {
        $this->userRepo = $userRepo;
        $this->brokerRepo = $brokerRepo;
    }

    /**
     * Lấy danh sách người dùng
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('view-any-user', User::class)) {
                $search = $request->get('search');
                $status = $request->get('tab') === "listRequest" ? 0 : 1;
                $data = [
                    'search' => $search,
                ];
                $brokers = $this->brokerRepo->listBrokerForAdmin($data, $status);
                return $this->handleSuccessJsonResponse($brokers);
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Khoá tài khoản của người dùng
     * put /
     *
     * @param Int $id
     * @return JsonResponse
     */
    public function blockAccount($id)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('update-user', User::class)) {
                $message = $this->brokerRepo->blockAccount($id);
                return $this->handleSuccessJsonResponse($message);
            } else {
                throw new Exception("Bạn không có quyền thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Từ chối yêu cầu thành nhà môi giới
     * put /
     *
     * @param Int $id
     * @return JsonResponse
     */
    public function rejectRequest($id)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('update-user')) {
                $this->brokerRepo->edit($id, ['status' => BrokerRequestStatus::REJECTED]);
                return $this->handleSuccessJsonResponse();
            } else {
                throw new Exception("Bạn không có quyền để thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    
    /**
     * Chấp nhận yêu cầu đăng ký thành nhà môi giới
     * put /
     *
     * @param Int $id
     * @return JsonResponse
     */
    public function acceptRequest($id)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('update-user')) {
                $broker = $this->brokerRepo->edit($id, ['status' => BrokerRequestStatus::ACCEPTED]);
                $this->userRepo->edit($broker->user_id, ['role' => UserRole::BROKER]);
                return $this->handleSuccessJsonResponse();
            } else {
                throw new Exception("Bạn không có quyền để thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
