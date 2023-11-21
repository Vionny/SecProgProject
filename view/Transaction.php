<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

function addToCart($item_id, $quantity, &$items) {
    if (isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id] += $quantity;
    } else {
        $_SESSION['cart'][$item_id] = $quantity;
    }

    if (isset($items[$item_id]) && $items[$item_id]['item_stock'] >= $quantity) {
        $items[$item_id]['item_stock'] -= $quantity;
        return true; 
    } else {
        return false; 
    }
}

function reduceQuantity($item_id, $quantity, &$items) {
    if (isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id] -= $quantity;

        $items[$item_id]['item_stock'] += $quantity;

        if ($_SESSION['cart'][$item_id] <= 0) {
            unset($_SESSION['cart'][$item_id]);
        }

        return true;
    } else {
        return false; 
    }
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

$items = array(
    '1' => array('item_id' => 1, 'item_name' => 'Product 1', 'item_price' => 10, 'item_stock' => 50),
    '2' => array('item_id' => 2, 'item_name' => 'Product 2', 'item_price' => 15, 'item_stock' => 30),
    '3' => array('item_id' => 3, 'item_name' => 'Product 3', 'item_price' => 20, 'item_stock' => 20),
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['quantity'])) {
        $item_id = $_POST['item_id'];
        $quantity = $_POST['quantity'];

        if (addToCart($item_id, $quantity, $items)) {
            echo "Item added to the cart successfully.";
        } else {
            echo "Insufficient stock.";
        }
    } elseif (isset($_POST['reduce_quantity'])) {
        $item_id = $_POST['item_id'];
        $reduce_quantity = $_POST['reduce_quantity'];

        if (reduceQuantity($item_id, $reduce_quantity, $items)) {
            echo "Quantity reduced successfully.";
        } else {
            echo "Error reducing quantity.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Shopping Cart</title>
</head>
<body>

    <h1>Welcome to our store</h1>

    <?php displayProducts($items); ?>

    <?php displayCart($items); ?>

</body>
</html>