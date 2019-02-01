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
    private $password;

    public function __construct()
    {
        $this->password = GeneratePassword::password();
    }
    public function handle(AccountWasCreated $event)
    {   
        $domain = new Domain($event->account);
        $domain_name = $domain->getDomain();

        $event->account->update([
            'domain'   => $domain_name,
            'password' => $this->password,
        ]);

        $status = $this->setHosting($event->account);

        if($status == 202)
        {
            $ftp_user_part  = str_replace('.' , '' , $domain_name); 
            $event->account->update([
                'status'     => $status,
                'ftp_user'   => $ftp_user_part . '@' . $ftp_user_part,
                'ftp_server' => 'ftp' . '.' . $domain_name,
                'ftp_port'   => 21
            ]);
        }

        event(new AccountWasUpdated($event->account));
    }
    public function setHosting(Object $account)
    {
        $body = new \stdClass();
        $body->servicepack_id = $account['package'];
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
