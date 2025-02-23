
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

// Check if the employer is logged in
if (!isset($_SESSION['employer_id'])) {
    header("Location: employerdashboard.php");
    exit();
}

$employer_id = $_SESSION['employer_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and sanitize input
    $jobTitle = htmlspecialchars($_POST['jobTitle']);
    $categoryId = intval($_POST['jobCategory']); // Ensure it's an integer
    $jobDescription = htmlspecialchars($_POST['jobDescription']);
    $location = htmlspecialchars($_POST['location']);
    $salary = htmlspecialchars($_POST['salary']);
    $companyName = htmlspecialchars($_POST['companyName']);
    $skills = htmlspecialchars($_POST['skills']);
    $experience = htmlspecialchars($_POST['experience']);
    $deadline = $_POST['deadline'];
    $logoPath = htmlspecialchars($_POST['logo_path']); // Store logo path

    // Validate data (server-side validation)
    $errors = [];

    if (empty($jobTitle)) {
        $errors[] = 'Job Title is required.';
    }
    if (empty($categoryId)) {
        $errors[] = 'Job Category is required.';
    }
    if (empty($jobDescription)) {
        $errors[] = 'Job Description is required.';
    }
    if (empty($location)) {
        $errors[] = 'Location is required.';
    }
    if (empty($salary)) {
        $errors[] = 'Salary is required.';
    }
    if (empty($companyName)) {
        $errors[] = 'Company Name is required.';
    }
    if (empty($skills)) {
        $errors[] = 'Skills are required.';
    }
    if (empty($experience)) {
        $errors[] = 'Experience is required.';
    }
    if (empty($deadline)) {
        $errors[] = 'Application Deadline is required.';
    }

    // If no errors, process the data (save to database)
    if (empty($errors)) {
        // Prepare an INSERT statement
        $stmt = $conn->prepare("
            INSERT INTO job (category_id, job_title, job_description, location, salary, company_name, skills, experience, deadline, logo_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        // Bind parameters to the statement
        $stmt->bind_param("isssssssss", $categoryId, $jobTitle, $jobDescription, $location, $salary, $companyName, $skills, $experience, $deadline, $logoPath);

        // Execute the statement and check for errors
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Job posted successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }

        // Close the statement and connection
        $stmt->close();
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job</title>
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Container */
.container {
    background-color: #ffffff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 420px;
}

/* Form Heading */
h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Form Group */
.form-group {
    margin-bottom: 15px;
}

label {
    font-weight: bold;
    color: #333;
    display: block;
    margin-bottom: 5px;
}

/* Input & Select Fields */
input[type="text"], input[type="date"], textarea, select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
    transition: border-color 0.3s ease-in-out;
}

textarea {
    resize: vertical;
    height: 100px;
}

/* Input Focus */
input:focus, textarea:focus, select:focus {
    border-color: #28a745;
    outline: none;
}

/* Error Messages */
.error {
    color: red;
    font-size: 14px;
    display: block;
    margin-top: 5px;
}

/* Submit Button */
button {
    width: 100%;
    padding: 12px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
}

button:hover {
    background-color: #218838;
}

/* Responsive Design */
@media (max-width: 500px) {
    .container {
        width: 90%;
    }
}

    </style>
    <script>
        function validateForm() {
            let isValid = true;

            function showError(id, message) {
                document.getElementById(id).textContent = message;
                isValid = false;
            }

            function clearErrors() {
                document.querySelectorAll('.error').forEach(error => error.textContent = "");
            }

            clearErrors();

            const jobTitle = document.getElementById("jobTitle").value.trim();
            const jobCategory = document.getElementById("jobCategory").value;
            const jobDescription = document.getElementById("jobDescription").value.trim();
            const location = document.getElementById("location").value.trim();
            const salary = document.getElementById("salary").value.trim();
            const companyName = document.getElementById("companyName").value.trim();
            const skills = document.getElementById("skills").value.trim();
            const experience = document.getElementById("experience").value;
            const deadline = document.getElementById("deadline").value;
            const logoPath = document.getElementById("logo_path").value.trim();

            if (jobTitle === "") showError("jobTitleError", "Job title is required.");
            if (jobCategory === "") showError("jobCategoryError", "Job category is required.");
            if (jobDescription === "") showError("jobDescriptionError", "Job description is required.");
            if (location === "") showError("locationError", "Location is required.");
            if (salary === "") showError("salaryError", "Salary is required.");
            if (companyName === "") showError("companyNameError", "Company name is required.");
            if (skills === "") showError("skillsError", "Skills are required.");
            if (experience === "") showError("experienceError", "Experience level is required.");
            if (deadline === "") showError("deadlineError", "Deadline is required.");
            if (logoPath === "") showError("logoPathError", "Logo path is required.");

            return isValid;
        }
    </script>
</head>
<body>
    <h1>Post a Job</h1>
    <form action="#" method="POST" onsubmit="return validateForm()">
        <label>Job Title: <input type="text" id="jobTitle" name="jobTitle"></label>
        <span class="error" id="jobTitleError"></span><br>

        <label>Job Category:
            <select id="jobCategory" name="jobCategory">
                <option value="">Select a category</option>
                <?php
          
                $result = $conn->query("SELECT category_id, category_name FROM job_categories");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                }
                ?>
            </select>
        </label>
        <span class="error" id="jobCategoryError"></span><br>

        <label>Job Description: <textarea id="jobDescription" name="jobDescription"></textarea></label>
        <span class="error" id="jobDescriptionError"></span><br>

        <label>Location: <input type="text" id="location" name="location"></label>
        <span class="error" id="locationError"></span><br>

        <label>Salary: <input type="text" id="salary" name="salary"></label>
        <span class="error" id="salaryError"></span><br>

        <label>Company Name: <input type="text" id="companyName" name="companyName"></label>
        <span class="error" id="companyNameError"></span><br>

        <label>Skills: <input type="text" id="skills" name="skills"></label>
        <span class="error" id="skillsError"></span><br>

        <label>Experience:
            <input type="text" id="experience" name="experience"></label>
                
        </label>
        <span class="error" id="experienceError"></span><br>

        <label>Deadline: <input type="date" id="deadline" name="deadline"></label>
        <span class="error" id="deadlineError"></span><br>

        <label>Logo Path: <input type="text" id="logo_path" name="logo_path"></label>
        <span class="error" id="logoPathError"></span><br>

        <button type="submit">Post Job</button>
    </form>
</body>
</html>

