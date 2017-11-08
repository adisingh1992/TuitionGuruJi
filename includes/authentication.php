<?php
    require_once 'database.php';

    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $auth = new Authentication();
    $auth->dbConnect(conString, dbUser, dbPass);

    class Authentication{
        /** @var object $pdo Copy of PDO connection */
        private $pdo;
        /** @var object of the logged in user */
        private $user;
        /** @var string error msg */
        private $msg;
        /** @var int number of permitted wrong login attemps */
        private $permitedAttempts = 5;

        /**
        * Connection init function
        * @param string $conString DB connection string.
        * @param string $user DB user.
        * @param string $pass DB password.
        *
        * @return bool Returns connection success.
        */
        public function dbConnect($conString, $user, $pass){
            if(session_status() === PHP_SESSION_ACTIVE){
                try {
                    $pdo = new PDO($conString, $user, $pass);
                    $this->pdo = $pdo;
                    return true;
                }catch(PDOException $e) { 
                    $this->msg = 'Connection did not work out!';
                    return false;
                }
            }else{
                $this->msg = 'Session did not start.';
                return false;
            }
        }

        /**
        * Return the logged in user.
        * @return user array data
        */
        public function getUser(){
            return $this->user;
        }

        /**
        * Login function
        * @param string $email User email.
        * @param string $password User password.
        *
        * @return bool Returns login success.
        */
        public function login($email, $password){
            if(is_null($this->pdo)){
                $this->msg = 'Connection did not work out!';
                return false;
            }else{
                $pdo = $this->pdo;
                $stmt = $pdo->prepare('SELECT id, fname, lname, email, wrong_logins, password, user_role FROM users WHERE email = ? and confirmed = 1 and user_role != 0 limit 1');
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if(password_verify($password, $user['password'])){
                    if($user['wrong_logins'] <= $this->permitedAttempts){
                        $this->registerCorrectLoginAttempt($email);
                        $this->user = $user;
                        session_regenerate_id();
                        $_SESSION['user']['id'] = $user['id'];
                        $_SESSION['user']['fname'] = $user['fname'];
                        $_SESSION['user']['lname'] = $user['lname'];
                        $_SESSION['user']['email'] = $user['email'];
                        $_SESSION['user']['user_role'] = $user['user_role'];
                        return true;
                    }else{
                        $this->msg = 'This user account is blocked, please contact our support department.';
                        return false;
                    }
                }else{
                    $this->registerWrongLoginAttempt($email);
                    $this->msg = 'Invalid login information or the account has not been activated yet..!!';
                    return false;
                } 
            }
        }

        /**
        * Register a new user account function
        * @param string $email User email.
        * @param string $fname User first name.
        * @param string $lname User last name.
        * @param string $pass User password.
        * @return boolean of success.
        */
        public function registration($email,$fname,$lname,$pass){
            $pdo = $this->pdo;
            if($this->checkEmail($email)){
                $this->msg = 'This email is already taken.';
                return false;
            }
            if(!(isset($email) && isset($fname) && isset($lname) && isset($pass) && filter_var($email, FILTER_VALIDATE_EMAIL))){
                $this->msg = 'Insert all the required fields.';
                return false;
            }

            $pass = $this->hashPass($pass);
            $confCode = $this->hashPass(date('Y-m-d H:i:s').$email);
            $stmt = $pdo->prepare('INSERT INTO users (fname, lname, email, password, confirm_code) VALUES (?, ?, ?, ?, ?)');
            if($stmt->execute([$fname,$lname,$email,$pass,$confCode])){
                if($this->sendConfirmationEmail($email)){
                    return true;
                }else{
                    $this->msg = 'Confirmation email sending has failed.';
                    return false; 
                }
            }else{
                $this->msg = 'Inserting a new user failed.';
                return false;
            }
        }

        /**
        * Email the confirmation code function
        * @param string $email User email.
        * @return boolean of success.
        */
        private function sendConfirmationEmail($email){
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('SELECT confirm_code FROM users WHERE email = ? limit 1');
            $stmt->execute([$email]);
            $code = $stmt->fetch();

            require 'src/PHPMailer.php';
            require 'src/SMTP.php';
            require 'src/Exception.php';

            //Create a new PHPMailer instance
            $mail = new PHPMailer;
            //Tell PHPMailer to use SMTP
            $mail->isSMTP();
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;
            //Set the hostname of the mail server
            $mail->Host = 'india.ownmyserver.com';
            // use
            // $mail->Host = gethostbyname('smtp.gmail.com');
            // if your network does not support SMTP over IPv6
            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
            $mail->Port = 465;
            //Set the encryption system to use - ssl (deprecated) or tls
            $mail->SMTPSecure = 'ssl';
            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;
            //Username to use for SMTP authentication - use full email address for gmail
            //$mail->Username = "tuitionguruji@gmail.com";
            //Password to use for SMTP authentication
            //$mail->Password = "abhi@tuitionguruji";

            $mail->Username = "mail@tuitionguruji.com";
            //Password to use for SMTP authentication
            $mail->Password = "alec177fig600";

            //Set who the message is to be sent from
            $mail->setFrom('mail@tuitionguruji.com', 'TuitionGuruJi');
            //Set an alternative reply-to address

            $mail->addReplyTo('mail@tuitionguruji.com', 'TuitionGuruJi');
            //Set who the message is to be sent to
            $mail->addAddress($email, 'TuitionGuruJi');
            //Set the subject line
            $mail->Subject = 'Account Activation';
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML('<h3>Welcome to TuitionGuruJi..!!</h3><p>Activate your account by clicking on the following link:</p><a href="https://www.tuitionguruji.com/activate.php?email='.$email.'&token='.$code['confirm_code'].'"><strong>ACTIVATE ACCOUNT<strong></a>');
            //Replace the plain text body with one created manually
            $mail->AltBody = '<h3>Welcome to TuitionGuruJi..!!</h3><p>Activate your account by clicking on the following link:</p><a href="https://www.tuitionguruji.com/activate.php?email='.$email.'&token='.$code['confirm_code'].'"><strong>ACTIVATE ACCOUNT<strong></a>';
            //send the message, check for errors
            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }
        }

        /**
        * Activate a login by a confirmation code and login function
        * @param string $email User email.
        * @param string $confCode Confirmation code.
        * @return boolean of success.
        */
        public function emailActivation($email, $confCode){
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('UPDATE users SET confirmed = 1 WHERE email = ? and confirm_code = ?');
            $stmt->execute([$email, $confCode]);
            if($stmt->rowCount()>0){
                $stmt = $pdo->prepare('SELECT id, fname, lname, email, wrong_logins, user_role FROM users WHERE email = ? and confirmed = 1 limit 1');
                $stmt->execute([$email]);
                $this->msg = "Your account has been activated successfully..!!";
                $user = $stmt->fetch();

                $this->user = $user;
                session_regenerate_id();
                if(!empty($user['email'])){
                    $_SESSION['user']['id'] = $user['id'];
                        $_SESSION['user']['fname'] = $user['fname'];
                        $_SESSION['user']['lname'] = $user['lname'];
                        $_SESSION['user']['email'] = $user['email'];
                        $_SESSION['user']['user_role'] = $user['user_role'];
                        return true;
                }else{
                    $this->msg = 'Account activation failed.';
                    return false;
                }
            }else{
                $this->msg = 'Account activation failed.';
                return false;
            }
        }

        /**
        * Password change function
        * @param int $id User id.
        * @param string $pass New password.
        * @return boolean of success.
        */
        public function passwordChange($id,$pass){
            $pdo = $this->pdo;
            if(isset($id) && isset($pass)){
                $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
                if($stmt->execute([$this->hashPass($pass), $id])){
                    $this->msg = "Password Successfully Updated";
                    return true;
                }else{
                    $this->msg = 'Password change failed.';
                    return false;
                }
            }else{
                $this->msg = 'Provide an ID and a password.';
                return false;
            }
        }
        
        /**
        * Password forgot function
        * @param int $email email_id.
        * @param string $pass New password.
        * @return boolean of success.
        */
        public function forgotPassword($email, $pass){
            $pdo = $this->pdo;
            if(isset($email) && isset($pass)){
                $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE email = ?');
                if($stmt->execute([$this->hashPass($pass), $email])){
                    $this->msg = "Password Successfully Updated";
                    return true;
                }else{
                    $this->msg = 'Password change failed.';
                    return false;
                }
            }else{
                $this->msg = 'Provide an ID and a password.';
                return false;
            }
        }

        /**
        * Assign a role function
        * @param int $id User id.
        * @param int $role User role.
        * @return boolean of success.
        */
        public function assignRole($id,$role){
            $pdo = $this->pdo;
            if(isset($id) && isset($role)){
                $stmt = $pdo->prepare('UPDATE users SET role = ? WHERE id = ?');
                if($stmt->execute([$id,$role])){
                    return true;
                }else{
                    $this->msg = 'Role assign failed.';
                    return false;
                }
            }else{
                $this->msg = 'Provide a role for this user.';
                return false;
            }
        }

        /**
        * User information change function
        * @param int $id User id.
        * @param string $fname User first name.
        * @param string $lname User last name.
        * @return boolean of success.
        */
        public function userUpdate($id,$fname,$lname){
            $pdo = $this->pdo;
            if(isset($id) && isset($fname) && isset($lname)){
                $stmt = $pdo->prepare('UPDATE users SET fname = ?, lname = ? WHERE id = ?');
                if($stmt->execute([$id,$fname,$lname])){
                    return true;
                }else{
                    $this->msg = 'User information change failed.';
                    return false;
                }
            }else{
                $this->msg = 'Provide a valid data.';
                return false;
            }
        }

        /**
        * Check if email is already used function
        * @param string $email User email.
        * @return boolean of success.
        */
        private function checkEmail($email){
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? limit 1');
            $stmt->execute([$email]);
            if($stmt->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        /**
        * Register a wrong login attemp function
        * @param string $email User email.
        * @return void.
        */
        private function registerWrongLoginAttempt($email){
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('UPDATE users SET wrong_logins = wrong_logins + 1 WHERE email = ?');
            $stmt->execute([$email]);
        }

        /**
        * Update a successful login attempt function
        * @param string $email User email.
        * @return void.
        */
        private function registerCorrectLoginAttempt($email){
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('UPDATE users SET wrong_logins = 0 WHERE email = ?');
            $stmt->execute([$email]);
        }

        /**
        * Password hash function
        * @param string $password User password.
        * @return string $password Hashed password.
        */
        private function hashPass($pass){
            return password_hash($pass, PASSWORD_DEFAULT);
        }

        /**
        * Print error msg function
        * @return void.
        */
        public function printMsg(){
            print "<script>alert('".$this->msg."');</script>";
        }

        /**
        * Logout the user and remove it from the session.
        *
        * @return true
        */
        public function logout() {
            $_SESSION['user'] = null;
            session_regenerate_id();
            return true;
        }
    }
?>