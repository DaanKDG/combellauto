<?php

namespace App\Listeners;

use App\Events\AccountCreation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetHostingAccount
{

    public function __construct()
    {
        //
    }

    public function handle(AccountCreation $event)
    {
        return $event->account;
    }
}
