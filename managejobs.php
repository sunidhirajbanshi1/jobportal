<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobportal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the employer is logged in
if (!isset($_SESSION['employer_id'])) {
    header("Location: employerlogin.php");
    exit();
}

$employer_id = $_SESSION['employer_id'];

// Fetch jobs posted by the employer
$sql = "SELECT * FROM jobs1 WHERE employer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employer_id);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Jobs</title>
    <style>
        /* CSS styles */
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        /* ... rest of your existing CSS styles ... */

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>

    <?php include("employerdashboard.php"); ?>

    <main class="container">
        <h1>Manage Jobs</h1>

        <table>
            <tr>
                <th>Job Title</th>
                <th>Job Description</th>
                <th>Job Experience</th>
                <th>Job Skills</th>
                <th>Location</th>
                <th>Salary</th>
                <th>Company Name</th>
                <th>Deadline</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['job_title'] . "</td>";
                    echo "<td>" . $row['location'] . "</td>";
                    echo "<td>" . $row['deadline'] . "</td>";
                    echo "<td>
                            <a href='edit_job.php?id=" . $row['id'] . "'>Edit</a> | 
                            <a href='delete_job.php?id=" . $row['id'] . "'>Delete</a>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No jobs found.</td></tr>";
            }
            ?>
        </table>

    </main>

</body>
</html>