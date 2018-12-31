<?php

namespace App\Listeners;

use App\Events\AccountWasUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendHostingAccount
{
    public function __construct()
    {
        //
    }

    public function handle(AccountWasUpdated $event)
    {
        return $event->account;
    }
}
