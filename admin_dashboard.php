<?php
session_start();
include('db.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location:adminlogin.php");
    exit();
}

// Fetch the statistics for the dashboard
// Total number of job seekers
$sql = "SELECT COUNT(*) AS jobseeker FROM jobseeker2 WHERE role = 'job_seeker'";
$result = mysqli_query($conn, $sql);
$job_seekers = mysqli_fetch_assoc($result)['job_seekers'];

// Total number of employers
$sql = "SELECT COUNT(*) AS employer FROM employer WHERE role = 'employer'";
$result = mysqli_query($conn, $sql);
$employers = mysqli_fetch_assoc($result)['employers'];

// Total number of job postings
/*$sql = "SELECT COUNT(*) AS jobs FROM jobs1";
$result = mysqli_query($conn, $sql);
$jobs = mysqli_fetch_assoc($result)['jobs'];*/

// Total number of applications
$sql = "SELECT COUNT(*) AS applications FROM job_applications";
$result = mysqli_query($conn, $sql);
$applications = mysqli_fetch_assoc($result)['applications'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* Admin Dashboard Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
        }
        .stat-card {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 23%;
        }
        .stat-card h3 {
            margin: 10px 0;
        }
        .stat-card p {
            font-size: 18px;
        }
        .table-container {
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .btn {
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<header class="jp-header">
    <div class="jp-logo">
        <img src="../assets/images/svg_img1.png" alt="Job Portal Logo">
        <h1>Admin Dashboard</h1>
    </div>
    <nav class="jp-nav">
        <ul>
            <li><a href="../">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h2>Dashboard Overview</h2>

    <!-- Stats Section -->
    <div class="stats">
        <div class="stat-card">
            <h3>Job Seekers</h3>
            <p><?php echo $job_seekers; ?></p>
        </div>
        <div class="stat-card">
            <h3>Employers</h3>
            <p><?php echo $employers; ?></p>
        </div>
        <div class="stat-card">
            <h3>Job Postings</h3>
            <p><?php echo $jobs; ?></p>
        </div>
        <div class="stat-card">
            <h3>Applications</h3>
            <p><?php echo $applications; ?></p>
        </div>
    </div>

    <!-- Job Postings Table -->
    <div class="table-container">
        <h3>Job Postings</h3>
        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Employer</th>
                    <th>Location</th>
                    <th>Posted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch job postings
                $sql = "SELECT j.id, j.job_title, u.name AS employer_name, j.location, j.posted_at 
                        FROM jobs j 
                        JOIN users u ON j.employer_id = u.id
                        ORDER BY j.posted_at DESC";
                $result = mysqli_query($conn, $sql);

                while ($job = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($job['job_title']); ?></td>
                        <td><?php echo htmlspecialchars($job['employer_name']); ?></td>
                        <td><?php echo htmlspecialchars($job['location']); ?></td>
                        <td><?php echo htmlspecialchars($job['posted_at']); ?></td>
                        <td>
                            <a href="view_job.php?id=<?php echo $job['id']; ?>" class="btn">View</a>
                            <a href="delete_job.php?id=<?php echo $job['id']; ?>" class="btn" style="background-color: #dc3545;">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>