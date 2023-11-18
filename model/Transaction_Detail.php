<?php
    require "../connect.php";
    require "../db/DBConnection.php";

    class TransactionDetail{
      private $transaction_detail_id;
      private $transaction_id;
      private $item_id;
      private $quantity;

      public function __construct($transaction_detail_id, $transaction_id, $item_id, $quantity){
        $this->transaction_detail_id = $transaction_detail_id;
        $this->transaction_id = $transaction_id;
        $this->item_id = $item_id;
        $this->quantity = $quantity;
      }
    }
?>