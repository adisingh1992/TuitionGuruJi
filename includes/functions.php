<?php
    require_once "database.php";
    
    function getUserDetails(){
        $db = new Db();
        $query = "SELECT * FROM user_details WHERE id = ".$_SESSION["user"]["id"];
        return $db->select($query);
    }
    
    function setUserDetails($id, $contact, $gender, $address, $exp, $salary, $bio, $quali, $area, $class, $subject){
        $db = new Db();
        $conn = $db->connect();
        $db->disableCommit();
        $query = "INSERT INTO user_details(id, contact, bio, address, gender, salary, experience, qualification) VALUES(?,?,?,?,?,?,?,?);";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssss", $id, $contact, $bio, $address, $gender, $salary, $exp, $quali);
        if($stmt->execute()){
            $db->query("UPDATE users SET user_role = 2 WHERE id = $id");
            $_SESSION["user"]["user_role"] = '2';
            setUserArea($db, $conn, $area);
            setClassSubject($db, $conn, $class, $subject);
            $db->commit();
            return "<script>alert('Your details have been successfully updated..!!');</script>";
        }
        $db->rollback();
        return "<script>alert('Details not updated, please try again..!!');</script>";
    }
    
    function setUserArea($db, $conn, $area){
        $id = $_SESSION["user"]["id"];
        foreach($area as $a){
            $query = "INSERT INTO teacher_area(user_id, area_id) VALUES(?,?)";
            $st = $conn->prepare($query);
            $temp = (htmlspecialchars($a));
            $st->bind_param("ss", $id, $temp);
            if(!$st->execute()){
                $db->rollback();
                die("<script>alert('Please provide valid data..!!');</script>");
            }
        }
    }
    
    function setClassSubject($db, $conn, $class, $subject){
        $id = $_SESSION["user"]["id"];
        $class_len = count($class);
        $subject_len = count($subject);
        if($class_len < 1 || $class_len != $subject_len){
            $db->rollback();
            die("<script>alert('Please provide valid data..!!');</script>");
        }
        for($i=0; $i<$class_len; $i++){
            $query = "INSERT INTO teacher_class_subject(user_id, class_id, subject_id) VALUES(?,?,?)";
            $st = $conn->prepare($query);
            $c = (htmlspecialchars($class[$i]));
            $s = (htmlspecialchars($subject[$i]));
            $st->bind_param("sss", $id, $c, $s);
            $st->execute();
        }
    }
    
    function uploadDocuments($file, $newfile, $width, $height){
        require_once "imageUpload.php";
        $dir = "uploads/".$_SESSION["user"]["id"];
        if(!is_dir($dir)){
            mkdir($dir, 0755, true);
        }
        $uploader = new imageUpload($file, $dir."/", $newfile, $width, $height);
        $uploader->upload();
        $result = $uploader->getInfo();
        if(empty($result)){
            $uploader->getError();
        }
    }
    
    function getAreaDetails(){
        $db = new Db();
        $query = "SELECT area_id, area_name FROM area";
        return $db->select($query);
    }
    
    function getClassDetails(){
        $db = new Db();
        $query = "SELECT class_id, class_name FROM class";
        return $db->select($query);
    }
    
    function getClassSubjects($class){
        $db = new Db();
        $class = $db->escape($class);
        $query = "SELECT subject.subject_id, subject_name FROM subject INNER JOIN class_subject ON subject.subject_id = class_subject.subject_id INNER JOIN class ON class_subject.class_id = class.class_id WHERE class.class_id = ".$class;
        return $db->select($query);
    }
    
    function getTeachers($area, $class, $subject){
        $db = new Db();
        $area = $db->escape($area);
        $class = $db->escape($class);
        $subject = $db->escape($subject);
        $query = "SELECT users.id, CONCAT(users.fname, ' ', users.lname) AS name, bio, gender, experience, qualification FROM users INNER JOIN user_details ON users.id = user_details.id INNER JOIN teacher_area ON users.id = teacher_area.user_id INNER JOIN area ON teacher_area.area_id = area.area_id INNER JOIN teacher_class_subject ON users.id = teacher_class_subject.user_id INNER JOIN class ON teacher_class_subject.class_id = class.class_id INNER JOIN subject ON teacher_class_subject.subject_id = subject.subject_id WHERE area.area_id = ".$area." AND class.class_id = ".$class." AND subject.subject_id = ".$subject." AND users.user_role != 0 GROUP BY users.id;";
        return $db->select($query);
    }
    
    function getAllTeachers(){
        $db = new Db();
        $query = "SELECT users.id, CONCAT(users.fname, ' ', users.lname) AS name, bio, gender, experience, qualification FROM users INNER JOIN user_details ON users.id = user_details.id INNER JOIN teacher_area ON users.id = teacher_area.user_id INNER JOIN area ON teacher_area.area_id = area.area_id INNER JOIN teacher_class_subject ON users.id = teacher_class_subject.user_id INNER JOIN class ON teacher_class_subject.class_id = class.class_id INNER JOIN subject ON teacher_class_subject.subject_id = subject.subject_id AND users.user_role != 0 GROUP BY users.id desc limit 10;";
        return $db->select($query);
    }
    
    function getSearchDetails($area, $class, $subject){
        $db = new Db();
        $area = $db->escape($area);
        $class = $db->escape($class);
        $subject = $db->escape($subject);
        $query = "SELECT area.area_id, area.area_name, class.class_id, class.class_name, subject.subject_id, subject.subject_name FROM area, class, subject WHERE area.area_id = ".$area." AND class.class_id = ".$class." AND subject.subject_id = ".$subject.";";
        return $db->select($query);
    }
    
    function setJobDetails($area, $class, $subject, $guardian, $contact, $address, $gender, $salary, $t_id){
        $db = new Db();
        $area = $db->escape($area);
        $class = $db->escape($class);
        $subject = $db->escape($subject);
        $guardian = $db->escape($guardian);
        $contact = $db->escape($contact);
        $address = $db->escape($address);
        $gender = $db->escape($gender);
        $salary = $db->escape($salary);
        $t_id = $db->escape($t_id);
        $query = "INSERT INTO job(area_id, class_id, subject_id, teacher_id, guardian, contact, address, gender, salary) VALUES(?,?,?,?,?,?,?,?,?)";
        $conn = $db->connect();
        $st = $conn->prepare($query);
        $st->bind_param("sssssssss", $area, $class, $subject, $t_id, $guardian, $contact, $address, $gender, $salary);
        if($st->execute()){
            $_SESSION["job"] = 1;
            return "We've recieved your request successfully, Someone from our team will contact you soon..!!";
        }else{
            return "Something went wrong, please try again in sometime..!!";
        }
    }
    
    function getAllJobs(){
        $db = new Db();
        $query = "SELECT job_id, job.area_id, job.salary, job.guardian, job.class_id, job.subject_id, area_name, class_name, subject_name, gender FROM job INNER JOIN area ON job.area_id = area.area_id INNER JOIN class ON job.class_id = class.class_id INNER JOIN subject ON job.subject_id = subject.subject_id ORDER BY job.job_id desc LIMIT 25";
        return $db->select($query);
    }
    
    function applyForJob($job_id, $teacher_id){
        $db = new Db();
        $job_id = $db->escape($job_id);
        $teacher_id = $db->escape($teacher_id);
        $query = "INSERT INTO job_applied(job_id, teacher_id) VALUES(".$job_id.", ".$teacher_id.")";
        if($db->query($query)){
            $_SESSION["job_applied"] = 1;
            return "You have successfully applied for the job, Someone from our team will contact you soon..!!";
        }else{
            return "Something went wrong, please try again in sometime..!!";
        }
    }
    
    function setFeedback($fname, $lname, $email, $topic, $message){
        $db = new Db();
        $fname = $db->escape($fname);
        $lname = $db->escape($lname);
        $email = $db->escape($email);
        $topic = $db->escape($topic);
        $message = $db->escape($message);
        $query = "INSERT INTO feedback(fname, lname, email, topic, message) VALUES('".$fname."', '".$lname."', '".$email."', '".$topic."', '".$message."')";
        if($db->query($query)){
            return "Thanks for your feedback, Someone from our team will contact you soon..!!";
        }else{
            return "Oops, cannot accept your feedback at the moment, please try again in sometime..!!";
        }
    }
    
    function getAppliedJobs($id){
        $db = new Db();
        $id = $db->escape($id);
        $query = "SELECT job.job_id, area_name, class_name, subject_name FROM job INNER JOIN area ON job.area_id = area.area_id INNER JOIN class ON job.class_id = class.class_id INNER JOIN subject ON job.subject_id = subject.subject_id INNER JOIN job_applied ON job.job_id = job_applied.job_id WHERE job_applied.teacher_id = ".$id." ORDER BY job.job_id desc";
        return $db->select($query);
    }
?>