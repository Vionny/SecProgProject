<?php
    require "../connect.php";
    require "../db/DBConnection.php";

    class User{
        
        private $user_id;
        private $user_email;
        private $user_password;
        private $user_type;

        public function __construct($user_email, $user_password, $user_type){
            $this->user_email = $user_email;
            $this->user_password = $user_password;
            $this->user_type = $user_type;
        }

    }
    

?>