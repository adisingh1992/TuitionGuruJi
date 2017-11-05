<?php
    session_start();
    if(isset($_SESSION["user"])){
        header("Location: dashboard.php");
    }
    if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION["form_id"] === filter_input(INPUT_POST, "form_id", FILTER_SANITIZE_STRING)){
        require_once "includes/authentication.php";
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $fname = filter_input(INPUT_POST, "fname", FILTER_SANITIZE_STRING);
        $lname = filter_input(INPUT_POST, "lname", FILTER_SANITIZE_STRING);
        $pass = filter_input(INPUT_POST, "password", FILTER_DEFAULT);
        if($auth->registration($email, $fname, $lname, $pass)) {
            die("<script>alert('A confirmation mail has been sent, please confirm your account registration!'); window.location = 'login.php';</script>");
        }else{
            $auth->printMsg();
            die("<script>window.location = 'register.php';</script>");
        }
    }else{
        $form_id = md5(rand());
        $_SESSION["form_id"] = $form_id;

        require_once "includes/views.php";

        $view = new Views();
        $view->render("header.html");
        $view->render("register.html", $form_id);
        $view->render("footer.html");
    }
?>