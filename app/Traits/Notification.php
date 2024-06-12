<?php

namespace App\Traits;

use App\Enums\NotificationAction;
use App\Enums\NotificationType;
use App\Models\AdminRole;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

trait Notification
{
    public function getMessageForNotify($data)
    {
        $notice_type = Arr::get($data, 'type');
        $message = "";
        if($notice_type) {
            switch ($notice_type) {
                case NotificationType::POST :
                    $post = Post::select(['title'])->where('id', Arr::get($data, 'post_project_id'))->first();
                    if(Arr::get($data, 'action') === NotificationAction::ACCEPT) {
                        $message = "Bài đăng với tiêu đề $post->title đã được duyệt.";
                    } else if (Arr::get($data, 'action') === NotificationAction::REJECT) {
                        $message = "Bài đăng với tiêu đề $post->title đã bị từ chối duyệt.";
                    } else if (Arr::get($data, 'action') === NotificationAction::DELETE) {
                        $message = "Bài đăng với tiêu đề $post->title đã bị xoá.";
                    }
                    break;
                case NotificationType::PROJECT :
                    $project = Project::select(['name'])->where('id', Arr::get($data, 'post_project_id'))->first();
                    if(Arr::get($data, 'action') === NotificationAction::ACCEPT) {
                        $message = "Dự án $project->name đã được duyệt.";
                    } else if (Arr::get($data, 'action') === NotificationAction::REJECT) {
                        $message = "Dự án $project->name đã bị từ chối duyệt.";
                    } else if (Arr::get($data, 'action') === NotificationAction::DELETE) {
                        $message = "Dự án $project->name đã bị xoá.";
                    }
                    break;
                default:
                    
                    break;
            }
            return $message;
        }
    }
}