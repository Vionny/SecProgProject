<?php
session_start();
require_once "../../db/dbConnection.php";
require_once "../../middleware/AuthMiddleware.php";
require_once "../../middleware/RoleMiddleware.php";

RoleMiddleware::getInstance()->checkRole('customer');
$conn = Connect::getInstance()->getDBConnection();

$items = fetchItemsFromDatabase(); 

function resetCart() {
    $_SESSION['cart'] = array();
}

function fetchItemsFromDatabase() {
    global $conn;

    $items = array();

    $stmt = $conn->prepare("SELECT item_id, item_name, item_description, item_price, item_stock, seller_id FROM items");
    $stmt->execute();
    $stmt->bind_result($itemId, $itemName, $itemDescription, $itemPrice, $itemStock, $seller_id);

    while ($stmt->fetch()) {
        $items[$itemId] = array(
            'item_id' => $itemId,
            'item_name' => $itemName,
            'item_description' => $itemDescription,
            'item_price' => $itemPrice,
            'item_stock' => $itemStock,
            'seller_id' => $seller_id
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
    // var_dump($cart);
    $stmt = $conn->prepare("INSERT INTO transactions_header (customer_id, seller_id, transaction_date) VALUES (?, ?, ?)");
    $user = AuthMiddleware::getInstance()->checkAuth();
    $customerId = $user['user_id'];
    $sellerId = 1;
    $transactionDate = date('Y-m-d');
    $stmt->bind_param("iis", $customerId, $sellerId, $transactionDate);
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

function addToCart($item_id, $quantity, &$items) {
    global $conn;

    if (isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id] += $quantity;
    } else {
        $_SESSION['cart'][$item_id] = $quantity;
    }

    if (isset($items[$item_id]) && $items[$item_id]['item_stock'] >= $quantity) {
        $items[$item_id]['item_stock'] -= $quantity;
        $stmt = $conn->prepare("UPDATE items SET item_stock = item_stock - ? WHERE item_id = ?");
        $stmt->bind_param("ii", $quantity, $item_id);
        $stmt->execute();
        $stmt->close();

        return true;
    } else {
        return false;
    }
}

function reduceQuantity($item_id, $quantity, &$items) {
    global $conn;

    if (isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id] -= $quantity;

        $items[$item_id]['item_stock'] += $quantity;

        $stmt = $conn->prepare("UPDATE items SET item_stock = item_stock + ? WHERE item_id = ?");
        $stmt->bind_param("ii", $quantity, $item_id);
        $stmt->execute();
        $stmt->close();

        if ($_SESSION['cart'][$item_id] <= 0) {
            unset($_SESSION['cart'][$item_id]);
        }

        return true;
    } else {
        return false;
    }
}

function resetCartAndRedirect() {
    resetCart();
    header("Location: ./transaction.php");
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
                <button type='submit'>Add to Cart</button>
            </form></li>";
        }
        echo "</ul>";
    } else {
        echo "No products available.";
    }
}

function displayCart($items) {
    echo "<h2>Shopping Cart</h2>";
    if (empty($_SESSION['cart'])) {
        echo "Your cart is empty.";
    } else {
        echo "<ul>";
        foreach ($_SESSION['cart'] as $item_id => $quantity) {
            $item = $items[$item_id];
            echo "<li>{$item['item_name']} - \${$item['item_price']} (Quantity: $quantity)
            <form method='POST' action=''>
                <input type='hidden' name='item_id' value='{$item['item_id']}'>
                <label for='reduce_quantity'>Reduce Quantity:</label>
                <input type='number' name='reduce_quantity' value='1' min='1' max='$quantity' required>
                <button type='submit'>Reduce Quantity</button>
            </form></li>";
        }
        echo "</ul>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['quantity'])) {
        $item_id = $_POST['item_id'];
        $quantity = $_POST['quantity'];

        if (addToCart($item_id, $quantity, $items)) {
            echo "Item's added to the cart successfully.";
        } else {
            echo "Insufficient stock.";
        }
    } elseif (isset($_POST['reduce_quantity'])) {
        $item_id = $_POST['item_id'];
        $reduce_quantity = $_POST['reduce_quantity'];

        if (reduceQuantity($item_id, $reduce_quantity, $items)) {
            echo "Quantity reduced successfully.";
        } else {
            echo "Error reducing the quantity.";
        }
    } elseif (isset($_POST['save_cart'])) {
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

        h1, h2 {
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
    <div class="container">
        <h1>Welcome to our store</h1>
    
        <?php displayProducts($items); ?>
    
        <?php displayCart($items); ?>

        <form method='POST' action=''>
            <button type='submit' name='save_cart'>Save Cart</button>
        </form>
    </div>
</body>
</html>