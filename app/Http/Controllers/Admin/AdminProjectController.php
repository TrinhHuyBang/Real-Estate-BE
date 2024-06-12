<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NotificationAction;
use App\Enums\NotificationType;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Repos\NotificationRepo;
use App\Repos\ProjectRepo;
use App\Traits\HandleJsonResponse;
use App\Events\Notify\PostNotifyEvent;
use App\Jobs\SendNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AdminProjectController extends Controller
{
    use HandleJsonResponse;
    protected ProjectRepo $projectRepo;
    protected NotificationRepo $notificationRepo;

    public function __construct(ProjectRepo $projectRepo, NotificationRepo $notificationRepo)
    {
        $this->projectRepo = $projectRepo;
        $this->notificationRepo = $notificationRepo;
    }

    // Lấy ra danh tất cả các dự án đang hiển thị
    public function getList(Request $request)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('view-any-project', Project::class)) {
                $search = $request->get('search');
                $projects = $this->projectRepo->listByStatus($search, config('status.project.display'));
                return $this->handleSuccessJsonResponse($projects);
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy thông tin chi tiết một dự án
     * GET /
     *
     * @param int $id  ( id của bài đăng cần lấy thông tin )
     * @return JsonResponse
     */
    public function get($id)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('view-any-project', Project::class)) {
                $project = $this->projectRepo->get($id);
                if (!$project) {
                    throw new Exception('Dự án không tồn tại');
                }
                return $this->handleSuccessJsonResponse($project);
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Xoá một dự án
     * DELETE /
     *
     * @param int $id
     * @return JsonResponse
     */

     public function delete($id)
     {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('delete-project')) {
                $project = $this->projectRepo->delete($id);
                $project = $this->projectRepo->getInforById($id);
                SendNotification::dispatch($project->user_id, NotificationType::PROJECT, $id, NotificationAction::DELETE)->onQueue('notification');
                return $this->handleSuccessJsonResponse($project);
            } else {
                throw new Exception("Bạn không có quyền để thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
     }

    // Lấy ra danh sách tất cả các dự án đang chờ duyệt
    public function getListRequest(Request $request)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('view-any-project', Project::class)) {
                $search = $request->get('search');
                $projects = $this->projectRepo->listByStatus($search, config('status.project.hidden'));
                return $this->handleSuccessJsonResponse($projects);
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    //Từ chối yêu cầu
    public function rejectRequest($id)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('update-project')) {
                $this->projectRepo->edit($id, ['status' => config('status.project.reject')]);
                $project = $this->projectRepo->getInforById($id);
                SendNotification::dispatch($project->user_id, NotificationType::PROJECT, $id, NotificationAction::REJECT)->onQueue('notification');
                return $this->handleSuccessJsonResponse();
            } else {
                throw new Exception("Bạn không có quyền để thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    //Chấp nhận yêu cầu đăng bài
    public function acceptRequest($id)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('update-project')) {
                $project = $this->projectRepo->edit($id, ['status' => config('status.project.display')]);
                $project = $this->projectRepo->getInforById($id);
                SendNotification::dispatch($project->user_id, NotificationType::PROJECT, $id, NotificationAction::ACCEPT)->onQueue('notification');
                return $this->handleSuccessJsonResponse($project);
            } else {
                throw new Exception("Bạn không có quyền để thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
