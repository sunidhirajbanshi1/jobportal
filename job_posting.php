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
    header("Location: employerdashboard.php");
    exit();
}

$employer_id = $_SESSION['employer_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_job'])) {
    // Check required fields
    if (!isset($_POST['job_title'], $_POST['category_id'], $_POST['job_description'], $_POST['experience'], $_POST['skills'], $_POST['location'], $_POST['salary'], $_POST['deadline'], $_POST['company_name'])) {
        die("Error: Some required fields are missing.");
    }

    // Get form data
    $job_title = $_POST['job_title'];
    $category_id = $_POST['category_id'];
    $job_description = $_POST['job_description'];
    $experience = $_POST['experience'];
    $skills = $_POST['skills'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $deadline = $_POST['deadline'];
    $company_name = htmlspecialchars($_POST['company_name']); // Prevent XSS

    // Handle logo upload
    $logo_path = "";
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $logo = $_FILES['logo'];
        $target_dir = "uploads/logo/";
        $logo_path = $target_dir . basename($logo["name"]);
        $imageFileType = strtolower(pathinfo($logo_path, PATHINFO_EXTENSION));

        // Validate file type and size
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            die("Error: Only JPG, JPEG, PNG & GIF files are allowed.");
        }
        if ($logo["size"] > 500000) {
            die("Error: File size too large (max 500KB).");
        }

        // Move uploaded file
        if (!move_uploaded_file($logo["tmp_name"], $logo_path)) {
            die("Error: File upload failed.");
        }
    }

    // Insert into database
    $sql = "INSERT INTO jobposting (job_title, category_id, job_description, experience, skills, location, salary, deadline, employer_id, company_name, logo) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param(
        "sissssdisss",
        $job_title, $category_id, $job_description, $experience, $skills,
        $location, $salary, $deadline, $employer_id, $company_name, $logo_path
    );

    if ($stmt->execute()) {
        echo "Job posted successfully!";
    } else {
        echo "Error posting job: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Posting Form</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .logo { text-align: center; margin-bottom: 20px; }
        .logo img { max-width: 150px; height: auto; }
        form { max-width: 600px; margin: 0 auto; }
        label { display: block; margin-top: 10px; }
        input, textarea, select {
            width: 100%; padding: 8px; margin-top: 5px;
            margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;
        }
        button {
            background-color: #4CAF50; color: white;
            padding: 10px 20px; border: none;
            border-radius: 4px; cursor: pointer;
        }
        button:hover { background-color: #45a049; }
    </style>
</head>
<body>

<div class="logo">
    <img src="logo.png" alt="Company Logo">
</div>

<h1>Post a Job</h1>

<form action="job_posting.php" method="POST" enctype="multipart/form-data">
    <label for="job_title">Job Title:</label>
    <input type="text" id="job_title" name="job_title" required>

    <label for="category_id">Job Category:</label>
    <select id="category_id" name="category_id" required>
        <option value="">Select a category</option>
        <option value="1">Software Development</option>
        <option value="2">Data Science</option>
        <option value="3">Marketing</option>
        <option value="4">Design</option>
    </select>

    <label for="job_description">Job Description:</label>
    <textarea id="job_description" name="job_description" rows="5" required></textarea>

    <label for="experience">Experience (in years):</label>
    <input type="number" id="experience" name="experience" min="0" required>

    <label for="skills">Skills (comma-separated):</label>
    <input type="text" id="skills" name="skills" required>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" required>

    <label for="salary">Salary:</label>
    <input type="number" id="salary" name="salary" min="0" required>

    <label for="deadline">Application Deadline:</label>
    <input type="date" id="deadline" name="deadline" required>

    <label for="company_name">Company Name:</label>
    <input type="text" id="company_name" name="company_name" required>

    <label for="logo">Upload Logo:</label>
    <input type="file" id="logo" name="logo" accept="image/*" required>

    <button type="submit" name="add_job">Post Job</button>
</form>

</body>
</html>
