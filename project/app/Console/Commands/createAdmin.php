<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class createAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an admin account for admin panel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->ask('What is your email?');
        $password = $this->secret('Choose a password');
        
       $user = User::create([
                'email' => $email,
                'password' => Hash::make($password),
        ]);
       
    }
}
