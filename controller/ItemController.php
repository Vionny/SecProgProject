<?php
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
      // $encrypted_password = EncryptService::hashPassword($user_password);
      // TODO : Ambil userId dari Authmiddleware pny check bs dpt current user kok
      $userId = 0;
      $toInsert = new Item(null,$userId,$item_name, $item_description, $item_price, $item_stock);
      $err = $toInsert->insert();
      return $err;
    
  }
  }
?>