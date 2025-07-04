<?php
session_start();
include 'includes/db.php'; // mysqli connection

// Handle logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: pages/login.php");
    exit();
}

// Fetch products from DB
$products = [];
$result = $conn->query("SELECT * FROM products");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f2f2f2;
        }
        .header-container {
            background: #333;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-container h1 {
            margin: 0;
        }
        nav a, nav button {
            margin-left: 15px;
            color: white;
            text-decoration: none;
            font-weight: bold;
            background: none;
            border: none;
            cursor: pointer;
        }
        .cart-icon {
            width: 20px;
            vertical-align: middle;
        }
        .main-container {
            padding: 20px;
        }
        .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .product {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            text-align: center;
        }
        .product img {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
        }
        .add-to-cart-button {
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        footer {
            text-align: center;
            padding: 10px;
            background: #222;
            color: white;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<header>
    <div class="header-container">
        <h1>Welcome to Our Store</h1>
        <nav>
            <a href="pages/login.php">Login</a>
            <a href="pages/register.php">Register</a>
            <a href="pages/cart.php">
                <img src="images/cart.png" alt="Cart" class="cart-icon"> Cart
            </a>
            <form method="POST" action="" style="display:inline;">
                <button type="submit" name="logout">Logout</button>
            </form>
        </nav>
    </div>
</header>

<div class="main-container">
    <main>
        <h2>Products</h2>
        <div class="product-list">
            <?php if (empty($products)) : ?>
                <p>No products available.</p>
            <?php else : ?>
                <?php foreach ($products as $product) : ?>
                    <div class="product">
                        <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <p>₹<?= number_format($product['price'], 2) ?></p>
                        <p><?= htmlspecialchars($product['description']) ?></p>
                        <form method="POST" action="pages/cart.php">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <button type="submit" name="add_to_cart" class="add-to-cart-button">Add to Cart</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</div>

<footer>
    <p>&copy; <?= date('Y') ?> Online Store. All rights reserved.</p>
</footer>

</body>
</html>
