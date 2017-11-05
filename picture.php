<?php
    session_start();
    if (isset($_GET["image"]) && basename($_GET["image"]) == $_GET["image"]){
        $pic_folder = filter_input(INPUT_GET, "image", FILTER_SANITIZE_STRING);
        getImage($pic_folder);
    }else{
        if(isset($_SESSION["user"])){
            $pic_folder = $_SESSION["user"]["id"];
            getImage($pic_folder);
        }
    }
    
    function getImage($pic_folder){
        // Absolute path to image folder
        $image_folder = 'uploads';
        $pic = $image_folder."/".$pic_folder."/profile";
        if (file_exists($pic) && is_readable($pic)){
            // get the filename extension
            $mime = mime_content_type($pic);
            if($mime){
                header('Content-type: ' . $mime);
                header('Content-length: ' . filesize($pic));
                $file = @ fopen($pic, 'rb');
                if($file){
                    fpassthru($file);
                    exit;
                }
            }
        }
    }
?>