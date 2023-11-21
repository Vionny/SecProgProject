<?php
session_start();

// Function to reset the shopping cart
function resetCart() {
    $_SESSION['cart'] = array();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (!isset($_SESSION['items'])) {
    $_SESSION['items'] = array(
        '1' => array('item_id' => 1, 'item_name' => 'Product 1', 'item_price' => 10, 'item_stock' => 50),
        '2' => array('item_id' => 2, 'item_name' => 'Product 2', 'item_price' => 15, 'item_stock' => 30),
        '3' => array('item_id' => 3, 'item_name' => 'Product 3', 'item_price' => 20, 'item_stock' => 20),
    );
}

// Function to generate a unique transaction ID
function generateTransactionId() {
    return uniqid('transaction_');
}

// Function to save the shopping cart with a transaction ID
function saveCart($cart, $transactionId) {
    $_SESSION['saved_carts'][$transactionId] = $cart;
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

// Function to reset the cart and redirect
function resetCartAndRedirect() {
    resetCart();
    header("Location: ../index.php");
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

        if (addToCart($item_id, $quantity, $_SESSION['items'])) {
            echo "Item added to the cart successfully.";
        } else {
            echo "Insufficient stock.";
        }
    } elseif (isset($_POST['reduce_quantity'])) {
        $item_id = $_POST['item_id'];
        $reduce_quantity = $_POST['reduce_quantity'];

        if (reduceQuantity($item_id, $reduce_quantity, $_SESSION['items'])) {
            echo "Quantity reduced successfully.";
        } else {
            echo "Error reducing quantity.";
        }
    } elseif (isset($_POST['save_cart'])) {
        // Save the shopping cart with a new transaction ID
        $transactionId = generateTransactionId();
        saveCart($_SESSION['cart'], $transactionId);
        echo "Shopping cart saved successfully with transaction ID: $transactionId";

        // Reset the cart and redirect back to index.php after saving the cart
        resetCartAndRedirect();
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
            height: 100vh;
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
    
        <?php displayProducts($_SESSION['items']); ?>
    
        <?php displayCart($_SESSION['items']); ?>

        <!-- Add the save button -->
        <form method='POST' action=''>
            <button type='submit' name='save_cart'>Save Cart</button>
        </form>
    </div>
</body>
</html>