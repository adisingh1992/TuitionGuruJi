<?php
    session_start();
    if(!isset($_SESSION["user"])){
        header("Location: login.php");
    }
    require_once "includes/functions.php";
    if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION["form_id"] === filter_input(INPUT_POST, "form_id", FILTER_SANITIZE_STRING)){
        if(filter_input(INPUT_POST, "form_type", FILTER_DEFAULT) === '1'){
            if(!isset($_FILES['profile']) || !isset($_FILES['id-proof']) || !isset($_FILES['edu-proof'])){
                die("<script>alert('Please provide valid images..!!'); window.location = 'dashboard.php';</script>");
            }
            $contact = filter_input(INPUT_POST, "contact", FILTER_VALIDATE_INT);
            $gender = filter_input(INPUT_POST, "gender", FILTER_DEFAULT);
            $address = filter_input(INPUT_POST, "address", FILTER_DEFAULT);
            $exp = filter_input(INPUT_POST, "experience", FILTER_DEFAULT);
            $salary = filter_input(INPUT_POST, "salary", FILTER_DEFAULT);
            $bio = filter_input(INPUT_POST, "bio", FILTER_DEFAULT);
            $quali = filter_input(INPUT_POST, "qualification", FILTER_DEFAULT);
            $area = $_POST["area"];
            $class = $_POST["class"];
            $subject = $_POST["subject"];
            uploadDocuments($_FILES["profile"], "profile", 100, 100);
            uploadDocuments($_FILES["id-proof"], "id-proof", 800, 800);
            uploadDocuments($_FILES["edu-proof"], "edu-proof", 800, 800);
            echo setUserDetails($_SESSION["user"]["id"], $contact, $gender, $address, $exp, $salary, $bio, $quali, $area, $class, $subject);
        }else{
            require_once "includes/authentication.php";
            $auth->passwordChange($_SESSION["user"]["id"], filter_input(INPUT_POST, "password", FILTER_DEFAULT));
            $auth->printMsg();
        }
        die("<script>window.location = 'dashboard.php';</script>");
    }else{
        $form_id = md5(rand());
        $_SESSION["form_id"] = $form_id;
        require_once "includes/views.php";
        $view = new Views();
        if($_SESSION["user"]["user_role"] === '2'){
            $user_details = getUserDetails();
            $view->user_details = $user_details;
            $view->jobs = getAppliedJobs($_SESSION["user"]["id"]);
            $view->render("header.html");
            $view->render("dashboard.html", $form_id);
            $view->render("footer.html");
        }else{
            $view->area = getAreaDetails();
            $view->render("header.html");
            $view->render("update-profile.html", $form_id);
            $view->render("footer.html");
        }
    }
?>