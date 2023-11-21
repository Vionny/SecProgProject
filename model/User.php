<?php
   class User{
        
        protected int $user_id;
        protected string $user_email;
        protected string $user_password;
        protected string $user_type;

        private $conn;
        protected $db;
        public function __construct($user_email = null, $user_password = null, $user_type = null){
            $this->conn = Connect::getInstance();
            $this->db = $this->conn->getDBConnection();
            if ($user_email !== null && $user_password !== null && $user_type !== null) {
                $this->user_email = $user_email;
                $this->user_password = $user_password;
                $this->user_type = $user_type;
            }
        }

        public function insert(){}

        public static function  logout(){
            session_start();
            header("Location: ../index.php");
            session_destroy();
        }

        public function getUser($user_email){
            
            $query = "SELECT * FROM users WHERE user_email=?";
            $statement = $this->db->prepare($query);
            $statement->bind_param("s", $user_email); 
            $statement->execute();
            $result = $statement->get_result();
            
            if($result->num_rows !=1) {
                $_SESSION['error'] = "Error fetching user";
                return false;
            }
            
            $user = $result->fetch_assoc();
            $statement->close();
            return $user;
            
    }
    private function setToken($newToken){
        $query = "UPDATE users SET token=?";
        $statement = $this->db->prepare($query);
        $encryptedData = EncryptService::encryptData($newToken);
        $encryptedToken = EncryptService::getEncryptedData($encryptedData);
        $_SESSION['token'] = $encryptedToken;
        $statement->bind_param("s", $encryptedData); 
        $statement->execute();
        $statement->close();
        return $encryptedToken;
    }

    

    public function insertUserToken(){
        $newToken = generateToken();
        $encryptedToken = $this->setToken($newToken);
        $_SESSION['token'] = $encryptedToken;
    }
}

?>