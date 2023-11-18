<?php
    require "../connect.php";
    require "../db/DBConnection.php";

    class Customer{
        private $user_id;
        private $customer_first_name;
        private $customer_last_name;
        private $customer_dob;
        private $customer_money;

        public function __construct($user_id, $customer_first_name, $customer_last_name, $customer_dob, $customer_money){
            $this->user_id = $user_id;
            $this->customer_first_name = $customer_first_name;
            $this->customer_last_name = $customer_last_name;
            $this->customer_dob = $customer_dob;
            $this->customer_money = $customer_money;
        }
    }
?>