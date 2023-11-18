<?php
    require "../connect.php";
    require "../db/DBConnection.php";

    class Rating{
        private $rating_id;
        private $item_id;
        private $customer_id;
        private $rating;
        private $comment;

        public function __construct($rating_id, $item_id, $customer_id, $rating, $comment){ 
            $this->rating_id = $rating_id;
            $this->item_id = $item_id;
            $this->customer_id = $customer_id;
            $this->rating = $rating;
            $this->comment = $comment;
        }

        
    }

?>