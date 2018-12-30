<?php

namespace App\Listeners;

use App\Events\AccountCreation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetHostingAccount
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AccountCreation  $event
     * @return void
     */
    public function handle(AccountCreation $event)
    {
        \Log::debug($event->account);
    }
}
