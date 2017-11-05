<?php
    session_start();

    require_once "includes/views.php";
    require_once "includes/functions.php";
    
    if(!isset($_SESSION["admin"])){
        header("Location: index.php");
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($_SESSION["admin_form_id"] === filter_input(INPUT_POST, "form_id", FILTER_SANITIZE_STRING)){
            $job_id = filter_input(INPUT_POST, "job_id", FILTER_VALIDATE_INT);
            $result = jobVerified($job_id);
            if($result){
                die("Job verified successfully..!!");
            }else{
                die("Cannot update details at the moment, Please try again..!!");
            }
        }
    }else{
        $form_id = md5(rand());
        $_SESSION["admin_form_id"] = $form_id;

        require_once "includes/views.php";

        $view = new Views();
        $view->render("header.html");
        $view->jobs = getLatestJobs();
        $view->render("verify-jobs.html", $form_id);
        $view->render("footer.html");
    }
?>