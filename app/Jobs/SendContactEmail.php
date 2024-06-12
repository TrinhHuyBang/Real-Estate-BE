<?php

namespace App\Jobs;

use App\Events\Notify\PostNotifyEvent;
use App\Mail\SendEmail;
use App\Repos\NotificationRepo;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendContactEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_name;
    protected $phone;
    protected $to_email;
    protected $content;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_name, $phone, $to_email, $content)
    {
        $this->user_name = $user_name;
        $this->phone = $phone;
        $this->to_email = $to_email;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $data = [
                'from_email' => config('app.mail_from_address'),
                'subject' => 'Yêu cầu liên hệ lại',
                'user_name' => $this->user_name,
                'phone' => $this->phone,
                'type' => 1,
                'content' => $this->content,
            ];
            Mail::to($this->to_email)->send(new SendEmail($data));
        } catch (Exception $e) {
            Log::error($e);
        }
    }
}
