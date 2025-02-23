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

// Fetch total jobs posted by the employer
/*$sql_jobs = "SELECT COUNT(*) AS total_jobs FROM job WHERE employer_id = ?";
$stmt = $conn->prepare($sql_jobs);
$stmt->bind_param("i", $employer_id);
$stmt->execute();
$result = $stmt->get_result();
$job_data = $result->fetch_assoc();
$total_jobs = $job_data['total_jobs'];
$stmt->close();*/

// Fetch total applications received by the employer
/*$sql_applications = "SELECT COUNT(*) AS total_applications FROM job_applications WHERE employer_id = ?";
$stmt = $conn->prepare($sql_applications);
$stmt->bind_param("i", $employer_id);
$stmt->execute();
$result = $stmt->get_result();
$application_data = $result->fetch_assoc();
$total_applications = $application_data['total_applications'];
$stmt->close();*/

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #2c3e50;
            color: #fff;
            padding-top: 20px;
        }

        .sidebar a {
            display: block;
            color: #fff;
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #1abc9c;
        }

        .sidebar .logo {
            font-size: 24px;
            text-align: center;
            margin-bottom: 30px;
            color: #fff;
            font-weight: bold;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        /* Header */
        header {
            background-color:rgb(23, 38, 55);
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 20px;
        }

        /* Stats Section */
        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .stats-box {
            background-color: #34495e;
            color: white;
            padding: 20px;
            border-radius: 5px;
            width: 30%;
            text-align: center;
            font-size: 18px;
        }

        .stats-box h3 {
            font-size: 24px;
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            justify-content: space-around;
            padding: 20px;
        }

        .action-box {
            background: #1abc9c;
            color: white;
            padding: 15px;
            border-radius: 5px;
            width: 30%;
            text-align: center;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .action-box a {
            text-decoration: none;
            color: white;
        }

        .action-box:hover {
            background-color: #16a085;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 15px;
            background-color: #007BFF;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">Employer Dashboard</div>
        <a href="employerdashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="job_posting.php"><i class="fas fa-plus-circle"></i> Post a Job</a>
        <a href="manage_jobs.php"><i class="fas fa-edit"></i> Manage Jobs</a>
        <a href="manage_categories.php"><i class="fas fa-cogs"></i> Manage Categories</a>
        <a href="view_job_applications.php"><i class="fas fa-eye"></i> View Applications</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h2>Welcome, <?php echo htmlspecialchars($employer['organization_name']); ?>!</h2>
        </header>

        <div class="container">
            <h2 class="dashboard-title">Employer Dashboard</h2>

            <!-- Statistics -->
            <div class="stats-container">
                <div class="stats-box">
                    <h3><?php echo $total_jobs; ?></h3>
                    <p>Total Jobs Posted</p>
                </div>
                <div class="stats-box">
                    <h3><?php echo $total_applications; ?></h3>
                    <p>Total Applications Received</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <h3>Quick Actions</h3>
            <div class="quick-actions">
                <div class="action-box">
                    <a href="job_posting.php"><i class="fas fa-plus-circle"></i> Post a New Job</a>
                </div>
                <div class="action-box">
                    <a href="manage_jobs.php"><i class="fas fa-edit"></i> Manage Jobs</a>
                </div>
                <div class="action-box">
                    <a href="view_job_applications.php"><i class="fas fa-eye"></i> View Applications</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Job Portal | All Rights Reserved</p>
    </footer>

</body>
</html>