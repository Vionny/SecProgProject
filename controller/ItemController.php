<?php
  require_once("../middleware/AuthMiddleware.php");
  // require_once("../");
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

    public function registerItem($item_name, $item_description, $item_price, $item_stock,$item_file){
      $user = AuthMiddleware::getInstance()->checkAuth();
      if(empty($item_name) || empty($item_description) || empty($item_price) || empty($item_stock) || empty($item_file)){
        $_SESSION['error'] = "Please input all the fields";
        return false;
      }
      if(!isset($_SESSION['token'])){
        header("Location: ../view/login.php");
      }

      $item_file_mime_type = mime_content_type($item_file["tmp_name"]);
      $allowed_mime_types = [
        "image/jpg", "image/png", "image/jpeg", "image/gif"
      ];
      $item_file_basename = basename($item_file["name"]);
      $item_file_extension = pathinfo($item_file_basename, PATHINFO_EXTENSION);
      $allowed_file_extensions = [
        "jpg", "jpeg", "png", "gif"
      ];

      if ($item_file["size"] > 10 * 1024 * 1024) { // 10 MB
        $_SESSION["error"] = "Please upload an image file, max. 10 MB";
        return false;
      }
        
      if (!in_array($item_file_mime_type, $allowed_mime_types, true) || !in_array($item_file_extension, $allowed_file_extensions, true)) {
        $_SESSION['error'] = 'Please upload an image file';
        return false;
      }

      $userId=$user['user_id'];
      $toInsert = new Item(null,$userId,$item_name, $item_description, $item_price, $item_stock,$item_file);
      $err = $toInsert->insert();
      return $err;
    
  }
  }
?>