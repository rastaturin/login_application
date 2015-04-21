<?php

namespace Application\Model;

use Application\Component\DB;

class UserRepository {

    /**
     * @var DB
     */
    protected $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function register($email, $pass, $name)
    {
        $salt = rand(1000, 5000);
        $mdpass = User::mdpass($pass, $salt);
        $activation = md5(rand(0, PHP_INT_MAX) . time());
        $query = "INSERT INTO USERS (email, name, mdpass, salt, activation) values ('$email', '$name', '$mdpass', '$salt', '$activation')";
        $this->db->exec($query);
        return $this->load($email);
    }

    /**
     * @param $email
     * @return User
     */
    public function load($email)
    {
        return $this->db->select("SELECT * FROM USERS WHERE email = '$email'", 'Application\Model\User');
    }

    public function activate($activation)
    {
        $this->db->exec("UPDATE USERS SET active=1 where activation = '$activation'");
    }

}