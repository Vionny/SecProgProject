<?php
session_start();
require_once '../../db/DBConnection.php';

$conn = Connect::getInstance()->getDBConnection();

$items = fetchItemsFromDatabase();

function resetCart() {
    $_SESSION['cart'] = array();
}

function fetchItemsFromDatabase() {
    global $conn;

    $items = array();

    $stmt = $conn->prepare("SELECT item_id, item_name, item_description, item_price, item_stock FROM items");
    $stmt->execute();
    $stmt->bind_result($itemId, $itemName, $itemDescription, $itemPrice, $itemStock);

    while ($stmt->fetch()) {
        $items[$itemId] = array(
            'item_id' => $itemId,
            'item_name' => $itemName,
            'item_description' => $itemDescription,
            'item_price' => $itemPrice,
            'item_stock' => $itemStock,
        );
    }

    $stmt->close();

    return $items;
}

function saveCart($cart) {
    global $conn;

    if (empty($cart)) {
        echo "Error: Your shopping cart is empty.<br>Add items to the cart before saving.";
        return;
    }

    date_default_timezone_set('Asia/Jakarta');

    $stmt = $conn->prepare("INSERT INTO transactions_header (customer_id, seller_id, transaction_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $customerId, $sellerId, $transactionDate);

    $customerId = 1;
    $sellerId = 1;
    $transactionDate = date('Y-m-d H:i:s');

    $stmt->execute();
    $stmt->close();

    $transactionId = $conn->insert_id;

    foreach ($cart as $item_id => $quantity) {
        $stmt = $conn->prepare("INSERT INTO transactions_detail (transaction_id, item_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $transactionId, $item_id, $quantity);
        $stmt->execute();
        $stmt->close();
    }

    $stmt = $conn->prepare("UPDATE transactions_header SET transaction_date = ? WHERE transaction_id = ?");
    $stmt->bind_param("si", $transactionDate, $transactionId);
    $stmt->execute();
    $stmt->close();

    $_SESSION['saved_carts'][$transactionId] = array(
        'cart' => $cart,
        'transaction_date' => $transactionDate
    );

    resetCartAndRedirect();
}

function restockItem($item_id, $quantity, &$items) {
    global $conn;

    if (isset($items[$item_id])) {
        $items[$item_id]['item_stock'] += $quantity;

        $stmt = $conn->prepare("UPDATE items SET item_stock = item_stock + ? WHERE item_id = ?");
        $stmt->bind_param("ii", $quantity, $item_id);
        $stmt->execute();
        $stmt->close();

        return true;
    } else {
        return false;
    }
}

function resetCartAndRedirect() {
    resetCart();
    header("Location: ./home.php");
    exit();
}

function displayProducts($items) {
    echo "<h2>Product List</h2>";
    if (!empty($items)) {
        echo "<ul>";
        foreach ($items as $item) {
            echo "<li>{$item['item_name']} - \${$item['item_price']} (Stock: {$item['item_stock']}) 
                <form method='POST' action=''>
                    <input type='hidden' name='item_id' value='{$item['item_id']}'>
                    <label for='quantity'>Quantity:</label>
                    <input type='number' name='quantity' value='1' min='1' max='{$item['item_stock']}' required>
                    <button type='submit' name='restock'>Restock</button>
                </form></li>";
        }
        echo "</ul>";
    } else {
        echo "No products available.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['quantity']) && isset($_POST['restock'])) {
        $item_id = $_POST['item_id'];
        $quantity = $_POST['quantity'];

        if (restockItem($item_id, $quantity, $items)) {
            echo "Item restocked successfully.";
        } else {
            echo "Error restocking the item.";
        }
    } elseif (isset($_POST['save_cart'])) {
        // Save cart logic remains unchanged
        saveCart($_SESSION['cart']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Shopping Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 15px;
        }

        form {
            display: flex;
            align-items: center;
        }

        label {
            margin-right: 10px;
        }

        input[type="number"] {
            width: 50px;
        }

        button {
            padding: 5px 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div>
        <a href="./home.php">Back to Store</a>
    </div>
    <div class="container">
        <h1>Welcome to our store</h1>

        <?php displayProducts($items); ?>
    </div>
</body>

</html>