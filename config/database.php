<?php
    class Database {
        // DB params
        private $host = 'localhost';
        private $db_name = 'simple_api';
        private $username = 'root';
        private $password = '123456789';
        private $conn;
        // DB connect
        public function connect(){
            $this->conn = null;
            try{
                $this->conn = new PDO(
                    'mysql:host=' . $this->host . ';dbname=' . $this->db_name, 
                    $this->username, 
                    $this->password
                );
                //set err mode so we can fitch the err
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e){
                //fetching the err
                echo 'error' . $e->getMessage();
            }
            
            return $this->conn;
        }
    }
?>