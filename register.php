<?php
// Connect to your database (replace with your credentials)
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "jobportal";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve email and password from form
$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password for comparison (replace with a strong hashing algorithm)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare and execute the query
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // Successful login, redirect to dashboard or other page
        header("Location: dashboard.php");
        exit();
    } else {
        // Incorrect password
        echo "Incorrect password.";
    }
} else {
    // User not found
    echo "User not found.";
}

$stmt->close();
$conn->close();
?>