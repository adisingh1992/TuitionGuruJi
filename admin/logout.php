<?php
    session_start();
    require_once "includes/authorization.php";

    $auth = new Authentication();

    $auth->logout();
    header("Location: index.php");
?>