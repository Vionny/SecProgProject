<?php

  class Item{
    private int $item_id;
    private int $seller_id;
    private string $item_name;
    private string $item_description;
    private int $item_price;
    private int $item_stock;
    protected $db;
    protected $conn;

    public function __construct($item_id=null,$seller_id, $item_name, $item_description, $item_price, $item_stock){
      if($item_id!==null ){
        $this->item_id = $item_id;
      }
      $this->seller_id = $seller_id;
      $this->item_name = $item_name;
      $this->item_description = $item_description;
      $this->item_price = $item_price;
      $this->item_stock = $item_stock;
      $this->conn = Connect::getInstance();
      $this->db = $this->conn->getDBConnection();
      
    }
    
    public function insert() {
      //TODO : Benerin ini gk ada userid
      $query = "INSERT INTO `items` (seller_id,item_name,item_description
      ,item_price,item_stock) VALUES (?,?,?,?,?);";
      $stmt = $this->db->prepare($query);
      $stmt->bind_param("issii", $this->seller_id,$this->item_name, $this->item_description, 
      $this->item_price,$this->item_stock);
      $stmt->execute();
      $stmt->close();
    }

    public static function getSellerItem(){
      $sql = "SELECT item_id,item_name, item_description,item_price,item_stock,user_type FROM users u JOIN items i ON u.user_id = i.seller_id WHERE SUBSTRING(user_token,17) = ?";
      $db = Connect::getInstance()->getDBConnection();
      $stmt = $db->prepare($sql);
      if(!isset($_SESSION['token'])){
        header("Location: ../view/login.php");
      }
      $token = $_SESSION["token"];
      $stmt->bind_param("s", $token);
      $stmt->execute();
      $result = $stmt->get_result();
      $stmt->close();
      return $result;
    }

    public static function deleteSellerItem($item_id){
      $query = "DELETE i FROM users u JOIN items i ON u.user_id = i.seller_id WHERE SUBSTR(user_token,17) = ? AND item_id = ?";
      $db = Connect::getInstance()->getDBConnection();
      $stmt = $db->prepare($query);
      $token = $_SESSION["token"];
      $stmt->bind_param("si", $token,$item_id);
      $stmt->execute();
    }
  }
?>