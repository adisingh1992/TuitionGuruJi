<?php
    require_once "database.php";

    function getLatestJobs(){
        $db = new Db();
        $query = "SELECT job_id, area_name, class_name, subject_name, CONCAT(users.fname, ' ', users.lname) AS name, user_details.contact AS t_contact, guardian, job.contact, job.address, job.gender, job.salary FROM job INNER JOIN users ON job.teacher_id = users.id INNER JOIN user_details ON job.teacher_id = user_details.id INNER JOIN area ON job.area_id = area.area_id INNER JOIN class ON job.class_id = class.class_id INNER JOIN subject ON job.subject_id = subject.subject_id WHERE job.status = 0 AND users.user_role != 0 ORDER BY job_id desc";
        return $db->select($query);
    }

    function jobVerified($job_id){
        $db = new Db();
        $job_id = $db->escape($job_id);
        $query = "UPDATE job SET status = 1 WHERE job_id = ".$job_id;
        return $db->query($query);
    }

    function getVerifiedJobs(){
        $db = new Db();
        $query = "SELECT job_id, area_name, class_name, subject_name, CONCAT(users.fname, ' ', users.lname) AS name, user_details.contact AS t_contact, guardian, job.contact, job.address, job.gender, job.salary FROM job INNER JOIN users ON job.teacher_id = users.id INNER JOIN user_details ON job.teacher_id = user_details.id INNER JOIN area ON job.area_id = area.area_id INNER JOIN class ON job.class_id = class.class_id INNER JOIN subject ON job.subject_id = subject.subject_id WHERE job.status = 1 AND users.user_role != 0 ORDER BY job_id desc";
        return $db->select($query);
    }
    
    function jobCompleted($job_id){
        $db = new Db();
        $job_id = $db->escape($job_id);
        $query = "UPDATE job SET status = 2 WHERE job_id = ".$job_id;
        return $db->query($query);
    }

    function getAllJobs(){
        $db = new Db();
        $query = "SELECT job_id, area_name, class_name, subject_name, CONCAT(users.fname, ' ', users.lname) AS name, user_details.contact AS t_contact, guardian, job.contact, job.address, job.gender, job.salary FROM job INNER JOIN users ON job.teacher_id = users.id INNER JOIN user_details ON job.teacher_id = user_details.id INNER JOIN area ON job.area_id = area.area_id INNER JOIN class ON job.class_id = class.class_id INNER JOIN subject ON job.subject_id = subject.subject_id WHERE users.user_role != 0 and job.status = 2 ORDER BY job_id desc";
        return $db->select($query);
    }
    
    function getLatestUsers(){
        $db = new Db();
        $query = "SELECT users.id, fname, lname FROM users INNER JOIN user_details ON users.id = user_details.id WHERE user_role != 0 GROUP BY users.id desc";
        return $db->select($query);
    }
    
    function getUser($id){
        $db = new Db();
        $id = $db->escape($id);
        $query = "SELECT * FROM users INNER JOIN user_details ON users.id = user_details.id WHERE users.id = ".$id;
        return $db->select($query);
    }

    function deleteUser($id){
        $db = new Db();
        $id = $db->escape($id);
        $query = "UPDATE users SET user_role = 0 WHERE id = ".$id;
        return $db->query($query);
    }
    
    function getAllFeedbacks(){
        $db = new Db();
        $query = "SELECT feedback_id, CONCAT(fname, ' ', lname) AS name, email, topic, message FROM feedback ORDER BY feedback_id desc;";
        return $db->select($query);
    }
    
    function getAppliedJobs($id){
        $db = new Db();
        $id = $db->escape($id);
        $query = "SELECT job.job_id, area_name, class_name, subject_name FROM job INNER JOIN area ON job.area_id = area.area_id INNER JOIN class ON job.class_id = class.class_id INNER JOIN subject ON job.subject_id = subject.subject_id INNER JOIN job_applied ON job.job_id = job_applied.job_id WHERE job_applied.teacher_id = ".$id." ORDER BY job.job_id desc";
        return $db->select($query);
    }
?>