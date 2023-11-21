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

    public function __construct($item_id=null,$seller_id=null, $item_name, $item_description, $item_price, $item_stock){
      if($item_id!==null &&$seller_id !==null){
        $this->item_id = $item_id;
        $this->seller_id = $seller_id;
      }
      $this->item_name = $item_name;
      $this->item_description = $item_description;
      $this->item_price = $item_price;
      $this->item_stock = $item_stock;
      $this->conn = Connect::getInstance();
      $this->db = $this->conn->getDBConnection();
    }
    
    public function insert() {
      $query = "INSERT INTO `items` ( `item_name`,item_description
      ,item_price,item_stock) VALUES (?,?,?,?);";
      $stmt = $this->db->prepare($query);
      $stmt->bind_param("ssii", $this->item_name, $this->item_description, 
      $this->item_price,$this->item_stock);
      $stmt->execute();
    }
  }
?>