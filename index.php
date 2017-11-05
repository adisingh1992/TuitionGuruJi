<?php
    session_start();
    
    require_once "includes/views.php";
    require_once "includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION["form_id"] === filter_input(INPUT_POST, "form_id", FILTER_SANITIZE_STRING)){
        $fname = filter_input(INPUT_POST, "fname", FILTER_SANITIZE_STRING);
        $lname = filter_input(INPUT_POST, "lname", FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
        $topic = filter_input(INPUT_POST, "topic", FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_STRING);
        die(setFeedback($fname, $lname, $email, $topic, $message));
    }else{
        $form_id = md5(rand());
        $_SESSION["form_id"] = $form_id;

        $view = new Views();
        $view->render("header.html");
        $view->area = getAreaDetails();
        $view->class = getClassDetails();
        $view->teachers = getAllTeachers();
        $view->render("index.html", $form_id);
        $view->render("footer.html");
    }
?>