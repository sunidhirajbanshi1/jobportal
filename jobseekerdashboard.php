<?php
session_start();
$conn = new mysqli("localhost", "root", "", "jobportal");

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header("Location: jobseekerdashboard.php");
    exit();
}

$jobseeker_id = $_SESSION['id'];

// Fetch jobseeker details
$sql = "SELECT * FROM jobseeker2 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $jobseeker_id);
$stmt->execute();
$result = $stmt->get_result();
$jobseeker = $result->fetch_assoc();
$stmt->close();

// Fetch available jobs
/*$sql_jobs = "SELECT * FROM job_posting  ORDER BY posted_date DESC";
$jobs_result = $conn->query($sql_jobs);
$conn->close();*/
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobseeker Dashboard</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* General Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

body {
    display: flex;
    background: #f4f4f9;
}

/* Sidebar Navigation */
.sidebar {
    width: 250px;
    height: 100vh;
    background: #2c3e50;
    padding: 20px;
    position: fixed;
    color: white;
}

.sidebar h2 {
    text-align: center;
    margin-bottom: 30px;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    padding: 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.sidebar ul li a {
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.sidebar ul li a:hover {
    background: #34495e;
    padding-left: 10px;
    transition: 0.3s;
}

.sidebar ul li i {
    margin-right: 10px;
}

/* Main Content */
.main-content {
    margin-left: 250px;
    width: calc(100% - 250px);
    padding: 20px;
}

.header {
    background: #007bff;
    color: white;
    padding: 15px;
    text-align: center;
    font-size: 20px;
}

/* Profile Section */
.profile {
    background: white;
    padding: 20px;
    margin: 20px 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.profile h2 {
    margin-bottom: 10px;
}

/* Job Listings */
.jobs {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.job-card {
    background: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.job-card h3 {
    color: #333;
    margin-bottom: 10px;
}

.job-card p {
    color: #555;
    margin-bottom: 5px;
}

.job-card .apply-btn {
    display: inline-block;
    background: #007bff;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
}

.job-card .apply-btn:hover {
    background: #0056b3;
}

/* Responsive Design */
@media (max-width: 768px) {
    .sidebar {
        width: 200px;
    }
    .main-content {
        margin-left: 200px;
        width: calc(100% - 200px);
    }
}

@media (max-width: 576px) {
    .sidebar {
        display: none;
    }
    .main-content {
        margin-left: 0;
        width: 100%;
    }
}

    </style>
</head>
<div class="sidebar">
    <h2>Job Portal</h2>
    <ul>
        <li><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
        <li><a href="jobs.php"><i class="fas fa-briefcase"></i> Jobs</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="header">Welcome to Your Profile</div>

    <div class="profile">
        <h2>Profile Information</h2>
        <p><strong>Name:</strong> John Doe</p>
        <p><strong>Email:</strong> john@example.com</p>
        <p><strong>Phone:</strong> 123-456-7890</p>
    </div>

   
