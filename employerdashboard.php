<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobportal";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['employer_id'])) {
    header("Location: employerlogin.php");
    exit();
}

$employer_id = $_SESSION['employer_id'];

// Fetch employer details
$sql = "SELECT * FROM employer WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employer_id);
$stmt->execute();
$result = $stmt->get_result();
$employer = $result->fetch_assoc();
$stmt->close();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employer Dashboard</title>
    <style>
        /* CSS styles for the dashboard */
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        nav {
            background-color: #f0f0f0;
            padding: 10px;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline-block;
            margin-right: 20px;
        }

        nav a {
            text-decoration: none;
            color: #333;
        }

        main {
            padding: 20px;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
        }

        .welcome-message {
            margin-bottom: 20px;
        }

        .dashboard-section {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <header>
        <h1>Welcome, <?php echo $employer['organization_name']; ?></h1>
    </header>

    <nav>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="post_job.php">Post a Job</a></li>
            <li><a href="manage_jobs.php">Manage Jobs</a></li>
            <li><a href="view_applications.php">View Applications</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <main class="container">
        <div class="welcome-message">
            <h2>Welcome to your Employer Dashboard!</h2>
            <p>Here you can manage your job postings, view applications, and more.</p>
        </div>

        <div class="dashboard-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="post_job.php">Post a New Job</a></li>
                <li><a href="manage_jobs.php">View and Edit Posted Jobs</a></li>
                <li><a href="view_applications.php">View Job Applications</a></li>
            </ul>
        </div>

        </div> 

    </main>

</body>
</html>