<?php
    session_start();
    require_once "includes/functions.php";
    require_once "includes/views.php";
    
    $view = new Views();
    
    if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION["form_id"] === filter_input(INPUT_POST, "form_id", FILTER_SANITIZE_STRING)){
        $area = filter_input(INPUT_POST, "area", FILTER_VALIDATE_INT);
        $class = filter_input(INPUT_POST, "class", FILTER_VALIDATE_INT);
        $subject = filter_input(INPUT_POST, "subject", FILTER_VALIDATE_INT);
        
        $teachers = getTeachers($area, $class, $subject);
        $view->job = getSearchDetails($area, $class, $subject);
        $view->teachers = $teachers;
        $view->render("header.html");
        $view->render("search.html");
        $view->render("footer.html");
    }else{
        $view->area = getAreaDetails();
        $view->class = getClassDetails();

        $view->render("header.html");
        $view->render("post-job.html", $form_id);
        $view->render("footer.html");
    }
?>