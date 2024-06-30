<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Repos\ReportRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminReportController extends Controller
{
    use HandleJsonResponse;
    protected ReportRepo $reportRepo;

    public function __construct(ReportRepo $reportRepo)
    {
        $this->reportRepo = $reportRepo;
    }


    /**
     * Lấy danh sách các báo cáo theo trạng thái
     * GET /
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
     * PUT /
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
     * PUT /
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
