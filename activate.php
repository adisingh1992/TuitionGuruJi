<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        require_once "includes/authentication.php";
        $email = filter_input(INPUT_GET, "email", FILTER_SANITIZE_EMAIL);
        $token = filter_input(INPUT_GET, "token", FILTER_SANITIZE_STRING);
        if($auth->emailActivation($email, $token)){
            $auth->printMsg();
            die("<script>window.location = 'login.php';</script>");
        }else{
            $auth->printMsg();
            die("<script>window.location = 'register.php';</script>");
        }
    }
?>