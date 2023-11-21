<?php

    class Seller extends User{
        protected int $user_id;
        private string $seller_name;
        private string $seller_address;
        private $seller_money;

        public function __construct($user_email, $user_password, $user_type, $seller_name, $seller_address, $seller_money ){
            parent::__construct($user_email, $user_password, $user_type);
            $this->seller_name = $seller_name;
            $this->seller_address = $seller_address;
            $this->seller_money = $seller_money;
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
                $_SESSION['error'] = "Error inserting seller";
                return false;
            } else {
                $query = "INSERT INTO sellers(`user_id`,`seller_name`,`seller_address`,`seller_money`) VALUES (?,?,?,?)";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param("isss",$this->user_id,$this->seller_name, $this->seller_address, $this->seller_money);

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