<?php

namespace App\Mail;

use App\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $account;

    public function __construct()
    {
        $this->account = $account;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM'))
                    ->view('emails.accountcreated');
    }
}
