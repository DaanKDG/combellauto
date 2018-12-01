<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\HmacHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client as GuzzleClient;

class CombellClient extends GuzzleClient
{
    public function __construct(array $config = [])
    {
        if (isset($config['handler_stack']) && $config['handler_stack'] instanceof HandlerStack) {
            $handlerStack = $config['handler_stack'];
        } else {
            $handlerStack = HandlerStack::create();
        }
        $handlerStack->push(
            new HmacHandler(env('API_KEY'), env('API_SECRET'))
        );
        $config['handler'] = $handlerStack;
        
        parent::__construct($config);
    }
}
