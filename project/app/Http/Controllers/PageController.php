<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hosting;

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

    public function update(Request $request) {
        $hosting = Hosting::where('id','=',$request->hosting_id)->first();
        $hosting->extra_years += 1;
        $hosting->save();

        return redirect('/');
    }
}
