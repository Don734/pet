<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->token = $data['token'];
    }

    public function build()
    {
        return $this->markdown('emails.password_reset', [
            'token' => route('reset.password.form', ['token' => $this->token])
        ])
            ->subject('Восстановление пароля на сайте ' . config('app.name'));
    }
}
