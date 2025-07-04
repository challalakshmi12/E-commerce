<?php
session_start();
include '../includes/db.php';

// Add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    // Fetch product info from database
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $item = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => 1
        ];

        // Add to session cart
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $found = false;
        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['id'] == $product_id) {
                $cart_item['quantity'] += 1;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = $item;
        }
    }
    header("Location: cart.php");
    exit();
}

// Remove from cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['id'] == $remove_id) {
            unset($_SESSION['cart'][$index]);
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; margin: 0; padding: 20px; }
        h2 { text-align: center; }
        .cart-item {
            display: flex;
            align-items: center;
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 0 5px #ccc;
        }
        .cart-item img {
            width: 100px;
            height: auto;
            margin-right: 15px;
            object-fit: cover;
        }
        .cart-details {
            flex: 1;
        }
        .remove-btn {
            padding: 8px 12px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .total {
            text-align: right;
            font-size: 1.2em;
            margin-top: 20px;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>

<a href="../index.php" class="back-link">← Continue Shopping</a>

<h2>Your Cart</h2>

<?php if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $item):
            $item_total = $item['price'] * $item['quantity'];
            $total += $item_total;
    ?>
    <div class="cart-item">
        <img src="../images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
        <div class="cart-details">
            <h4><?= htmlspecialchars($item['name']) ?></h4>
            <p>Price: ₹<?= number_format($item['price'], 2) ?></p>
            <p>Quantity: <?= $item['quantity'] ?></p>
            <p>Subtotal: ₹<?= number_format($item_total, 2) ?></p>
        </div>
        <form method="GET" action="cart.php">
            <input type="hidden" name="remove" value="<?= $item['id'] ?>">
            <button type="submit" class="remove-btn">Remove</button>
        </form>
    </div>
    <?php endforeach; ?>

    <div class="total">
        <strong>Total: ₹<?= number_format($total, 2) ?></strong>
    </div>
<?php endif; ?>

</body>
</html>
