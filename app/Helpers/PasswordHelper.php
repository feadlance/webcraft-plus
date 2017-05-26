<?php

namespace App\Helpers;

use Hash;

class PasswordHelper
{
    protected $encryption;

    public function __construct($encryption)
    {
        $this->encryption = $encryption;
    }

    public function hash($password)
    {
        $result = bcrypt($password);

        if ( $this->encryption === 'md5' ) {
            $result = md5($password);
        }

        if ( $this->encryption === 'sha256' ) {
            $random = str_random(16);
            
            $result = '$SHA$' . $random . '$' . hash('sha256', hash('sha256', $password) . $random);
        }

        return $result;
    }

    public function check($salt, $password)
    {
        if ( $this->encryption === 'md5' && $password === md5($salt) ) {
            $successLogin = true;  
        }

        if ( $this->encryption === 'bcrypt' && Hash::check($salt, $password) ) {
            $successLogin = true;
        }

        if ( $this->encryption === 'sha256' ) {
            $splitPassword = explode('$', $password);

            if ( isset($splitPassword[1]) && $splitPassword[1] === 'SHA' ) {
                $hash = '$SHA$' . $splitPassword[2] . '$' . hash('sha256', hash('sha256', $salt) . $splitPassword[2]);

                if ( $password === $hash ) {
                    $successLogin = true;
                }
            }
        }

        return isset($successLogin);
    }
}