<?php
    require_once "../../db/dbConnection.php";
    require_once "../../middleware/AuthMiddleware.php";
    require_once "../../middleware/RoleMiddleware.php";

    RoleMiddleware::getInstance()->checkRole('customer');

    require_once "../../utils/tokenService.php";
    if(getToken() !== $_POST['token']){
        $_SESSION['error'] = "Token invalid";
        header("Location: ../../registerCustomer.php");
        die();
      }

    function displayTransactionDetails($transactionId, $savedCarts, $conn) {
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
                $itemDetails = getItemDetails($conn, $itemId);

                if ($itemDetails) {
                    echo "<tr>
                        <td>{$itemDetails['item_id']}</td>
                        <td>{$itemDetails['item_name']}</td>
                        <td>\${$itemDetails['item_price']}</td>
                        <td>$quantity</td>
                    </tr>";
                } else {
                    echo "<tr>
                        <td>$itemId</td>
                        <td>Product Not Found</td>
                        <td>N/A</td>
                        <td>$quantity</td>
                    </tr>";
                }
            }

            echo "</table>";
        } else {
            echo "Transaction not found.";
        }
    }

    function getItemDetails($conn, $itemId) {
        $stmt = $conn->prepare("SELECT item_id, item_name, item_price FROM items WHERE item_id = ?");
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($itemId, $itemName, $itemPrice);
            $stmt->fetch();
            $itemDetails = [
                'item_id' => $itemId,
                'item_name' => $itemName,
                'item_price' => $itemPrice,
            ];
            $stmt->close();

            return $itemDetails;
        } else {
            return false;
        }
    }

    if (isset($_GET['transaction_id'])) {
        $transactionId = $_GET['transaction_id'];
        $conn = Connect::getInstance()->getDBConnection();
        displayTransactionDetails($transactionId, $_SESSION['saved_carts'], $conn);
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
        <a href="transaction.php">Back to Transaction List</a>
    </div>
</body>
</html>