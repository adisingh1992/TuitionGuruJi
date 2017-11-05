<?php
    session_start();
    if(empty($_POST)){
        header("Location: index.php");
    }
    require_once "includes/functions.php";
    
    $response = "";
    $form_id = filter_input(INPUT_POST, "form_id", FILTER_VALIDATE_INT);
    if($form_id === 1){
        $class = filter_input(INPUT_POST, "class", FILTER_VALIDATE_INT);
        $subjects = getClassSubjects($class);
        foreach($subjects as $subject){
            $response .= "<option value='".$subject["subject_id"]."'>".$subject["subject_name"]."</option>";
        }
        die($response);
    }else if($form_id === 2){
        if(isset($_SESSION["job"])){
            die("You can submit only one job per session. Try again in some time..!!");
        }
        $area = filter_input(INPUT_POST, "area", FILTER_VALIDATE_INT);
        $class = filter_input(INPUT_POST, "class", FILTER_VALIDATE_INT);
        $subject = filter_input(INPUT_POST, "subject", FILTER_VALIDATE_INT);
        $guardian = filter_input(INPUT_POST, "guardian", FILTER_SANITIZE_STRING);
        $contact = filter_input(INPUT_POST, "contact", FILTER_SANITIZE_STRING);
        $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
        $gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_STRING);
        $salary = filter_input(INPUT_POST, "salary", FILTER_SANITIZE_STRING);
        $t_id = filter_input(INPUT_POST, "t_id", FILTER_SANITIZE_STRING);
        $response = setJobDetails($area, $class, $subject, $guardian, $contact, $address, $gender, $salary, $t_id);
        die($response);
    }else if($form_id === 3){
        if(isset($_SESSION["user"])){
            if(isset($_SESSION["job_applied"])){
                die("Slow Down Man..!! You can apply for only one job per session, try again in some time.");
            }
            $job_id = filter_input(INPUT_POST, "job_id", FILTER_VALIDATE_INT);
            $teacher_id = $_SESSION["user"]["id"];
            $response = applyForJob($job_id, $teacher_id);
            die($response);
        }else{
            die("1");
        }
    }else if($form_id === 4){
        $token = md5(rand());
        $email = filter_input(INPUT_POST, "email", FILTER_DEFAULT);
        $subject = 'TuitionGuruJi : Verification Code';
        $message = 'Paste this code into TuitionGuruJi login page '.$token;
        $headers = 'X-Mailer: PHP/' . phpversion();

        if(mail($email, $subject, $message, $headers)){
            $_SESSION["forgot"] = $token;
            die("<script>alert('E-mail sent successfully..!!');</script>");
        }else{
            die("<script>alert('E-mail sending failed');</script>");
        }
    }
?>