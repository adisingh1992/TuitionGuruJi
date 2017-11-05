<?php
    session_start();
    if(isset($_SESSION["user"])){
        header("Location: dashboard.php");
    }
    if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION["form_id"] === filter_input(INPUT_POST, "form_id", FILTER_SANITIZE_STRING)){
        require_once "includes/authentication.php";
        if(filter_input(INPUT_POST, "form_type", FILTER_SANITIZE_STRING) === "1"){
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $pass = filter_input(INPUT_POST, "password", FILTER_DEFAULT);
            if($auth->login($email, $pass)){
                die("<script>window.location = 'dashboard.php';</script>");
            }else{
                $auth->printMsg();
                die("<script>window.location = 'login.php';</script>");
            }
        }else if(filter_input(INPUT_POST, "form_type", FILTER_SANITIZE_STRING) === "2"){
            $email = filter_input(INPUT_POST, "email1", FILTER_DEFAULT);
            $pass = filter_input(INPUT_POST, "password1", FILTER_DEFAULT);
            $confirm = filter_input(INPUT_POST, "confirm1", FILTER_DEFAULT);
            $code = filter_input(INPUT_POST, "code", FILTER_DEFAULT);
            if($pass === $confirm && $code === $_SESSION["forgot"]){
                $_SESSION["forgot"] = null;
                $auth->forgotPassword($email, $pass);
                $auth->printMsg();
                die("<script>window.location = 'login.php';</script>");
            }
            die("<script>alert('Codes do not match, please try again..!!'); window.location = 'login.php';</script>");
        }
    }else{
        $form_id = md5(rand());
        $_SESSION["form_id"] = $form_id;

        require_once "includes/views.php";

        $view = new Views();
        $view->render("header.html");
        $view->render("login.html", $form_id);
        $view->render("footer.html");
    }
?>