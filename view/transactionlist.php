<?php
  require_once "../../db/dbConnection.php";
  require_once "../../middleware/AuthMiddleware.php";
  require_once "../../middleware/RoleMiddleware.php";

  RoleMiddleware::getInstance()->checkRole('customer');
?>

<?php
    session_start();

    function displayTransactionList($savedCarts) {
        echo "<h2>Transaction List</h2>";

        if (empty($savedCarts)) {
            echo "No transactions available.";
        } else {
            echo "<table border='1'>
                <tr>
                    <th>Transaction ID</th>
                    <th>Customer ID</th>
                    <th>Seller ID</th>
                    <th>Transaction Date</th>
                    <th>Action</th>
                </tr>";

            foreach ($savedCarts as $transactionId => $transaction) {
                $customerId = 'CU1'; 
                $sellerId = 'SE1'; 

                echo "<tr>
                    <td>$transactionId</td>
                    <td>$customerId</td>
                    <td>$sellerId</td>
                    <td>";

                if (isset($transaction['transaction_date'])) {
                    $transactionDate = new DateTime($transaction['transaction_date'], new DateTimeZone('UTC'));
                    $transactionDate->setTimezone(new DateTimeZone('Asia/Jakarta'));
                    echo $transactionDate->format('Y-m-d H:i:s');
                } else {
                    echo "-";
                }

                echo "</td>
                    <td><a href='viewtransaction.php?transaction_id=$transactionId'>View Details</a></td>
                    <td><a href='transactionlist.php?delete_transaction=$transactionId'>Delete</a></td>
                </tr>";
            }

            echo "</table>";
        }
    }

    function deleteTransaction($transactionId) {
        if (isset($_SESSION['saved_carts'][$transactionId])) {
            unset($_SESSION['saved_carts'][$transactionId]);
            echo "Transaction $transactionId has been deleted.";
        } else {
            echo "Transaction not found.";
        }
    }

    if (isset($_GET['delete_transaction'])) {
        $transactionIdToDelete = $_GET['delete_transaction'];
        deleteTransaction($transactionIdToDelete);
    }

    if (!isset($_SESSION['saved_carts'])) {
        $_SESSION['saved_carts'] = array();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Transaction List</title>
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
            <a href="../index.php">Back to Store</a>
        </div>
        <div>
            <?php displayTransactionList($_SESSION['saved_carts']); ?>
        </div>
    </body>
</html>