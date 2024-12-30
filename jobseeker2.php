<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Account</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body style */
        body {
            font-family: Arial, sans-serif;
            display: flex;
        }

        /* Left background image */
        .left-bg {
            flex: 1;
            
            background-position: left;
           
            margin-right: 250px;
            margin-top: 100px;
            margin-left: 5px;
        }

        /* Right form container */
        .right-form {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 75px;
            position: relative;
        }

        .form {
            background-color: #ffffffe4;
            padding: 15px;
            border-radius: 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 85%;
            margin-left:80px;
            margin-top: 40px;
        }

        h3 {
            text-align: center;
            margin-bottom: 15px;
            color: #0056b3;
        }

        label {
            display: block;
            margin-bottom: 2px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background: #0056b3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
        }

        button:hover {
            background: #003d80;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

       
       

       /* Navigation Bar Specific Styles */
.navbar {
    display: flex;
    justify-content: flex-end; /* Align navigation items to the right */
    align-items: center;
    padding: 30px;
    background-color: #ffffff; /* White background */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Light shadow for a floating effect */
    position: fixed; /* Stays at the top */
    top: 0;
    width: 100%; /* Spans the entire width of the page */
    z-index: 1000; /* Ensures it stays above other elements */
}

/* Navigation links */
.navbar a {
    color: #333; /* Dark gray text color */
    text-decoration: none; /* Remove underline */
    margin-left: 20px; /* Space between links */
    font-size: 16px; /* Adjust font size */
    transition: color 0.3s ease; /* Smooth color transition */
}

.navbar a:hover {
    color: #0056b3; /* Highlight color on hover */
    text-decoration: underline; /* Optional underline on hover */
}

/* Optional: Add active link style */
.navbar a.active {
    font-weight: bold;
    color: #0056b3; /* Same as hover color */
}

    </style>
</head>
<body>
    <nav class="navbar">
    <?php include("indexNavbar.php") ?>
    </nav>

    <div class="left-bg">
        <div class="image-container"> 
            <img src="Images/Image2.JPG" alt="Job Portal Image" style="width: 200%; height: 100%; object-fit: cover;"> 
        </div>
    </div>

    <div class="right-form">
        <form class="form" action="jobseeker2.php" method="post">
            <h3>Create your Account</h3>
            <label for="fname">Fullname</label>
            <input type="text" id="fName" name="fName" placeholder="Enter Your First Name" required>
            <label for="phone">Phone Number</label>
            <input type="number" id="phone" name="phone" placeholder="Enter Your Phone Number" required>
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter Your Email Address" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Your Password" required>
            <label for="cpassword">Confirm Password</label>
            <input type="password" id="cpassword" name="cpassword" placeholder="Confirm Your Password" required>
            <button type="submit" name="submit">Sign Up</button>
            <p>Already have an account? <a href="jobseeker1.php">Login</a></p>
        </form>
    </div>
</body>
</html>