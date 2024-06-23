<?php

namespace App\Events\Notify;

use App\Enums\NotificationType;
use App\Traits\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Exception;
use Illuminate\Support\Facades\Log;

class PostNotifyEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    use Notification;

    public mixed $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data  = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('notification');
    }

    public function broadcastAs(): string
    {
        return 'notice';
    }

    public function broadcastWith(): array
    {
        $message = $this->getMessageForNotify($this->data);
        Log::info($message);
        return ["message" => $message, 'user_id' => Arr::get($this->data, 'user_id')];
    }
}
