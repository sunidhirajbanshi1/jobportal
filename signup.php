<?php include("indexNavbar.php")?>
<?php if(session_start()) {
    session_destroy();
} ?>
<?php
if (isset($_POST["submit"])) {
    $fName = $_POST["fName"];
    $lName = $_POST["phone"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
   

    if (empty($fName) && empty($phone) && empty($email) && empty($password) && empty($cpassword)) {
        echo '<script> alert("Enter the data..")</script>';
    } else {
        $sql = "SELECT * FROM jobseeker WHERE email ='$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo '<script> alert("The email already exists.")</script>';
            $conn->close();

        } else {
            if ($password == $cpassword) {
                $hashpassword = password_hash("$password", PASSWORD_DEFAULT);
                $sql = "INSERT INTO `jobseekers` ( `fName`, `phone`, `email`, `password`) VALUES (?,?,?,?);";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", $fName, $phone, $email, $hashpassword);
                $stmt->execute();
            echo '<script> alert("Register successfully");window.location.href="jobseeker1.php"; </script>';

                header("location:jobseeker1.php");
                $stmt->close();
                
            }
        }
    }

}
?>




<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Create Your Account</title>
    <style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-image: url(../Image/Home/1.jpg);
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;

}

.form {
    background-color: #ffffffe4;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 50px rgba(0, 0, 0, 2);
    width: 100%;
    text-align: center;

}

label {
    display: block;
    margin-bottom: 8px;
}

input , select{
    width: 100%;
    padding: 8px;
    margin-bottom: 16px;
    box-sizing: border-box;
}

button {
    background-color: #4caf50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;

}
#S1 a{
    text-decoration: none;
    color: white;
}

.name-input {
    display: flex;
    gap: 10px;
}

.form input {
    width: 100%;
    border-radius: 10px;
}

#S1 {
    width: 100%;
    border-radius: 20px;
    font-weight: bolder;
    font-size: larger;
}

.logo {
    width: 130px;
    cursor: pointer;
    float: left;
}



    </style>
</head>

<body>


    <form action="signup.php" method="post">
        <div class="form">
            <a href="index1.php"> <img src="../Image/logo/logo1.png" alt="logo" class="logo"></a>
            <a href="index1.php"><img src="../Image/logo/X.png" alt="x"
                    style="float: inline-end; width: 20px; height: 20px;"></a>

            <br><br><br>
            <h2>Create Your Account </h2>
            <br>
            <input type="text" id="firstName" name="fName" placeholder=" Enter Your First name" required>

            <input type="number" id="phone" name="phone" placeholder=" Enter Your Phone Number" required>
            <br>
            <input type="email" id="email" name="email" placeholder="Enter Your Email Address" required>
            <br> <input type="password" id="password" name="password" pattern=".{8,}" title="Password must be at least 8 characters" required placeholder="Enter Password (at least 10 characters)"            <br>
 <input type="password" id="confirmpassword" name="cpassword" placeholder="Confirm password" required>
            <br>
            

            <center>
                <br>
                <button type="submit" id="S1" name="submit">Sign Up</button>
            </center>

            <h5 style="color: red;"> -- Already have an account ? <a href="jobseekerlogin.php"
                    style="border: 0; ">Login</a>

        </div>
    </form>
   
</body>

</html>

 ?>
