<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client as GuzzleClient;
use App\CombellClient;

class GuzzleController extends Controller
{
	protected $api_key;
	protected $api_secret;

	public function __construct()
    {
        $this->api_key = env('API_KEY');
        $this->api_secret = env('API_SECRET');
    }

    public function index() {
    	require base_path() . '\vendor\autoload.php';

        $client = new CombellClient (
		    [
		        'debug' => true,
		        'base_uri' => 'https://api.combell.com',
		        'combell_api_key' => $this->api_key,
		        'combell_api_secret' => $this->api_secret
		    ]
		);

		// Get detail of a hosting account
		$response = $client->get('/v2/kdgautocombell/mtantwerp.eu');

		// Dump response
		var_dump(
		    json_decode($response->getBody()->getContents())
		);

        return view('index');
    }
}