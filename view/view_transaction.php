<?php
    session_start();

    function displayTransactionDetails($transactionId, $savedCarts) {
        echo "<h2>Transaction Details</h2>";

        if (isset($savedCarts[$transactionId])) {
            $transaction = $savedCarts[$transactionId]['cart'];
            
            echo "<table border='1'>
                <tr>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Item Price</th>
                    <th>Quantity</th>
                </tr>";

            foreach ($transaction as $itemId => $quantity) {
                $itemName = "Product $itemId";
                $itemPrice = 10 + $itemId * 5;

                echo "<tr>
                    <td>$itemId</td>
                    <td>$itemName</td>
                    <td>\$$itemPrice</td>
                    <td>$quantity</td>
                </tr>";
            }

            echo "</table>";
        } else {
            echo "Transaction not found.";
        }
    }

    if (isset($_GET['transaction_id'])) {
        $transactionId = $_GET['transaction_id'];
        displayTransactionDetails($transactionId, $_SESSION['saved_carts']);
    } else {
        echo "Invalid request. Please provide a valid transaction ID.";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Transaction</title>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }
        </style>
    </head>
    <body>
        <div>
            <a href="transactionlist.php">Back to Transaction List</a>
        </div>
    </body>
</html>