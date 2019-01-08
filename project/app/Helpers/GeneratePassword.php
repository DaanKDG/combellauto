<?php

namespace App\Helpers;

use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;

class GeneratePassword
{
    public function __construct()
    {

    }
    
    public static function Password()
    {
        $generator = new ComputerPasswordGenerator();
        $generator->setUppercase()->setLowercase()->setNumbers()->setSymbols(false)->setLength(20);
        $password = $generator->generatePassword();

        return $password;
    }
}