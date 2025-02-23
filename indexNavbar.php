<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <style>
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            margin-right: 10px;
        }

        .logo span {
            font-size: 20px;
            font-weight: bold;
            color: #0056b3;
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav a {
            color: #333;
            text-decoration: none;
            margin-left: 20px;
            transition: color 0.3s ease;
            padding: 10px;
        }

        nav a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <img src="logo.png" alt="Logo">
            <span>JOBS</span>
        </div>

        <nav>
            <a href="index1.php">Home</a>
            <a href="Aboutus.html">About Us</a>
            <a href="contact.html">Contact Us</a>
            <div class="dropdown">
                <a href="job_categories.php" class="dropbtn">Job Categories</a>
                <div class="dropdown-content">
                    <a href="#">IT & Software</a>
                    <a href="#">Healthcare</a>
                    <a href="#">Finance</a>
                    <a href="#">Education</a>
                    <a href="#">Engineering</a>
                </div>
            </div>
            <a href="jobseeker1.php">Jobseekers</a>
            <a href="employerlogin.php">Employers</a>
        </nav>
    </div>
</body>
</html>