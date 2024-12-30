<?php

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

// Get job ID from URL
$job_id = isset($_GET['id']) && !empty($_GET['id']) ? intval($_GET['id']) : 0; 

// Fetch job details from the database
$sql = "SELECT * FROM jobs1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Job not found.";
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $row["job_title"]; ?></title>
    <style>
       <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        h3 {
            color: #555;
        }

        p {
            margin-bottom: 15px;
        }

        .job-details {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .back-to-board {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 3px;
            cursor: pointer;
        }
    </style> /* CSS styles */
   
</head>
<body>

    <h2><?php echo $row["job_title"]; ?></h2>
    <h3><?php echo $row["company_name"]; ?></h3>

    <p><strong>Location:</strong> <?php echo $row["location"]; ?></p>
    <p><strong>Deadline:</strong> <?php echo $row["deadline"]; ?></p>
    <p><strong>Description:</strong> <?php echo $row["description"]; ?></p>
    <p><strong>Requirements:</strong> <?php echo $row["requirements"]; ?></p>
    <p><strong>Salary:</strong> <?php echo $row["salary"]; ?></p>
    <p><strong>Responsibilities:</strong> <?php echo $row["responsibilities"]; ?></p>

    <a href="index.php">Back to Job Board</a> 
    <button>Save Job</button> 

</body>
</html>