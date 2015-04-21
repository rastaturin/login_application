<?php

namespace Application\Model;

class User {

    protected $name, $email, $activation, $mdpass, $salt;

    public static function mdpass($pass, $salt)
    {
        return md5($pass . $salt);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getActivation()
    {
        return $this->activation;
    }

    public function login($pass)
    {
        return $this->mdpass == self::mdpass($pass, $this->salt);
    }

}