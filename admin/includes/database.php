<?php
    require_once "config.php";

    class Db {
        protected static $connection;

        public function connect() {
            if(!isset(self::$connection)) {
                self::$connection = new mysqli(host, dbUser, dbPass, database, port);
            }
            if(self::$connection === false) {
                return false;
            }
            return self::$connection;
        }

        public function query($query) {
            $connection = $this -> connect();
            $result = $connection -> query($query);
            return $result;
        }

        public function select($query) {
            $rows = array();
            $result = $this -> query($query);
            if($result === false) {
                return false;
            }
            while ($row = $result -> fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        }

        public function escape($value) {
            $connection = $this -> connect();
            return $connection -> real_escape_string(htmlspecialchars($value));
        }

        public function error() {
            $connection = $this -> connect();
            return $connection -> error;
        }
        
        public function disableCommit(){
            self::$connection->autocommit(false);
        }
        
        public function enableCommit(){
            self::$connection->autocommit(true);
        }
        
        public function commit(){
            self::$connection->commit();
        }

        public function rollback(){
            self::$connection->rollback();
        }
    }
?>