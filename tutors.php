<?php
    session_start();
    require_once "includes/functions.php";
    require_once "includes/views.php";

    $view = new Views();

    $view->teachers = getAllTeachers();

    $view->render("header.html");
    $view->render("tutors.html");
    $view->render("footer.html");
?>
