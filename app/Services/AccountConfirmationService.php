<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\AccountConfirmationMail;
use App\Models\Client;

class AccountConfirmationService
{
    public function sendConfirmationEmail(Client $user)
    {
        $confirmationUrl = route('confirm', ['token' => $user->confirmation_token]);
        Mail::to($user->email)->send(new AccountConfirmationMail(['confirmationUrl' => $confirmationUrl]));
    }

    public function confirmAccount(Client $user)
    {
        $user->update(['confirmed' => true]);
    }
}
