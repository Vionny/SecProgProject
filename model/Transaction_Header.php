<?php
    require "../connect.php";
    require "../db/DBConnection.php";
    require "./Transaction_Detail.php";

    class TransactionHeader{
      private int $transaction_id;
      private int $customer_id;
      private int $seller_id;
      private int $transaction_date;
      private int $transaction_status;
      private $transactionDetails;
      
      public function __construct($transaction_id, $customer_id, $seller_id, $transaction_date, $transaction_status, $transactionDetails) {
        $this->transaction_id = $transaction_id;
        $this->customer_id = $customer_id;
        $this->seller_id = $seller_id;
        $this->transaction_date = $transaction_date;
        $this->transaction_status = $transaction_status;
        $this->transactionDetails = $transactionDetails;
      }

      public function setTransactionDetails(array $transactionDetails) {
          $this->transactionDetails = $transactionDetails;
      }
    }
?>