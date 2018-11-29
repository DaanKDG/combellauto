<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuzzleController extends Controller
{
    public function index()
    {
        $env = env('API_KEY');

        return view('layouts.index');
    }
}
