<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client as GuzzleClient;
use App\CombellClient;
use GuzzleHttp\Client;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use App\Imports\AccountsImport;
use App\Account;
use Illuminate\Http\RedirectResponse;


class ApiController extends Controller
{
    public function index()
    {
        $accounts = collect($this->getData(env('ACCOUNT_PATH') . '?take=200'))->map(function ($account, $key) {
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
            // should redirect before my AccountsImport, after redirect launch import
            (new AccountsImport($data))->import($request->file('file'));
            
            return ['message' => 'Excel has been succesfully uploaded'];
        } 
    }

    public function services()
    {
        return $this->getData(env('SERVICE_PATH'));
    }

    public function detail($name)
    {
        $domain = str_replace("-", ".", $name);
        $domain .= ".mtantwerp.eu";
        $name = str_replace("-", " ", $name);

        $path_query_details = env('ACCOUNT_PATH') . $domain;
        $uri_details = $path_query_details;

        return $this->getData($uri_details);
    }

    public function getData($path_query)
    {
        $client = new \Combell\Client(
            [
                'base_uri' => env('BASE_URI'),
                'combell_api_key' => env('API_KEY'),
                'combell_api_secret' => env('API_SECRET')
            ]
        );
        $res = $client->get($path_query);
        return json_decode($res->getBody()->getContents(), true);
    }

    public function postData($path_query, $body)
    {
        $client = new \Combell\Client(
            [
                'base_uri' => env('BASE_URI'),
                'combell_api_key' => env('API_KEY'),
                'combell_api_secret' => env('API_SECRET')
            ]
        );
        $res = $client->post($path_query, ['json' => $body]);
        return $res->getStatusCode();
    }
}
