<?php

namespace App\Http\Controllers\User;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Repos\EnterpriseRepo;
use App\Repos\ProjectImageRepo;
use App\Repos\ProjectRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserProjectController extends Controller
{
    use HandleJsonResponse;
    protected ProjectRepo $projectRepo;
    protected EnterpriseRepo $enterpriseRepo;
    protected ProjectImageRepo $projectImageRepo;

    public function __construct(ProjectRepo $projectRepo, EnterpriseRepo $enterpriseRepo, ProjectImageRepo $projectImageRepo)
    {
        $this->projectRepo = $projectRepo;
        $this->enterpriseRepo = $enterpriseRepo;
        $this->projectImageRepo = $projectImageRepo;
    }

    /**
     * Lấy thông tin chi tiết một dự án
     * GET /
     *
     * @param int $id  ( id của dự án cần lấy thông tin )
     * @return JsonResponse
     */
    public function get($id)
    {
        try {
            $project = $this->projectRepo->get($id);
            $user_id = Auth::check() ? auth()->user()->id : null;
            $check_auth =  false;
            if($user_id) {
                $enterprise = $this->enterpriseRepo->checkIsEnteprise($user_id);
                $check_auth = $enterprise ? ($enterprise->user_id == $user_id ? true : false) : false;  
            }
            if(!$check_auth) {
                $this->projectRepo->edit($id, ['number_views' => $project->number_views + 1]);
            }
            if (!$project) {
                throw new Exception('Dự án không tồn tại');
            }
            return $this->handleSuccessJsonResponse($project);
        } catch (Exception $e) {
            Log::error($e);
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy danh sách các dự án dựa theo các thông tin lọc và tím kiếm từ người dùng
     * GET /
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listProject(Request $request)
    {
        try {
            // $order = $request->get('order_by');
            // $orderKey = $this->getOrderByKey($order);
            $search = $request->get('search');
            $type_id = $request->get('type_id');
            $endPrice = $request->get('endPrice');
            $startPrice = $request->get('startPrice');
            $province = $request->get('province');
            $district = $request->get('district');
            $status = $request->get('status');

            $data = [
                'endPrice' => $endPrice ? $endPrice : 9999999999,
                'startPrice' => $startPrice ? $startPrice : 0,
                'province' => $province ? $province : "-",
                'district' => $district ? $district : "-",
                'type_id' => $type_id,
                'search' => $search ? $search : "",
                'status' => $status ? $status : ProjectStatus::ALL,
                // 'order_by' => $orderKey['order_by'],
                // 'order_with' => $orderKey['order_with'],
            ];
            $projects = $this->projectRepo->listProject($data);
            foreach ($projects as $project) {
                $image = $this->projectImageRepo->getImageByProject($project->id);
                $project->image = $image;
            }
            return $this->handleSuccessJsonResponse($projects);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy danh sách các dự án dựa theo các thông tin lọc để đưa ra cho các ô select
     * GET /
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listProjectOptions(Request $request)
    {
        try {
            $province = $request->get('province');
            $district = $request->get('district');
            $data = [
                'province' => $province ? $province : " - ",
                'district' => $district ? $district : "-"
            ];
            $projects = $this->projectRepo->listProjectOptions($data);
            return $this->handleSuccessJsonResponse($projects);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy danh sách các dự án nổi bật
     * GET /
     *
     * @return JsonResponse
     */
    public function listFavoriteProject()
    {
        try {
            $projects = $this->projectRepo->listFavoriteProject();
            foreach ($projects as $project) {
                $image = $this->projectImageRepo->getImageByProject($project->id);
                $project->image = $image;
            }
            return $this->handleSuccessJsonResponse($projects);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
