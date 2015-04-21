<?php

namespace Application\Controller;

use Application\Model\User;
use Application\Model\UserRepository;

class Login extends Base {

    protected $userRep;
    protected $user;

    public function indexAction()
    {
        $this->render('loginForm');
    }

    public function registerFormAction()
    {
        $this->render('registerForm');
    }

    public function registerAction()
    {
        $email = $this->param('email');
        $name = $this->param('name');
        $pass = $this->param('password');

        $errors = [];
        if (empty($email)) {
            $errors[] = 'Email is empty!';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email is invalid!';
        }
        if (empty($name)) {
            $errors[] = 'Name is empty!';
        }
        if (empty($pass)) {
            $errors[] = 'Password is empty!';
        }
        if ($this->getUserRepository()->load($email)) {
            $errors[] = "Email $email is already used!";
        }

        if (empty($errors)) {
            $this->user = $this->getUserRepository()->register($email, $pass, $name);
            $this->sendActivation($this->user);
            $this->render('registered');
        } else {
            $this->setVar('error', join(' ', $errors));
            $this->render('registerForm');
        }
    }

    public function activationAction()
    {
        $activation = $this->param('code');
        $this->getUserRepository()->activate($activation);
        $this->render('activation');
    }

    public function loginAction()
    {
        $email = $this->param('email');
        $pass = $this->param('pass');
        $user = $this->getUserRepository()->load($email);
        if (isset($user) && $user->login($pass)) {
            $this->json(['result' => 'ok', 'name' => $user->getName()]);
        } else {
            $this->json(['result' => 'fail']);
        }
    }

    /**
     * @return UserRepository
     */
    protected function getUserRepository()
    {
        if (empty($this->userRep)) {
            $this->userRep = new UserRepository($this->db);
        }
        return $this->userRep;
    }

    protected function sendActivation(User $user)
    {
        $subject = "Activation";
        $link = $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"] . "?action=activation&code=" . $user->getActivation();
        $this->setVar('link', $link);
        $text = $this->renderPattern('activationMail');
        $this->sendEmail($user->getEmail(), $subject, $text);
    }

    protected function sendEmail($email, $subj, $text)
    {
        $headers = [];
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = "Content-type: text/html; charset=utf-8";
        return mail($email, $subj, $text, implode("\r\n", $headers));
    }
}