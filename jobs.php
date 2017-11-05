<?php
    session_start();
    require_once "includes/functions.php";

    $form_id = md5(rand());
    $_SESSION["form_id"] = $form_id;

    require_once "includes/views.php";

    $view = new Views();

    $jobs = getAllJobs();
    $view->jobs = $jobs;
    $view->area = getAreaDetails();
    $view->class = getClassDetails();

    $view->render("header.html");
    $view->render("jobs.html", $form_id);
    $view->render("footer.html");
?>