<?php

namespace App\Http\Controllers\User;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Repos\ReportRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    use HandleJsonResponse;
    protected ReportRepo $reportRepo;

    public function __construct(ReportRepo $reportRepo)
    {
        $this->reportRepo = $reportRepo;
    }
    /**
     * Thêm report mới
     * POST /
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $data = $request->all();
            Log::info($data);
            $report = $this->reportRepo->create($data);
            if(!$report) {
                throw new Exception('Thêm hoặc cập nhật đánh giá không thành công');
            }
            return $this->handleSuccessJsonResponse();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy danh sách các báo cáo theo trạng thái
     * POST /
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request)
    {
        try {
            $status = $request->get('tab');
            $reports = $this->reportRepo->listByStatus($status);
            return $this->handleSuccessJsonResponse($reports);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Đánh dấu đã giải quyết
     * POST /
     *
     * @param Int $id
     * @return JsonResponse
     */
    public function processed($id)
    {
        try {
            $this->reportRepo->edit($id, ['status' => ReportStatus::PROCESSED]);
            return $this->handleSuccessJsonResponse();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Xóa báo cáo
     * POST /
     *
     * @param Int $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        try {
            $this->reportRepo->edit($id, ['status' => ReportStatus::DELETED]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
