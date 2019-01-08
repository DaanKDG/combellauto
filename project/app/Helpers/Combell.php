<?php

namespace App\Helpers;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client as GuzzleClient;
use App\CombellClient;
use GuzzleHttp\Client;

class Combell 
{
    public static function getData($path_query)
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

    public static function postData($path_query, $body)
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
