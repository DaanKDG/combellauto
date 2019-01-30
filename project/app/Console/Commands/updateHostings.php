<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Combell;
use App\Hosting;

class updateHostings extends Command
{
    protected $signature = 'update:hosting';
    protected $description = 'Create or update hostings';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $hostings = collect($this->getHostings());
        
        $hostings
            ->each(function($hosting, $key) {
                Hosting::updateOrCreate([
                    'domain'      => $hosting['domain_name']
                ],[
                    'servicepack' => $hosting['servicepack_id'],
                    'name'        => $hosting['name']
                ]);
        });
    }

    protected function getHostings()
    {
        $accounts = collect(Combell::getData(env('ACCOUNT_PATH') . '?take=200'))->map(function ($account, $key) {
            $domain = $account['domain_name'];

            if (strpos($domain, 'mtantwerp.eu') !== false) {
                $name = str_replace('.mtantwerp.eu', '', $domain);
                $name = str_replace('.', '-', $name);
                $account['name'] = $name;

                return $account;
            }
        })->filter()->all();

        return $accounts;
    }
}
