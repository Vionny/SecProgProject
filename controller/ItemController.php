<?php
  require_once("../AuthMiddleware");
  require_once("../");
  class ItemController {

    private static $instance;
    private $conn;
    protected $db;
    private function __construct() {
      $this->conn = Connect::getInstance();
      $this->db = $this->conn->getDBConnection();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new ItemController();
        }
        return self::$instance;
    }

    public function registerItem($item_name, $item_description, $item_price, $item_stock){
     
      // TODO : Ambil userId dari Authmiddleware
      // pny check bs dpt current user kok

      
      $user = AuthMiddleware::getInstance()->checkAuth();

      $userId=$user['user_id'];
      
      // $userId = 0;
      $toInsert = new Item(null,$userId,$item_name, $item_description, $item_price, $item_stock);
      $err = $toInsert->insert();
      return $err;
    
  }
  }
?>