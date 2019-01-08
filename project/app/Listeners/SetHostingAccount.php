<?php

namespace App\Listeners;

use App\Events\AccountWasCreated;
use App\Events\AccountWasUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\GeneratePassword;
use App\Helpers\Domain;

class SetHostingAccount
{

    public function __construct()
    {
        //
    }

    public function handle(AccountWasCreated $event)
    {   
        $domain = new Domain($event->account);
        $event->account->domain = $domain->getDomain();
        $event->account->password = GeneratePassword::password();
        $event->account->status = 'finished';

        $event->account->save();
        event(new AccountWasUpdated($event->account));
    }
}
