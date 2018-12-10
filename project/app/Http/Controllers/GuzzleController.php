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

    protected function hmacHandler() {
    	$key = $this->api_key;
    	$req_method = 'get';
    	$path_query = '/v2/accounts';
    	$timestamp = time();
    	$nonce = rand(100000, 900000);
    	$content = '';

        $valueToSign = $this->api_key . $req_method . urlencode($path_query) . $timestamp . $nonce . $content;
	
		$signedValue = hash_hmac('sha256', $valueToSign, $this->api_secret, true);
			
		$signature = base64_encode($signedValue);
			
		return sprintf('hmac %s:%s:%s:%s', $this->api_key, $signature, $nonce, $timestamp);
        
    }
    
    public function index() {
	
		$hmac = $this->hmacHandler();
		dd($this->getTestData($hmac));
	}
    public function getTestData($hmac) {
        $client = new Client();
        $uri = 'https://api.combell.com/v2/accounts';
        $header = ['headers' => ['Authorization' => $hmac]];
        $res = $client->get($uri, $header);
        return json_decode($res->getBody()->getContents(), true);
	}
}