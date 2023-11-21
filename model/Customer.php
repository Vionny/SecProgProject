<?php

    class Customer extends User{
        protected int $user_id;
        private string $customer_first_name;
        private string $customer_last_name;
        private string $customer_dob;
        private string $customer_money;

        // editan vincent klo ngaco blg aja
        private $conn;
        protected $db;

        public function __construct($user_email, $user_password, $user_type, $customer_first_name, $customer_last_name, $customer_dob, $customer_money) {
            parent::__construct($user_email, $user_password, $user_type);
            $this->customer_first_name = $customer_first_name;
            $this->customer_last_name = $customer_last_name;
            $this->customer_dob = $customer_dob;
            $this->customer_money = $customer_money;

            // ni juga
            $this->conn = Connect::getInstance();
            $this->db =  $this->conn->getDBConnection();
            
        }

        public function insert() {
            $query = "INSERT INTO `users` (`user_email`, `user_password`, `user_type`) VALUES (?,?,?);";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sss", $this->user_email, $this->user_password, $this->user_type);
    
            try {
                $stmt->execute();
            } catch (ErrorException $e) {
                $_SESSION['error'] = "Insert data error: " . $e->getMessage();
                return false;
            }
    
            $userId = $stmt->insert_id;
            $stmt->close();
    
            if ($userId == null) {
                $_SESSION['error'] = "Error inserting customer";
                return false;
            } else {
                $query = "INSERT INTO customer (`user_id`, `customer_first_name`, `customer_last_name`, `customer_money`) VALUES (?, ?, ?, ?)";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param("issd", $userId, $this->customer_first_name, $this->customer_last_name, $this->customer_money);
    
                try {
                    $stmt->execute();
                } catch (ErrorException $e) {
                    return $_SESSION['error'] = "Insert data error: " . $e->getMessage();
                }
    
                $stmt->close();
                return true;
            }
        }
    }
?>
