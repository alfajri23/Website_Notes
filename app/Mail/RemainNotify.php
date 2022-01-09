<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RemainNotify extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $data;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$user)
    {
        $this->data = $data;
        $this->user = $user;
    }

    
    // MAIL_DRIVER=smtp
    // MAIL_HOST=smtp.gmail.com
    // MAIL_PORT=587
    // MAIL_USERNAME=noteside001@gmail.com
    // MAIL_PASSWORD=planwithnotes
    // MAIL_ENCRYPTION=tls

    public function build()
    {
        return $this->markdown('remainder')
                    ->subject('Pemberitahuan Penting!')
                    ->with('data', $this->data)
                    ->with('user', $this->user);
    }
}
