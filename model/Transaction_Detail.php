<?php
    require "../connect.php";
    require "../db/DBConnection.php";

    class TransactionDetail{
      private int $transaction_detail_id;
      private int $transaction_id;
      private int $item_id;
      private int $quantity;

      public function __construct($transaction_detail_id, $transaction_id, $item_id, $quantity){
        $this->transaction_detail_id = $transaction_detail_id;
        $this->transaction_id = $transaction_id;
        $this->item_id = $item_id;
        $this->quantity = $quantity;
      }
    }
?>