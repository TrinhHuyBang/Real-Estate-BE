<?php

namespace App\Http\Controllers\Enterprise;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Repos\EnterpriseRepo;
use App\Repos\ProjectImageRepo;
use App\Repos\ProjectRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
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
     * Thêm một dự án mới
     * POST /
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $user_id = auth()->user()->id;
        $project = $request->except('images');
        $enterprise = $this->enterpriseRepo->getDetailByUserId($user_id);
        $project['enterprise_id'] = $enterprise->id;
        $project_image = $request->get('images');
        try {
            $new_project = $this->projectRepo->create($project);
            if (!$new_project) {
                throw new Exception('Thêm dự án không thành công');
            }
            foreach ($project_image as $project_image) {
                $image = $this->projectImageRepo->create(['url' => $project_image, 'project_id' => $new_project->id]);
                if (!$image) {
                    throw new Exception('Thêm ảnh không thành công');
                }
            }
            return $this->handleSuccessJsonResponse();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy danh sách dự án của chính người dùng đang đăng nhập
     * get /
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function listOwnerProject(Request $request) {
        try {
            // Có 2 loại status
            // Project_status : trạng thái hoàn thành của dự án (đang bán, sắp mở bán hay đã bàn giao)
            // Status : trạng thái của bài đăng về dự án
            $user_id = auth()->user()->id;
            $enterprise = $this->enterpriseRepo->getDetailByUserId($user_id);
            $search = $request->get('search');
            $project_status = $request->get('project_status');
            $project_status = $project_status ? $project_status : ProjectStatus::ALL;
            $status = $request->get('status');
            $status = config("status.project.$status");
            $projects = $this->projectRepo->listOwnerProject($enterprise->id, $status, $project_status, $search);
            foreach ($projects as $project) {
                $image = $this->projectImageRepo->getImageByProject($project->id);
                $project->image = $image;
            }
            return $this->handleSuccessJsonResponse($projects);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Cập nhật thông tin dự án
     * Put /
     *
     * @param Int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request)
    {
        $project = $request->except(['images', 'id', 'investor', 'updated_at', 'created_at', 'status']);
        $project_image = $request->get('images');
        try {
            $project = $this->projectRepo->edit($id, $project);
            if (!$project) {
                throw new Exception('Không có dự án');
            }
            $this->projectImageRepo->delete($id);
            foreach ($project_image as $project_image) {
                $image = $this->projectImageRepo->create(['url' => $project_image, 'project_id' => $id]);
                if (!$image) {
                    throw new Exception('Thêm ảnh không thành công');
                }
            }
            return $this->handleSuccessJsonResponse();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Xóa dự án
     * Delete /
     *
     * @param Int $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        try {
            $project = $this->projectRepo->delete($id);
            if (!$project) {
                throw new Exception('Không có dự án');
            }
            return $this->handleSuccessJsonResponse();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
