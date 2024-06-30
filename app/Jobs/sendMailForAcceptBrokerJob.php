<?php

namespace App\Jobs;

use App\Mail\SendEmail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class sendMailForAcceptBrokerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_name;
    protected $phone;
    protected $to_email;
    protected $is_user;
    protected $user_email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_name, $user_email, $phone, $to_email, $is_user)
    {
        $this->user_name = $user_name;
        $this->user_email = $user_email;
        $this->phone = $phone;
        $this->to_email = $to_email;
        $this->is_user = $is_user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if($this->is_user) {
                $subject = "Thông tin liên hệ của nhà môi giới $this->user_name";
                $content = "Dưới đây là toàn bộ thông tin liên hệ của nhà môi giới $this->user_name, hãy liên hệ sớm để được nhận tư vấn.";
            } else {
                $subject = "Thông tin liên hệ của người dùng $this->user_name";
                $content = "Dưới đây là toàn bộ thông tin liên hệ của người dùng $this->user_name, hãy liên hệ sớm để tư vấn cho họ.";
            }
            $data = [
                'from_email' => config('app.mail_from_address'),
                'subject' => $subject,
                'title' => $subject,
                'user_email' => $this->user_email,
                'user_name' => $this->user_name,
                'phone' => $this->phone,
                'type' => 2,
                'content' => $content ? $content : '',
            ];
            Mail::to($this->to_email)->send(new SendEmail($data));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
