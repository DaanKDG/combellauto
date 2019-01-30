<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\AccountsImport;
use App\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreated;
use App\Helpers\Combell;
use App\Hosting;
use App\Console\Commands\UpdateHostings;


class ApiController extends Controller
{
    public function index()
    {    
        return Hosting::all();
    }
    public function updateApi() 
    {
        dispatch(new updateHostings());
        return Hosting::all();
    }

    public function create(Request $request)
    {
        if ($request->hasFile('file')) {
            $data = [
                'package' => $request->input('package')
            ];
            (new AccountsImport($data))->import($request->file('file'));

            return ['message' => 'Excel has been succesfully uploaded'];
        } 
    }

    public function services()
    {
        return Combell::getData(env('SERVICE_PATH'));
    }

    public function detail($name)
    {
        $domain = str_replace("-", ".", $name);
        $domain .= ".mtantwerp.eu";
        $name = str_replace("-", " ", $name);

        $path_query_details = env('ACCOUNT_PATH') . $domain;
        $uri_details = $path_query_details;

        return Combell::getData($uri_details);
    }
}
