<?php
    require "../connect.php";
    require "../db/DBConnection.php";

    class Seller{
        private $user_id;
        private $seller_name;
        private $seller_address;
        private $seller_money;

        public function __construct( $user_id, $seller_name, $seller_address, $seller_money ){
            $this->user_id = $user_id;
            $this->seller_name = $seller_name;
            $this->seller_address = $seller_address;
            $this->seller_money = $seller_money;
        }
    }
?>