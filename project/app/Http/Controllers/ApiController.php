<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\AccountsImport;
use App\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreated;
use App\Helpers\Combell;


class ApiController extends Controller
{
    
    public function index()
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

    public function create(Request $request)
    {
        if ($request->hasFile('file')) {
            $data = [
                'package' => $request->input('package')
            ];
            (new AccountsImport($data))->import($request->file('file'));

            return ['message' => 'Excel has been succesfully uploaded'];
        } 
    }

    public function services()
    {
        return Combell::getData(env('SERVICE_PATH'));
    }

    public function detail($name)
    {
        $domain = str_replace("-", ".", $name);
        $domain .= ".mtantwerp.eu";
        $name = str_replace("-", " ", $name);

        $path_query_details = env('ACCOUNT_PATH') . $domain;
        $uri_details = $path_query_details;

        return Combell::getData($uri_details);
    }
}
