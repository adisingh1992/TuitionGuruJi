<?php
    require_once "includes/views.php";

    $view = new Views();
    $view->render("header.html");
    $view->render("howitworks.html");
    $view->render("footer.html");
?>