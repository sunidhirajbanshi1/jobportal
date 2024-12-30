<?php
// Include database connection
include('db.php');

// Save settings when the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $site_name = trim($_POST['site_name']);
    $admin_email = trim($_POST['admin_email']);
    $items_per_page = intval($_POST['items_per_page']);

    if (!empty($site_name) && !empty($admin_email) && $items_per_page > 0) {
        $stmt = $conn->prepare("UPDATE settings SET site_name = ?, admin_email = ?, items_per_page = ? WHERE id = 1");
        $stmt->bind_param("ssi", $site_name, $admin_email, $items_per_page);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch current settings
$settings = $conn->query("SELECT * FROM settings WHERE id = 1")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ccc;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            color: #444;
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], input[type="email"], input[type="number"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            background-color: #e7f3e7;
            color: #2e7d32;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #d4edda;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Portal Settings</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
            <div class="message">Settings have been successfully updated!</div>
        <?php endif; ?>

        <form method="POST">
            <label for="site_name">Site Name:</label>
            <input type="text" name="site_name" id="site_name" value="<?php echo htmlspecialchars($settings['site_name']); ?>" required>

            <label for="admin_email">Admin Email:</label>
            <input type="email" name="admin_email" id="admin_email" value="<?php echo htmlspecialchars($settings['admin_email']); ?>" required>

            <label for="items_per_page">Items Per Page:</label>
            <input type="number" name="items_per_page" id="items_per_page" value="<?php echo htmlspecialchars($settings['items_per_page']); ?>" min="1" required>

            <button type="submit">Save Settings</button>
        </form>
    </div>
</body>
</html>