<?php
    class imageUpload {
        private $type = array("jpg", "jpeg", "png"), $width = 50, $height = 50, $info = '', $error = '';

        function __construct($file, $dir, $newfile, $width, $height) {
            $this->file = $file;
            $this->dir = $dir;
            $this->newfile = $newfile;
            $this->width = $width;
            $this->height = $height;
            @error_reporting(0);
        }

        public function upload() {
            $ext = explode(".", $this->file['name']);
            $ext = strtolower(end($ext));

            if (file_exists($this->dir . $this->file['name'])) {
                $this->error .= "<script>alert('File already exists!');</script>";
                return false;
            }
            if (!in_array($ext, $this->type)) {
                $this->error .= "<script>alert('File Format not supported');</script>";
                return false;
            }
            list($imwidth, $imheight) = @getimagesize($this->file['tmp_name']);

            $hx = (100 / ($imwidth / $this->width)) * .01;
            $hx = round($imheight * $hx);

            if ($hx < $this->height) {
                $this->height = (100 / ($imwidth / $this->width)) * .01;
                $this->height = round($imheight * $this->height);
            } else {
                $this->width = (100 / ($imheight / $this->height)) * .01;
                $this->width = round($imwidth * $this->width);
            }
            $image = @imagecreatetruecolor($this->width, $this->height);
            if ($ext == "jpg" || $ext == "jpeg") {
                $im = @imagecreatefromjpeg($this->file['tmp_name']);
            } else if ($ext == "gif") {
                $im = @imagecreatefromgif($this->file['tmp_name']);
            } else if ($ext == "png") {
                $im = @imagecreatefrompng($this->file['tmp_name']);
            }

            if (@imagecopyresampled($image, $im, 0, 0, 0, 0, $this->width, $this->height, $imwidth, $imheight)) {
                $this->info .= "<script>alert('Image uploaded successfully..!!');</script>";
            }

            if ($ext == "jpg" || $ext == "jpeg") {
                @imagejpeg($image, $this->dir . $this->newfile, 100);
            } else if ($ext == "gif") {
                @imagegif($image, $this->dir . $this->newfile);
            } else if ($ext == "png") {
                @imagepng($image, $this->dir . $this->newfile, 0);
            }

            @imagedestroy($im);
            return $im;
        }

        public function getInfo() {
            return $this->info;
        }

        public function getError() {
            if (empty($this->error)) {
                $this->error = "<script>alert('Unknown error, please try again..!!'); window.location = 'dashboard.php';</script>";
            }
            return $this->error;
        }

        public static function e($e) {
            echo $e;
        }

    }
?>