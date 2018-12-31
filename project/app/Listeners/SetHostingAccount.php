<?php

namespace App\Listeners;

use App\Events\AccountCreation;
use App\Events\AccountWasUpdated;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
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
        $generator = new ComputerPasswordGenerator();
        $generator->setUppercase()->setLowercase()->setNumbers()->setSymbols(false)->setLength(20);
        $password = $generator->generatePassword();

        $domain = preg_replace('/\s+/', '.', mb_strtolower($event->account->name . ' mtantwerp.eu'));
        $event->account->domain = $domain;
        $event->account->password = $password;

        $event->account->save();
        // change account status to finished
        event(new AccountWasUpdated($event->account));
    }
}
