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
    	$path_query = 'https://api.combell.com/';
    	$timestamp = time();
    	$nonce = substr(md5(uniqid(mt_rand(), true)), 0, 8);
    	$content = '';

        $valueToSign = $this->api_key
            . $req_method
            . urlencode($path_query)
            . $timestamp
            . $nonce
            . $content;

        $signedValue = hash_hmac('sha256', $valueToSign, $this->api_secret, true);

        $signature = base64_encode($signedValue);

        return sprintf('hmac %s:%s:%s:%s', $this->api_key, $signature, $nonce, $timestamp);
    }
    
    public function index() {

    	require base_path() . '\vendor\autoload.php';

    	// $hmac = $this->hmacHandler();
		// dd($hmac);
		dd($this->getTestData());

        $client = new CombellClient (
		    [
		        'debug' => true,
		        'base_uri' => 'https://api.combell.com',
		        'combell_api_key' => $this->api_key,
		        'combell_api_secret' => $this->api_secret
		    ]
		);

		// Get detail of a hosting account
	
        return view('index');
	}
    public function getTestData() {
        $client = new Client();
        $uri = 'https://api.combell.com/v2/accounts';
        $header = ['headers' => ['Authorization' => $this->hmacHandler()]];
        $res = $client->get($uri, $header);
        return json_decode($res->getBody()->getContents(), true);
	}
}