<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $type;
    public $subject;
    public $address;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->type = Arr::get($data, 'type');
        $this->subject = Arr::get($data, 'subject');
        $this->address = Arr::get($data, 'from_email') ?
            Arr::get($data, 'from_email') :
            config('app.mail_from_address');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $view = null;

        switch ($this->type) {
            case '-1':
                $view = 'emails.verifyEmail';
                break;
            case '-2':
                $view = 'emails.forgotPassword';
                break;
            case '1':
                $view = 'emails.contactEmail';
                break;
            case '2':
                $view = 'emails.acceptBroker';
                break;
            default:
                $view = 'emails.verifyEmail';
                break;
        }

        return $this->view($view)
            ->from($this->address)
            ->subject($this->subject)
            ->with(['data' => $this->data]);
    }
}
