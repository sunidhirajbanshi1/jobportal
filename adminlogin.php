<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
       * {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: black;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}

h2 {
    text-align: center;
    color: #444;
    margin-bottom: 15px;
}

.container {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width: 400px;
    background: #fff;
    padding: 30px 20px;
    border-radius: 30px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.form-box {
    width: 100%;
}

.form-box header {
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}

.field {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
}

.field label {
    margin-bottom: 5px;
    font-size: 14px;
    color: #555;
}

.input input {
    height: 45px;
    padding: 0 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    transition: border 0.3s;
}

.input input:focus {
    border-color: #6e8efb;
}

.password-container {
    position: relative;
    display: flex;
    align-items: center;
}

.password-container input {
    padding-right: 155px; /* Space for the button */
}

.password-container button {
    position: absolute;
    right: 10px;
    background: none;
    border: none;
    font-size: 18px;
    color: #6e8efb;
    cursor: pointer;
    outline: none;
    height: 100%;
}

.btn {
    height: 45px;
    background: #6e8efb;
    border: none;
    border-radius: 5px;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}

.btn:hover {
    background: #5a79e5;
}

.link p {
    text-align: center;
    font-size: 14px;
    margin-top: 10px;
    color: #444;
}

.link a {
    text-decoration: none;
    color: #6e8efb;
    font-weight: 500;
    transition: color 0.3s;
}

.link a:hover {
    color: #5a79e5;
}
 /* Same CSS as your current code */
    </style>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <h2>Login</h2>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="field input">
                    <label for="password">Password:</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <button type="button" id="togglePassword">👁️</button>
                    </div>
                </div>
                <div class="field input">
                    <input type="submit" class="btn" name="submit" value="Login">
                </div>
               
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
        });
    </script>

    <?php
    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "jobportal");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $conn->real_escape_string($_POST['username']);
        $password = $_POST['password'];

        // Check if user exists
        $sql = "SELECT * FROM admin WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // print_r($user);
            if ($password ==  $user['password']) {
                session_start();
                $_SESSION['username'] = $username;
                // die('test');
                echo "<script>window.location='Admin.php';</script>";
                header("location:Admin.php");
                // exit();
            } else {
                echo '<script>alert("Invalid username or password.");</script>';
            }
        } else {
            echo '<script>alert("Invalid username or password.");</script>';
        }
    }

    $conn->close();
    ?>
</body>
</html>
