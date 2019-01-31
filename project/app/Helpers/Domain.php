<?php

namespace App\Helpers;

use App\Account;

class Domain
{
    public $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }
    public function getDomain()
    { 
      $domain = str_replace( ' ' , '.' , $this->account->name) . '.' . env('DOMAIN_PATH');
      return $domain;  
    }
    
}
