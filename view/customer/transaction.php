<?php
     require_once "../../middleware/RoleMiddleware.php";

     RoleMiddleware::getInstance()->checkRole('customer');
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
            <a href="./home.php">Back to Store</a>
        </div>
        <div>
            <?php
                session_start();

                require_once '../../db/DBConnection.php';

                $conn = Connect::getInstance()->getDBConnection();

                function displayTransactionList($conn) {
                    if (is_array($conn)) {
                        echo "<h2>Transaction List</h2>";
                        
                        if (empty($conn)) {
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

                            foreach ($conn as $transactionId => $transactionDetails) {
                                $customerId = CU1;
                                $sellerId = SE1;
                                $transactionDate = $transactionDetails['transaction_date'];
                            
                                echo "<tr>
                                    <td>$transactionId</td>
                                    <td>$customerId</td>
                                    <td>$sellerId</td>
                                    <td>";
                            
                                if ($transactionDate !== null) {
                                    $transactionDate = new DateTime($transactionDate, new DateTimeZone('UTC'));
                                    $transactionDate->setTimezone(new DateTimeZone('Asia/Jakarta'));
                                    echo $transactionDate->format('Y-m-d');
                                } else {
                                    echo "-";
                                }
                            
                                echo "</td>
                                    <td><a href='viewdetails.php?transaction_id=$transactionId'>View Details</a></td>
                                    <td><a href='transactionlist.php?delete_transaction=$transactionId'>Delete</a></td>
                                </tr>";
                            }
                            echo "</table>";
                        }
                    } else {
                        $stmt = $conn->prepare("SELECT transaction_id, customer_id, seller_id, transaction_date FROM transactions_header");
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($transactionId, $customerId, $sellerId, $transactionDate);

                        echo "<h2>Transaction List</h2>";

                        if ($stmt->num_rows > 0) {
                            echo "<table border='1'>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Customer ID</th>
                                    <th>Seller ID</th>
                                    <th>Transaction Date</th>
                                    <th>Action</th>
                                </tr>";

                            while ($stmt->fetch()) {
                                echo "<tr>
                                    <td>$transactionId</td>
                                    <td>$customerId</td>
                                    <td>$sellerId</td>
                                    <td>";

                                if ($transactionDate !== null) {
                                    $transactionDate = new DateTime($transactionDate, new DateTimeZone('UTC'));
                                    $transactionDate->setTimezone(new DateTimeZone('Asia/Jakarta'));
                                    echo $transactionDate->format('Y-m-d');
                                } else {
                                    echo "-";
                                }

                                echo "</td>
                                    <td><a href='viewdetails.php?transaction_id=$transactionId'>View Details</a></td>
                                    <td><a href='transaction.php?delete_transaction=$transactionId'>Delete</a></td>
                                </tr>";
                            }

                            echo "</table>";
                        } else {
                            echo "No transactions available.";
                        }

                        $stmt->close();
                    }
                }


                function deleteTransaction($conn, $transactionId) {
                    $stmt = $conn->prepare("DELETE FROM transactions_header WHERE transaction_id = ?");
                    $stmt->bind_param("i", $transactionId);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        echo "Transaction $transactionId has been deleted.";
                    } else {
                        echo "Transaction not found or could not be deleted.";
                    }

                    $stmt->close();
                }

                if (isset($_GET['delete_transaction'])) {
                    $transactionIdToDelete = $_GET['delete_transaction'];
                    deleteTransaction($conn, $transactionIdToDelete);
                }

                if (!isset($_SESSION['saved_carts'])) {
                    $_SESSION['saved_carts'] = array();
                }

                displayTransactionList($conn);
            ?>
        </div>
    </body>
</html>