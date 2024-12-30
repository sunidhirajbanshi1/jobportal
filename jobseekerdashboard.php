<?php
session_start();
$conn = new mysqli("localhost", "root", "", "jobportal");

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!isset($_SESSION['jobseeker_id'])) {
    header("Location: jobseeker1.php");
    exit();
}

$employer_id = $_SESSION['jobseeker_id'];

// Fetch employer details
$sql = "SELECT * FROM jobseeker2 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $jobseeker_id);
$stmt->execute();
$result = $stmt->get_result();
$jobseeker = $result->fetch_assoc();
$stmt->close();
// Ensure user is logged in
/*if (!isset($_SESSION['user_id'])) {
    header("Location: jobseeker1.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT * FROM jobseeker2 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();*/

// Fetch available jobs
$sql_jobs = "SELECT * FROM jobseeker2 ORDER BY posted_date DESC";
$jobs_result = $conn->query($sql_jobs);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobseeker Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        nav {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .container {
            margin: 80px auto;
            padding: 20px;
            max-width: 1200px;
            background: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .profile {
            margin-bottom: 30px;
        }

        .profile h2 {
            margin-bottom: 10px;
        }

        .jobs {
            margin-top: 30px;
        }

        .job {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .job h3 {
            margin: 0 0 10px 0;
        }

        .job p {
            margin: 5px 0;
        }

        .apply {
            text-align: right;
        }

        .apply button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .apply button:hover {
            background-color: blue;
        }

    </style>
</head>
<body>
    <nav>
        <h1>Welcome to Your Dashboard</h1>
    </nav>

    <div class="container">
        <div class="profile">
            <h2>Profile Information</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['fName']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        </div>

        <div class="jobs">
            <h2>Available Jobs</h2>
            <?php while ($job = $jobs_result->fetch_assoc()) { ?>
                <div class="job">
                    <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                    <p><strong>Company:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                    <p><strong>Posted on:</strong> <?php echo htmlspecialchars($job['posted_date']); ?></p>
                    <p><?php echo htmlspecialchars($job['description']); ?></p>
                    <div class="apply">
                        <button onclick="applyJob(<?php echo $job['id']; ?>)">Apply Now</button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
        function applyJob(jobId) {
            alert("Applying for Job ID: " + jobId);
            // Implement AJAX or form submission for job application here
        }
    </script>
</body>
</html>
