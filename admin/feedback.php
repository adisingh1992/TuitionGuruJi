<?php
    session_start();
    
    require_once "includes/views.php";
    require_once "includes/functions.php";
    
    if(!isset($_SESSION["admin"])){
        header("Location: index.php");
    }
    $view = new Views();
    $view->render("header.html");
    $view->feedbacks = getAllFeedbacks();
    $view->render("feedback.html");
    $view->render("footer.html");
?>