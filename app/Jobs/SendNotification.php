<?php

namespace App\Jobs;

use App\Events\Notify\PostNotifyEvent;
use App\Repos\NotificationRepo;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_id;
    protected $type;
    protected $post_project_id;
    protected $action;
    protected $note;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $type, $post_project_id, $action, $note = null)
    {
        $this->user_id = $user_id;
        $this->type = $type;
        $this->post_project_id = $post_project_id;
        $this->action = $action;
        $this->note = $note;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(NotificationRepo $notificationRepo)
    {
        try {
            $notification = $notificationRepo->create([
                'user_id' => $this->user_id,
                'type' => $this->type,
                'post_project_id' => $this->post_project_id,
                'action' => $this->action,
                'note' => $this->note
            ]);
            event(new PostNotifyEvent($notification));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
