<?php
    session_start();

    require_once "includes/views.php";
    require_once "includes/functions.php";
    require_once "includes/views.php";
    
    if(!isset($_SESSION["admin"])){
        header("Location: index.php");
    }

    $view = new Views();
    $view->render("header.html");
    $view->users = getLatestUsers();
    $view->render("verify-users.html");
    $view->render("footer.html");
?>