<?php
    require_once "../controller/AuthController.php";

    class Customer extends User{
        protected string $user_email;
        protected int $user_id;
        private string $customer_first_name;
        private string $customer_last_name;
        private string $customer_dob;
        // private string $customer_money;
        protected $conn;
        protected $db;

        
        public function __construct($user_email, $user_password, $customer_first_name, $customer_last_name, $customer_dob) {
            // parent::__construct($user_email, $user_password);
            $this->conn = Connect::getInstance();
            $this->db = $this->conn->getDBConnection();
            $this->user_email = $user_email;
            $this->user_password = $user_password;
            $this->customer_first_name = $customer_first_name;
            $this->customer_last_name = $customer_last_name;
            $this->customer_dob = $customer_dob;
            // $this->customer_money = $customer_money;
            
        }

        public function insert() {
            $query = "INSERT INTO `users` (`user_email`, `user_password`, `customer_first_name`,customer_last_name,customer_dob) VALUES (?,?,?,?,?);";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sssss", $this->user_email, $this->user_password, $this->customer_first_name,
             $this->customer_last_name,$this->customer_dob);
    
            try {
                $stmt->execute();
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() == 1062) { 
                    $_SESSION['error'] = "Email already exists";
                } else {
                    
                    $_SESSION['error'] = "An error occurred: " . $e->getMessage();
                }
                return false;
            }
    
            $userId = $stmt->insert_id;
            $stmt->close();
    
            if ($userId == null) {
                $_SESSION['error'] = "Error inserting customer";
                return false;
            } else {
                $query = "INSERT INTO `users` (`user_email`, `user_password`, `customer_first_name`,customer_last_name
            ,customer_dob) VALUES (?,?,?,?,?);";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param("sssss", $this->user_email, $this->user_password, $this->customer_first_name,
                $this->customer_last_name,$this->customer_dob);
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
