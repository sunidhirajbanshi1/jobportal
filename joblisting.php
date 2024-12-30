<?php

// Database connection

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobportal";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);}



// Fetch jobs from the database
$sql = "SELECT * FROM jobs1";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Job Board</title>
    <style>
.job-list {
    display:grid;
    grid-template-columns: repeat(4, 1fr); /* Adjust for desired number of columns */
    gap: 15px;
    padding:5px
    width:1px;
}

.job {
    border: 1px solid #ccc;
    padding: 20px;
    text-align: left;
}

.job img {
    max-width: 100px;
}
/* ... (rest of the CSS code remains the same) */

.view-details {
    display: inline-block;
    padding: 5px 10px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
}
h1{
    color:rgb(63, 133, 209);
}

        </style>
</head>
<body>
    <h1>Top Jobs</h1>

    <div class="job-list">

<?php

// Display jobs with additional information
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="job">';
        echo '<img src="' . $row["logo_path"] . '">';
        echo'<ul>';
        echo '<h3>' . $row["company_name"] . '</h3>';
        echo '<p>' . $row["job_title"] . '</p>';
        echo '<p><strong>Location:</strong> ' . $row["location"] . '</p>';
        echo '<p><strong>Deadline:</strong> ' . $row["deadline"] . '</p>';
        echo '<a href="jobdetails.php">View Details</a>';
        echo '</div>';
    }
} else {
    echo "No jobs found.";
}
?>
   
    </div>
</body>
</html>