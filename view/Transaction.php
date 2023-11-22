<?php
  require_once "../../db/dbConnection.php";
  require_once "../../middleware/AuthMiddleware.php";
  require_once "../../middleware/RoleMiddleware.php";

  RoleMiddleware::getInstance()->checkRole('customer');
?>

<?php
    session_start();
    require_once "../model/Item.php";
    function resetCart() {
        $_SESSION['cart'] = array();
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (!isset($_SESSION['items'])) {
        $_SESSION['items'] = array();
    }

    function generateTransactionId() {
        return uniqid('transaction_');
    }

    function saveCart($cart, $transactionId) {
        if (empty($cart)) {
            echo "Error: Your shopping cart is empty.<br>Add items to the cart before saving.";
            return;
        }

        $_SESSION['saved_carts'][$transactionId] = array(
            'cart' => $cart,
            'transaction_date' => date('Y-m-d H:i:s')
        );

        resetCartAndRedirect();
    }

    function restockItems($item_id, $quantity, &$items) {
        if (isset($items[$item_id])) {
            $items[$item_id]['item_stock'] += $quantity;
        }
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

    function resetCartAndRedirect() {
        resetCart();
        header("Location: ../index.php");
        exit();
    }

    function displayProducts($items) {
        echo "<h2>Product List</h2>";
        if (!empty($items)) {
            echo "<ul>";
            $query = "select * from items";
    
            $conn = new mysqli(
      'localhost','root','','secprogdb');
    $result = mysqli_query($conn, $query);
      foreach ($result as $res) {
          echo '<li>item name : '. $res['item_name'];
          echo "<br>";
          echo "item price : " . $res["item_price"];
        echo "<br>";
        echo "seller id : " . $res["seller_id"];
        echo "<br>";
        echo "item description : " . $res["item_description"];
        echo "<br>";
        echo "stock : " . $res["item_stock"];
        echo "<br>";
       echo "
            <form method='POST' action=''>
          <input type='hidden' name='item_id' value='{$res['item_id']}'>
             <label for='quantity'>Quantity:</label>
            <input type='number' name='quantity' value='1' min='1' max='{$res['item_stock']}' required>
             <button type='submit'>Add to Cart</button>
                </form>";

      }
            // foreach ($result as $results) {
            //     echo "<li>{$results['item_name']} - \${$result['item_price']} (Stock: {$result['item_stock']}) 
            //     <form method='POST' action=''>
            //         <input type='hidden' name='item_id' value='{$result['item_id']}'>
            //         <label for='quantity'>Quantity:</label>
            //         <input type='number' name='quantity' value='1' min='1' max='{$item['item_stock']}' required>
            //         <button type='submit'>Add to Cart</button>
            //     </form>
                
            //     <!-- Add restock form -->
            //     <form method='POST' action=''>
            //         <input type='hidden' name='restock_item_id' value='{$item['item_id']}'>
            //         <label for='restock_quantity'>Restock Quantity:</label>
            //         <input type='number' name='restock_quantity' value='1' min='1' required>
            //         <button type='submit'>Restock</button>
            //     </form></li>";
            // }
            // echo "</ul>";
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
                echo "Item's added to the cart successfully.";
            } else {
                echo "Insufficient stock.";
            }
        } elseif (isset($_POST['reduce_quantity'])) {
            $item_id = $_POST['item_id'];
            $reduce_quantity = $_POST['reduce_quantity'];

            if (reduceQuantity($item_id, $reduce_quantity, $_SESSION['items'])) {
                echo "Quantity reduced successfully.";
            } else {
                echo "Error reducing the quantity.";
            }
        } elseif (isset($_POST['save_cart'])) {
            $transactionId = generateTransactionId();
            saveCart($_SESSION['cart'], $transactionId);
        } elseif (isset($_POST['restock_item_id']) && isset($_POST['restock_quantity'])) {
            $restock_item_id = $_POST['restock_item_id'];
            $restock_quantity = $_POST['restock_quantity'];
            restockItems($restock_item_id, $restock_quantity, $_SESSION['items']);
            echo "Item's restocked successfully.";
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
            
            <?php 
                displayProducts($_SESSION['items']);
            ?>
        
            <?php 
                displayCart($_SESSION['items']); 
            ?>
   <!-- <?php
    $result = item::getSellerItem();
      while($item = $result->fetch_assoc()){
        ?>
        <hr>
          <div>
            <div>
              <label>Item name : <?= htmlspecialchars($item['item_name'])?></label>
            </div>
            <div>
              <label>Item description : <?= htmlspecialchars($item['item_description'])?></label>
            </div>
            <div>
              <label>Item Price : Rp. <?= htmlspecialchars($item['item_price'])?></label>
            </div>
            <div>
              <label>Item Stock : <?= htmlspecialchars($item['item_stock'])?></label>
            </div>
          </div>
          <form method="POST">
            <button type="submit">Update</button>
          </form>
          <form action="../../../actions/doDeleteItem.php" method="POST">
            <input type="hidden"name="item_id" value="<?=$item['item_id']?>">
            <button type="submit">Delete</button>
          </form>
        <hr>
        <?php
      }
    ?> -->
            <form method='POST' action=''>
                <button type='submit' name='save_cart'>Save Cart</button>
            </form>
        </div>
    </body>
</html>