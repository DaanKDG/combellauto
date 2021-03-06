<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['name', 'email', 'status', 'package', 'domain', 'password', 'ftp_user', 'ftp_server', 'ftp_port'];
}
