<?php

namespace App\Http\Controllers\User;

use App\Enums\NotificationAction;
use App\Enums\NotificationType;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Project;
use App\Repos\NotificationRepo;
use App\Traits\HandleJsonResponse;
use App\Traits\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    use HandleJsonResponse;
    use Notification;
    protected NotificationRepo $notificationRepo;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(NotificationRepo $notificationRepo)
    {
        $this->notificationRepo = $notificationRepo;
    }

    /**
     * Lấy danh sách thông báo của người dùng
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        try {
            $status = $request->get('status');
            $notifications = $this->notificationRepo->list($status);
            foreach ($notifications as $notification) {
                $notice_type = Arr::get($notification, 'type');
                $message = "";
                $data = "";
                if($notice_type) {
                    switch ($notice_type) {
                        case NotificationType::POST :
                            $post = Post::select(['title'])->where('id', Arr::get($notification, 'post_project_id'))->first();
                            if(Arr::get($notification, 'action') === NotificationAction::ACCEPT) {
                                $message = "Bài đăng với tiêu đề $post->title đã được duyệt.";
                            } else if (Arr::get($notification, 'action') === NotificationAction::REJECT) {
                                $message = "Bài đăng với tiêu đề $post->title đã bị từ chối duyệt.";
                            } else if (Arr::get($notification, 'action') === NotificationAction::DELETE) {
                                $message = "Bài đăng với tiêu đề $post->title đã bị xoá.";
                            }
                            break;
                        case NotificationType::PROJECT :
                            $project = Project::select(['name'])->where('id', Arr::get($notification, 'post_project_id'))->first();
                            if(Arr::get($notification, 'action') === NotificationAction::ACCEPT) {
                                $message = "Dự án $project->name đã được duyệt.";
                            } else if (Arr::get($notification, 'action') === NotificationAction::REJECT) {
                                $message = "Dự án $project->name đã bị từ chối duyệt.";
                            } else if (Arr::get($notification, 'action') === NotificationAction::DELETE) {
                                $message = "Dự án $project->name đã bị xoá.";
                            }
                            break;
                        default:
                            
                            break;
                    }
                }
                $notification->message = $message;
                $notification->data = $data;
            }
            return $this->handleSuccessJsonResponse($notifications);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Đánh dấu là đã đọc từng thông báo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($id)
    {
        try {
            $notification = $this->notificationRepo->edit($id, ['status' => 1]);
            return $this->handleSuccessJsonResponse($notification);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Đánh dấu là đã đọc một list các thông báo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsReadList(Request $request)
    {
        try {
            $list = $request->get('list') ? : [];
            foreach($list as $item) {
                $this->notificationRepo->edit($item, ['status' => 1]);
            }
            return $this->handleSuccessJsonResponse();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
