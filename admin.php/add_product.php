<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

$success_message = '';
$error_message = '';

if (isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $description = trim($_POST['description']);
    $image = $_FILES['image']['name'];

    // Validate input
    if ($name && $price && $description && $image) {
        $imagePath = "../images/" . basename($image);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $price, $description, $image]);

            $success_message = "✅ Product added successfully!";
        } else {
            $error_message = "❌ Failed to upload image.";
        }
    } else {
        $error_message = "❌ All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, textarea {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            text-decoration: none;
            color: #4CAF50;
        }
        .message {
            text-align: center;
            font-size: 1em;
            margin-bottom: 20px;
            color: #333;
        }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Product</h2>

        <?php if ($error_message): ?>
            <p class="message error"><?= htmlspecialchars($error_message) ?></p>
        <?php elseif ($success_message): ?>
            <p class="message success"><?= htmlspecialchars($success_message) ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" id="price" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="4" required></textarea>

            <label for="image">Image:</label>
            <input type="file" name="image" id="image" required>

            <button type="submit" name="add_product">Add Product</button>
        </form>

        <div class="back-link">
            <a href="manage_products.php">← Back to Manage Products</a>
        </div>
    </div>
</body>
</html>
