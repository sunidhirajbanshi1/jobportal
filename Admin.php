<?php
session_start();
//Database connection
$servername = "localhost";
$username = "root"; // Update as needed
$password = ""; // Update as needed
$dbname = "jobportal"; /// Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!isset($_SESSION['username'])) {
    header("Location: adminlogin.php");
    exit();
}
//Fetch data counts
$jobCategoriesQuery = "SELECT COUNT(*) as count FROM job_categories";
$employersQuery = "SELECT COUNT(*) as count FROM employer";
$jobseekersQuery = "SELECT COUNT(*) as count FROM jobseeker2";
$jobsQuery = "SELECT COUNT(*) as count FROM jobs1";
$applicationsQuery = "SELECT COUNT(*) AS applications FROM applications";


$jobCategories = $conn->query($jobCategoriesQuery)->fetch_assoc()['count'];
$employers = $conn->query($employersQuery)->fetch_assoc()['count'];
$jobseekers = $conn->query($jobseekersQuery)->fetch_assoc()['count'];
$jobs = $conn->query($jobsQuery)->fetch_assoc()['count'];//
$applications = $conn->query($applicationsQuery)->fetch_assoc()['count'];



// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

h1 {
    text-align: center;
    padding: 20px;
    color: #333;
}

.dashboard {
    display: flex;
    justify-content: space-around;
    padding: 10px;
    background-color: #f4f4f4;
}

.card {
    width: 20%;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
    background: linear-gradient(to bottom right, #6a11cb,rgb(71, 133, 241));
    color: #fff;
}

.card h2 {
    font-size: 2em;
    margin: 0 0 10px 0;
}

.card p {
    margin: 5;
    font-size: 1.2em;
}

.sidebar {
    width: 250px;
    height: 100vh;
    background: #343a40;
    color: #fff;
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 0;
    left: 0;
}

.sidebar h2 {
    text-align: center;
    padding: 15px 0;
    border-bottom: 1px solid #495057;
    margin: 0;
}

.menu {
    flex-grow: 1;
    padding: 10px 0;
}

.menu table {
    width: 100%;
    text-align: left;
    border-collapse: collapse;
}

.menu table tr {
    border-bottom: 1px solid #495057;
}

.menu table tr:hover {
    background: #495057;
}

.menu table tr td {
    padding: 10px;
    color: #fff;
}

.menu table tr td a {
    text-decoration: none;
    color: #fff;
    display: block;
}

.menu table tr td a:hover {
    color: #1abc9c;
}

.logout {
    padding: 15px;
    text-align: center;
    background: #e74c3c;
    cursor: pointer;
}

.logout a {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
}

.logout:hover {
    background: #c0392b;
}

.dashboard {
    margin-left: 270px; /* Adjust margin for sidebar */
}

    </style>
    </style>
</head>
<body>
 
      
    </div>
    <h1 style="text-align:center; padding: 20px; color: #333;">Admin Dashboard</h1>
    <div class="dashboard">
        <div class="card">
            <h2><?php echo $jobCategories; ?></h2>
            <p>Total Job Categories</p>
        </div>
        <div class="card">
            <h2><?php echo $employers; ?></h2>
            <p>Total Registered Employers</p>
        </div>
        <div class="card">
            <h2><?php echo $jobseekers; ?></h2>
            <p>Total Registered Candidates</p>
        </div>
        <div class="card">
            <h2><?php echo $jobs; ?></h2>
            <p>Total Listed Jobs</p>
        </div>

    </div>
 <div class="sidebar">
        <h2>Admin Panel</h2>
        <div class="menu">
            <table>
                <tr>
                    <td><a href="admin.php">Dashboard</a></td>
                </tr>
                <tr>
                    <td><a href="job_categories.php">Job Categories</a></td>
                </tr>
                <tr>
                    <td><a href="employer.php">Registered Employers</a></td>
                </tr>
                <tr>
                    <td><a href="view_job_applications.php">Registered Candidates</a></td>
                </tr>
                <tr>
                    <td><a href="joblisting.php">Listed Jobs</a></td>
                </tr>
                <tr>
                    <td><a href="reports.php">Reports</a></td>
                </tr>
                <tr>
                    <td><a href="settings.php">Settings</a></td>
                </tr>
            </table>
        </div>
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>
   
</body>


</html>

<?php
$conn->close();
?>
