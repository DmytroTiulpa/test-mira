<?php

class Model
{
    protected $db = null;

    public function __construct()
    {
        $this->db = DB::connToMYSQL();
    }

    public function securityCheck()
    {
        if (isset($_SESSION['hash'], $_COOKIE['hash']) && $_SESSION['hash'] === $_COOKIE['hash']) {
            $_SESSION['security_check'] = 1;
        } else {
            $this->logout();
        }
    }

    public function startSession($result): bool
    {
        $position= $result[0]['position'];
        $email = $_POST['email'];
        $ip = $_SERVER["REMOTE_ADDR"];
        $user_agent = $_SERVER["HTTP_USER_AGENT"];
        $hash = md5(md5($email.$ip.$user_agent));

        $_SESSION['hash'] = $hash;
        $_SESSION['position'] = $position;
        $_SESSION['email'] = $email;

        setcookie("hash", $hash, time()+3600);

        return true;
    }

    public function logout()
    {
        session_destroy();
        header("Location: /");
    }

}
