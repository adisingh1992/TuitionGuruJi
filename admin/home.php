<?php
    session_start();
    
    if(!isset($_SESSION["admin"])){
        header("Location: index.php");
    }
    if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION["admin_form_id"] === filter_input(INPUT_POST, "form_id", FILTER_SANITIZE_STRING)){
        require_once "includes/authorization.php";
        
        $auth = new Authentication();
        $auth->dbConnect(conString, dbUser, dbPass);

        $auth->passwordChange($_SESSION["admin"]["id"], filter_input(INPUT_POST, "password", FILTER_DEFAULT));
        $auth->printMsg();
        die("<script>window.location = 'home.php';</script>");
    }else{
        $form_id = md5(rand());
        $_SESSION["admin_form_id"] = $form_id;

        require_once "includes/views.php";

        $view = new Views();
        
        $view->render("header.html");
        $view->render("home.html", $form_id);
        $view->render("footer.html");
    }
?>