<?php

  class Item{
    private int $item_id;
    private int $seller_id;
    private string $item_name;
    private string $item_description;
    private int $item_price;
    private int $item_stock;

    public function __construct($item_id, $seller_id, $item_name, $item_description, $item_price, $item_stock){
      $this->item_id = $item_id;
      $this->seller_id = $seller_id;
      $this->item_name = $item_name;
      $this->item_description = $item_description;
      $this->item_price = $item_price;
      $this->item_stock = $item_stock;
    }
  }
?>