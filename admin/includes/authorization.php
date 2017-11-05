<?php
    require_once "config.php";

    class Authentication{
        /** @var object $pdo Copy of PDO connection */
        private $pdo;
        /** @var object of the logged in user */
        private $user;
        /** @var string error msg */
        private $msg;
        /** @var int number of permitted wrong login attemps */
        private $permitedAttempts = 25;

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
                $stmt = $pdo->prepare('SELECT id, email, wrong_logins, password FROM admins WHERE email = ? limit 1');
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if(password_verify($password, $user['password'])){
                    if($user['wrong_logins'] <= $this->permitedAttempts){
                        $this->registerCorrectLoginAttempt($email);
                        $this->user = $user;
                        session_regenerate_id();
                        $_SESSION['admin']['id'] = $user['id'];
                        $_SESSION['admin']['email'] = $user['email'];
                        return true;
                    }else{
                        $this->msg = 'This user account is blocked, please contact our support department.';
                        return false;
                    }
                }else{
                    $this->registerWrongLoginAttempt($email);
                    $this->msg = 'Invalid login information.';
                    return false;
                } 
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
                $stmt = $pdo->prepare('UPDATE admins SET password = ? WHERE id = ?');
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
        * Register a wrong login attemp function
        * @param string $email User email.
        * @return void.
        */
        private function registerWrongLoginAttempt($email){
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('UPDATE admins SET wrong_logins = wrong_logins + 1 WHERE email = ?');
            $stmt->execute([$email]);
        }

        /**
        * Update a successful login attempt function
        * @param string $email User email.
        * @return void.
        */
        private function registerCorrectLoginAttempt($email){
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('UPDATE admins SET wrong_logins = 0 WHERE email = ?');
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
            $_SESSION['admin'] = null;
            session_regenerate_id();
            return true;
        }
    }
?>