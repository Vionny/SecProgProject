<?php
session_start();

// Function to display the transaction list
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
            // Assume transaction details are retrieved from a database or other source
            // For simplicity, using placeholder values
            $customerId = '123'; // Replace with actual customer ID
            $sellerId = '456'; // Replace with actual seller ID

            echo "<tr>
                <td>$transactionId</td>
                <td>$customerId</td>
                <td>$sellerId</td>
                <td>";

            // Check if the 'transaction_date' key is present in the current transaction
            if (isset($transaction['transaction_date'])) {
                // Convert the stored date to WIB timezone
                $transactionDate = new DateTime($transaction['transaction_date'], new DateTimeZone('UTC'));
                $transactionDate->setTimezone(new DateTimeZone('Asia/Jakarta'));
                echo $transactionDate->format('Y-m-d H:i:s');
            } else {
                echo "N/A"; // Replace with a suitable message or leave it blank
            }

            // Add links for view and delete actions
            echo "</td>
                <td><a href='view_transaction.php?transaction_id=$transactionId'>View Details</a></td>
                <td><a href='transactionlist.php?delete_transaction=$transactionId'>Delete</a></td>
            </tr>";
        }

        echo "</table>";
    }
}

// Function to delete a specific transaction
function deleteTransaction($transactionId) {
    if (isset($_SESSION['saved_carts'][$transactionId])) {
        unset($_SESSION['saved_carts'][$transactionId]);
        echo "Transaction $transactionId has been deleted.";
    } else {
        echo "Transaction not found.";
    }
}

// Check if a delete action is triggered
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
        /* Add your styles here */
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