<?php
    require "../connect.php";
    require "../db/DBConnection.php";
    require "./User.php";
    class Customer extends User{
        private int $user_id;
        private string $customer_first_name;
        private string $customer_last_name;
        private string $customer_dob;
        private string $customer_money;
        private $conn = Connect::getInstance();
        private $db = $this->conn->getDBConnection();

        public function __construct($user_email, $user_password, $user_type, $customer_first_name, $customer_last_name, $customer_dob, $customer_money) {
            parent::__construct($user_email, $user_password, $user_type);
            $this->customer_first_name = $customer_first_name;
            $this->customer_last_name = $customer_last_name;
            $this->customer_dob = $customer_dob;
            $this->customer_money = $customer_money;
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