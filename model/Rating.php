<?php
    require "../connect.php";
    require "../db/DBConnection.php";

    class Rating{
        private int $rating_id;
        private int $item_id;
        private int $customer_id;
        private int $rating;
        private string $comment;

        public function __construct($rating_id, $item_id, $customer_id, $rating, $comment){ 
            $this->rating_id = $rating_id;
            $this->item_id = $item_id;
            $this->customer_id = $customer_id;
            $this->rating = $rating;
            $this->comment = $comment;
        }

        
    }

?>