<?php
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "jobportal");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password =md5( $_POST["password"]);

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT id, password FROM jobseeker2 WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['jobseeker_id'] = $row['id']; 
            header("Location: jobseekerdashboard.php"); // Redirect to dashboard
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
// Check if the form is submitted
/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Validate input
    if (empty($email) || empty($password)) {
        echo "<script>alert('Email and password are required.');</script>";
    } else {
        // Query to fetch the user by email
        $sql = "SELECT id, password FROM jobseeker2 WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables for the logged-in user
                $_SESSION['jobseeker_id'] = $user['id'];
                $_SESSION['email'] = $email;

                // Redirect to the dashboard
                header("Location: jobseekerdashboard.php");
                exit();
            } else {
                echo "<script>alert('Invalid email or password.');</script>";
            }
        } else {
            echo "<script>alert('No account found with that email.');</script>";
        }

        $stmt->close();
    }
}*/}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobseeker Login</title>
    <style>
        body {
            background: url(Images/Image2.JPG) no-repeat center center/cover;
            font-family: Arial, sans-serif;
          display:flex;
          justify-content: center;
          align-items: center;
          margin:0;
          background-color:#f4f4f4;
        
          
        }
        
        .main-content {
            display: flex;
            height: 100vh;
        }
        .content-area {
            flex: 1;
            padding: 50px;
        }
        .login-container {
            display:flex;
            flex-direction:column;
            background-color: rgba(0, 0, 0, 0.5);
            width: 300px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 40px;
            margin-right: 60px;
            align-self: center;
            margin-top: 5px;
            padding-top: 10px;
            text-align:center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: white;
        }
        .login-container label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: white;
            text-align:left;
        }
        .login-container input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .login-container input[type="checkbox"] {
            width: auto;
            margin-right: 5px;
        }
        .login-container a {
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }
        .login-container .btn {
            width: 100%;
            background: #0056b3;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .login-container .btn:hover {
            background: #003d80;
        }
        .login-container .register {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
        .register a{
color: #ffffff;
        }
        .login-container .register a {
            color: #f1c40f;
            font-weight: bold;
        }
        /* Navbar Styles */
.navbar {
    display: flex;
    justify-content: space-between; /* Space between logo and navigation links */
    align-items: center;
    padding: 10px 2px;
    background-color: #ffffff; /* White background */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
    position: fixed; /* Sticks to the top of the page */
    top: 0;
    width: 100%; /* Full width */
    z-index: 1000; 
    
   /* Add a subtle box shadow */
/* Ensures it stays above other elements */
}

.navbar .logo {
    display: flex;
    align-items: center;
}

.navbar .logo img {
    height: 40px;
    margin-right: 10px;
}

.navbar .logo span {
    font-size: 20px;
    font-weight: bold;
    color: #0056b3; /* Blue color for "JOBS" */
}

.navbar a {
    color: #333; /* Text color */
    text-decoration:none;
    margin-left: 60px;
    font-size: 16px;
    transition: color 0.3s ease;
}

.navbar a:hover {
    color: #0056b3;
    text-decoration: underline; /* Blue highlight on hover */
}

/* Active link style (optional) */
.navbar a.active {
    font-weight: bold;
    color: #0056b3;
}

    
    </style>
</head>
<body>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="logo.png" alt="Logo"> <!-- Replace 'logo.png' with your actual logo path -->
            <span>JOBS</span>
        </div>
        <div>
        <a href="index1.php">Home</a> 
             <a href="Aboutus.html">About Us</a>
             <a href="contact.html">Contact Us</a>
            <a href="jobseeker1.php">Jobseekers</a>
            <a href="employerlogin.php">Employers</a>
           
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Content area -->
        <div class="content-area">
            <!-- Add any left-side content here -->
        </div>

        <!-- Login Form -->
        <div class="login-container">
            <h2>Jobseeker Login</h2>
            <form action="login.php" method="post">
                <label for="email">E-mail address</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
                
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember" style="display: inline;">Remember Me</label>
                    </div>
                    <a href="#">Forgot Password?</a>
                </div>
                
                <button type="submit" class="btn">Login</button>
            </form>
            <div class="register">
                Don't have an account? <a href="jobseeker2.php">Register Now</a>
            </div>
        </div>
    </div>
</body>
</html>