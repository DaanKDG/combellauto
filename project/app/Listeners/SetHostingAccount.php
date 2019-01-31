<?php

namespace App\Listeners;

use App\Events\AccountWasCreated;
use App\Events\AccountWasUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\GeneratePassword;
use App\Helpers\Domain;
use App\Helpers\Combell;

class SetHostingAccount
{
    public function handle(AccountWasCreated $event)
    {   
        $domain = new Domain($event->account);
        $password = GeneratePassword::password();
  
        $status = $this->setHosting(['domain' => $domain->getDomain(), 'password' => $password]);
        \Log::debug($status);

        if($status == 202)
        {
            $ftp_user_part = str_replace('.','',$domain->getDomain()); 
            $ftp_user = $ftp_user_part . '@' . $ftp_user_part;
            $ftp_server = 'ftp' . '.' . $domain->getDomain();
            // \Log::debug(['ftp_user' => $ftp_user, 'ftp_server' => $ftp_server, 'ftp_port' => 21, 'ftp_password' => GeneratePassword::password()]);
            $event->account->domain = $domain->getDomain();
            $event->account->password = GeneratePassword::password();
            $event->account->status = $status;
    
            $event->account->save();
        }

        event(new AccountWasUpdated($event->account));
    }
    public function setHosting(Array $account)
    {    
        $body = new \stdClass();
        $body->servicepack_id = 14491;
        $body->identifier = $account['domain'];
        $body->ftp_password = $account['password'];

        if($account['domain'] == 'daan.test12.mtantwerp.eu')
        {
            return Combell::postData(env('CREATE_ACCOUNT_PATH'), $body);
        } else 
        {
            return '202';
        }
    }
}
