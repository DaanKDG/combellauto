<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('vue.index');
    }
    public function create()
    {
        return view('create');
    }
    public function status()
    {
        return view('status');
    }
}
