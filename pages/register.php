<?php
include '../includes/db.php';  // ← ✅ corrected path

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email.";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "This email is already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $insert->bind_param("ss", $email, $hashedPassword);
            if ($insert->execute()) {
                $success_message = "Registration successful! You can now log in.";
            } else {
                $error_message = "Something went wrong. Please try again.";
            }
            $insert->close();
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: linear-gradient(120deg, #eef1f5, #dbefff);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-box {
            background-color: #ffffff;
            padding: 35px 30px;
            border-radius: 10px;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .form-box h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }
        .form-box label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            color: #444;
        }
        .form-box input[type="email"],
        .form-box input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .form-box input:focus {
            border-color: #5a9de0;
            outline: none;
        }
        .form-box button {
            width: 100%;
            padding: 12px;
            background-color: #5a9de0;
            color: white;
            font-weight: bold;
            font-size: 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .form-box button:hover {
            background-color: #417bc1;
        }
        .message-box {
            text-align: center;
            font-size: 0.95em;
            margin-top: 15px;
        }
        .message-box.error {
            color: #e74c3c;
        }
        .message-box.success {
            color: #27ae60;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Create Account</h2>
        <form method="POST">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" name="register">Register</button>
        </form>

        <?php if (!empty($error_message)): ?>
            <div class="message-box error"><?= htmlspecialchars($error_message); ?></div>
        <?php elseif (!empty($success_message)): ?>
            <div class="message-box success"><?= htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
