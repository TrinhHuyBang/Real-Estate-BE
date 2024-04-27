<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrokerResource;
use App\Repos\BrokerRepo;
use App\Traits\HandleJsonResponse;
use App\Traits\OrderByKey;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class BrokerController extends Controller
{
    use HandleJsonResponse;
    use OrderByKey;
    protected BrokerRepo $brokerRepo;

    public function __construct(BrokerRepo $brokerRepo)
    {
        $this->brokerRepo= $brokerRepo;
    }

    /**
     * Lấy danh sách các nhà môi giới, tư vấn
     * get /
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function getList(Request $request) {
        try {
            $order = $request->get('order_by');
            $orderKey = $this->getOrderByKey($order);
            $type_id = $request->get('type_id');
            $province = $request->get('province');
            $district = $request->get('district');
            $project_id = $request->get('project_id');
            $search = $request->get('search');
            $type = $request->get('type');
            $data = [
                'province' => $province ? $province : "-",
                'district' => $district ? $district : "-",
                'type_id' => $type_id,
                'search' => $search,
                'type' => $type,
                'project_id' => $project_id,
                // 'order_by' => $orderKey['order_by'],
                // 'order_with' => $orderKey['order_with'],
            ];
            $brokers = $this->brokerRepo->listBroker($data);
            foreach ($brokers as $broker) {
                $this->brokerRepo->getBrokerDetail($broker);
            }
            $brokers = BrokerResource::collection($brokers)->values()->all();
            $perPage = 10;
            $currentPage = request('page', 1);
            $pagedResults = array_slice($brokers, ($currentPage - 1) * $perPage, $perPage);
            $brokers = new LengthAwarePaginator($pagedResults, count($brokers), $perPage, $currentPage);
            return $this->handleSuccessJsonResponse($brokers);
        } catch (Exception $e) {
            Log::info($e);
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy thông tin chi tiêt nhà môi giới, tư vấn
     * get /
     *
     * @param int $id
     * @return JsonResponse
     */

    public function getDetail($id) {
        try {
            $broker = $this->brokerRepo->get($id);
            if (!$broker) {
                throw new Exception('Nhà môi giới không tồn tại');
            }
            return $this->handleSuccessJsonResponse($broker);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
