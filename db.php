
<?php
// db.php - Database connection script

$servername = "localhost"; // your DB server address, e.g., localhost or an IP address
$username = "root"; // your DB username
$password = ""; // your DB password
$dbname = "jobportal"; // your DB name

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
