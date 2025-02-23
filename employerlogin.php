<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "jobportal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT id, password FROM employer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['employer_id'] = $row['id']; 
            header("Location: employerdashboard.php"); // Redirect to dashboard
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
    body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: whitesmoke;
  height: 100vh;
  background: url(Images/Image2.JPG) no-repeat center center/cover;
}

.login-container {
  border-radius: 40px;
  padding: 10px;
  width: 350px;
  background-color: rgba(0, 0, 0, 0.5);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  text-align: center;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.login-container h1 {
  margin-bottom: 10px;
  color: #333;
}

.login-container input[type="email"],
.login-container input[type="password"] {
  width: 90%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
}

.login-container .btn {
  background: #0056b3;
  color: white;
  border: none;
  padding: 10px;
  border-radius: 5px;
  font-size: 16px;
  margin-left: 20px;
  cursor: pointer;
  margin-top: 10px;
  margin-bottom: 5px;
  width:310px;
}

.login-container .btn:hover {
  background-color: #0056b3;
}

.login-container p {
  margin: 10px 0;
}

.login-container a {
  color: #007bff;
  text-decoration: none;
}

.login-container a:hover {
  text-decoration: underline;
}

.error {
  color: red;
  margin-bottom: 10px;
}

.login-container .register {
  text-align: center;
  margin-top: 20px;
  font-size: 14px;
  margin-bottom: 10px;

}

.register a {
  color: rgb(220, 93, 93);
}

.login-container .register a {
  color: #f1c40f;
  font-weight: bold;
}

.login-container label {
  display: block;
  margin-bottom: 3px;
  margin-left: 15px;
  font-size: 14px;
  color: white;
  text-align: left;
}

/* Remember Me checkbox and button layout */

.login-container input[type="checkbox"] {
  width: auto;
  margin-right: 1px;
  margin-left:-165px;
}

    </style>
</head>
<body>

    <?php include("indexNavbar.php")?>
    


    
    <div class="login-container">
        <form class="login-box" method="POST" action="">
            <h1 style="color:white">Employer Login</h1>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <label for="email">Email Address</label>
            <input type="email" name="email" placeholder="Enter your email" required>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
            <div style="display: flex; justify-content: space-between; align-items: left;">
                    <div>
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember" style="display: inline;">Remember Me</label>
            <div>
           <div>
                    <button type="submit" class="btn">Login</button>
            </div>
            <div class="register">
            <span style="color:white;">Don't you have an account?</span> <a href="employer.php">Register Now</a>
            </div>
        </form>
    </div>
</body>
</html>