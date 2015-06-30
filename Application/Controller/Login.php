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

        try {
            if (empty($email)) {
                throw new \InvalidArgumentException('Email is empty!');
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException('Email is invalid!');
            }
            if (empty($name)) {
                throw new \InvalidArgumentException('Name is empty!');
            }
            if (empty($pass)) {
                throw new \InvalidArgumentException('Password is empty!');
            }
            if ($this->getUserRepository()->load($email)) {
                throw new \InvalidArgumentException("Email $email is already used!");
            }

            $this->user = $this->getUserRepository()->register($email, $pass, $name);
            if (!$this->sendActivation($this->user)) {
                throw new \Exception("can't send email");
            }
            $this->render('registered');
        } catch (\InvalidArgumentException $e) {
            $this->setVar('error', $e->getMessage());
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
        $link = $this->generateLink($_SERVER["HTTP_HOST"] , $_SERVER["SCRIPT_NAME"], $user->getActivation());
        $this->setVar('link', $link);
        $text = $this->renderPattern('activationMail');
        return $this->sendEmail($user->getEmail(), $subject, $text);
    }

    protected function generateLink($host, $script, $code)
    {
        return sprintf('http://%s$s?action=activation&code=%s', $host, $script, $code);
    }

    protected function sendEmail($email, $subj, $text)
    {
        $headers = [];
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = "Content-type: text/html; charset=utf-8";
        $host = $_SERVER["HTTP_HOST"];
        $headers[] = "From: loginApp <noreply@$host>";
        return mail($email, $subj, $text, implode("\r\n", $headers));
    }
}