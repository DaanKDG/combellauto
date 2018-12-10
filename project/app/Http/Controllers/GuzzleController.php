<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client as GuzzleClient;
use App\CombellClient;
use GuzzleHttp\Client;

class GuzzleController extends Controller
{
	protected $api_key;
	protected $api_secret;

	public function __construct()
    {
        $this->api_key = env('API_KEY');
        $this->api_secret = env('API_SECRET');
    }

    protected function hmacHandler($req_method, $path_query, $content='') {
    	$key = $this->api_key;
    	$req_method = $req_method;
    	$path_query = $path_query;
    	$timestamp = time();
    	$nonce = rand(100000, 900000);
    	$content = '';

        $valueToSign = $this->api_key . $req_method . urlencode($path_query) . $timestamp . $nonce . $content;
	
		$signedValue = hash_hmac('sha256', $valueToSign, $this->api_secret, true);
			
		$signature = base64_encode($signedValue);
			
		return sprintf('hmac %s:%s:%s:%s', $this->api_key, $signature, $nonce, $timestamp);
        
    }
    
    public function index() {
        //get all accounts
        $req_method = 'get';
        $path_query = '/v2/linuxhostings?take=200';
        $uri = 'https://api.combell.com' . $path_query;

        $hmac = $this->hmacHandler($req_method, $path_query);
        $data = $this->getData($hmac, $uri);

        //filter out only mtantwerp.eu domains
        $all_accounts = [];
        foreach ($data as $account) {
            $domain = $account["domain_name"];

            if (strpos($domain, 'mtantwerp.eu') !== false) {
                //add 'name' to data
                $name = str_replace(".mtantwerp.eu", "", $domain);
                $name = str_replace(".", "-", $name);
                $account['name'] = $name;
                array_push($all_accounts, $account);
            }
        }

        //return view
        return view('index')->with('accounts', $all_accounts);
	}

    public function getData($hmac, $uri) {
        $client = new Client();
        $header = ['headers' => ['Authorization' => $hmac]];
        $res = $client->get($uri, $header);
        return json_decode($res->getBody()->getContents(), true);
	}
}