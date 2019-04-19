<?php
    session_start();

    require_once "includes/views.php";
    require_once "includes/functions.php";
    
    if(!isset($_SESSION["admin"])){
        header("Location: index.php");
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($_SESSION["admin_form_id"] === filter_input(INPUT_POST, "form_id", FILTER_SANITIZE_STRING)){
            $user_id = filter_input(INPUT_POST, "user_id", FILTER_VALIDATE_INT);
            $result = deleteUser($user_id);
            if($result){
                die("<script>alert('User deleted successfully..!!'); window.location = 'verify-users.php';</script>");
            }else{
                die("<script>alert('Cannot delete user at the moment, Please try again..!!'); window.location = 'verify-users.php';</script>");
            }
        }
    }else{
        $form_id = md5(rand());
        $_SESSION["admin_form_id"] = $form_id;

        require_once "includes/views.php";

        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        
        $view = new Views();
        $view->render("header.html");
        $view->user = getUser($id);
        $view->jobs = getAppliedJobs($id);
        $view->areas = getAllAreasForUser($id);
        $view->classes = getAllClassesForUser($id);
        $view->render("user.html", $form_id);
        $view->render("footer.html");
    }
?>
