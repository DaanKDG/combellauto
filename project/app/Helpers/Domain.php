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
      $domain = preg_replace('/\s+/', '.', mb_strtolower($this->account->name . '.' . env('DOMAIN_PATH')));
      return $domain;  
    }
    
}
