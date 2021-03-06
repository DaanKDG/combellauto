<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('status')->default('created');
            $table->string('package');
            $table->string('domain')->nullable();
            $table->string('password')->nullable();
            $table->string('ftp_user')->nullable();   
            $table->string('ftp_server')->nullable();
            $table->integer('ftp_port')->nullable();     
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
