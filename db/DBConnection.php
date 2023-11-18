<?php
    class Connect
    {
        private static $instance;
        private $conn;

        private $server = "localhost";
        private $username = "root";
        private $password = "";
        private $database = "secprogdb";

        public function __construct(){
            $this->conn = new mysqli($this->server, $this->username, $this->password,$this->database);

            if ($this->conn->connect_error) {
                echo ("Connection Failed: " . $this->conn->connect_error . "<br>");
                var_dump($this->conn);
            }
        }

        public static function getInstance(){
            if(!self::$instance) self::$instance = new self();
            return self::$instance;
        }

        public function getDBConnection(){
            return $this->conn;
        }
        
    }
?>
