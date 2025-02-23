/*<?php
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
//Add a job 
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_job'])) {
        $job_title = trim($_POST['job_title']);
        $job_description = trim($_POST['description']);
        $category_id = intval($_POST['category_id']);
        $location = intval($_POST["location"]);
        $experience = trim($_POST["experience"]);
        $skills = trim($_POST["skills"]);
        $salary = trim($_POST["salary"]);
        $deadline = trim($_POST["deadline"]);
        if (!empty($job_title) && !empty($job_description) && $category_id && !empty($location)&& !empty($experience)&& !empty($skills)&& !empty($salary)&& !empty($deadline) > 0) {
            $stmt = $conn->prepare("INSERT INTO jobs (job_title, description, category_id,location,experience,skills,salary,deadline) VALUES (?, ?, ?,?,?,?,?,?)");
            $stmt->bind_param("ssssssss", $job_title, $job_description, $category_id,$location,$experience,$skills,$salary,$deadline);
            $stmt->execute();
            $stmt->close();
        }
    

    if ($stmt->execute()) {
        echo "<script>alert('Job posted successfully!');</script>";
        header("Location: jobposting.php"); 
        exit();
    } else {
        echo "<script>alert('Error posting job: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post a Job</title>
    <style>
        /* CSS styles for the form */
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        nav {
            background-color: #fff;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline-block;
            margin-right: 20px;
        }

        nav a {
            text-decoration: none;
            color: #333;
        }

        main {
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding:0px;
            margin-bottom: 100px;
        }

       /* form {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }*/
        form {
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    /*display: flex;
    /*flex-direction: column;  /* Ensures all form elements are stacked vertically */
}

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea,
        select {
            width: 95%;
            padding: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        textarea {
            height: 90px;
        }

        button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;  /* Adjust padding to make the button fit within the box */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;  /* Make the button take up the full width of the container */
    box-sizing: border-box;  /* Ensures padding is included in the width calculation */
    font-size: 16px;  /* Optional, adjust button text size */
    transition: background-color 0.3s ease;  /* Smooth hover effect */
}

/* Hover effect for button */
button:hover {
    background-color: #45a049;  /* Darker shade when hovering */
}

    </style>
    <script>
    // Wait until the DOM is fully loaded
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const jobTitleInput = document.getElementById("job_title");
    const jobDescriptionInput = document.getElementById("job_description");
    const locationInput = document.getElementById("location");
    const experienceInput = document.getElementById("experience");
    const skillsInput = document.getElementById("skills");
    const salaryInput = document.getElementById("salary");
    const deadlineInput = document.getElementById("deadline");
    const categorySelect = document.getElementById("category_id");

    // Function to validate form fields
    function validateForm() {
        let isValid = true;
        const inputs = [jobTitleInput, jobDescriptionInput, locationInput, experienceInput, skillsInput, salaryInput, deadlineInput, categorySelect];

        inputs.forEach((input) => {
            if (!input.value.trim()) {
                input.style.border = "1px solid red";
                isValid = false;
            } else {
                input.style.border = "1px solid #ccc";
            }
        });

        if (!isValid) {
            alert("Please fill in all the fields correctly.");
        }

        return isValid;
    }

    // Form submission event listener
    form.addEventListener("submit", function (event) {
        if (!validateForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    // Real-time field validation (optional, for better UX)
    [jobTitleInput, jobDescriptionInput, locationInput, experienceInput, skillsInput, salaryInput, deadlineInput, categorySelect].forEach((input) => {
        input.addEventListener("input", () => {
            if (input.value.trim()) {
                input.style.border = "1px solid #ccc";
            }
        });
    });

    // Enhance date input to ensure the deadline is in the future
    deadlineInput.addEventListener("change", function () {
        const selectedDate = new Date(deadlineInput.value);
        const today = new Date();
        if (selectedDate < today) {
            alert("The deadline must be a future date.");
            deadlineInput.value = ""; // Clear invalid input
        }
    });
});
</script>
</head>
<body>



    <main class="container">
        <h2>Post a Job</h2>

        <form method="POST" action="">
            <label for="job_title">Job Title:</label>
            <input type="text" id="job_title" name="job_title" required>
           
         

            <label for="job_description">Job Description:</label>
            <textarea id="job_description" name="job_description" required></textarea>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="experience">Experience:</label>
            <input type="text" id="experience" name="experience" required>

            <label for="skills">Skills:</label>
            <textarea id="skills" name="skills" required></textarea>

            <label for="salary">Salary:</label>
            <input type="text" id="salary" name="salary" required>

            <label for="deadline">Deadline:</label>
            <input type="date" id="deadline" name="deadline" required>
            
           
            <br><br>
            <button type="submit" name="add_job">Add Job</button>
           
           
        </form>
      
    </main>

</body>
</html>




<label for="category_id">Category:</label>
            <select id="category_id" name="category_id" required>
                <option value="">Select a category</option>
                <?php
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
                    }
                }
                ?>
            </select>

            //job posting
            <?php
require_once ('db.php');

$companyId = $_POST["compid"];
$recruiterId = $_POST["recid"];
$designation = $_POST["designation"];
$companyName = $_POST["compname"];
$location = $_POST["location"];
$salary = $_POST["salary"];
$description = $_POST["description"];

$sql = "INSERT INTO `job-post`(`recid`, `compid`, `designation`, `company`, `location`, `salary`, `description`) VALUES ('$recruiterId','$companyId','$designation','$companyName','$location','$salary','$description')";
if ($conn->query($sql) === TRUE) {
    $scipt = "<script>alert('Job Posted Successfully');
    window.location.href='../recruiter-jobpost.html';</script>";
    echo $scipt;
    
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
<?php
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "jobportal");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password =md5( $_POST["password"]);

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT id, password FROM jobseeker2 WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['jobseeker_id'] = $row['id']; 
            header("Location: jobseekerdashboard.php"); // Redirect to dashboard
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
// Check if the form is submitted
/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Validate input
    if (empty($email) || empty($password)) {
        echo "<script>alert('Email and password are required.');</script>";
    } else {
        // Query to fetch the user by email
        $sql = "SELECT id, password FROM jobseeker2 WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables for the logged-in user
                $_SESSION['jobseeker_id'] = $user['id'];
                $_SESSION['email'] = $email;

                // Redirect to the dashboard
                header("Location: jobseekerdashboard.php");
                exit();
            } else {
                echo "<script>alert('Invalid email or password.');</script>";
            }
        } else {
            echo "<script>alert('No account found with that email.');</script>";
        }

        $stmt->close();
    }
}*/}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobseeker Login</title>
    <style>
        body {
            background: url(Images/Image2.JPG) no-repeat center center/cover;
            font-family: Arial, sans-serif;
          display:flex;
          justify-content: center;
          align-items: center;
          margin:0;
          background-color:#f4f4f4;
        
          
        }
        
        .main-content {
            display: flex;
            height: 100vh;
        }
        .content-area {
            flex: 1;
            padding: 50px;
        }
        .login-container {
            display:flex;
            flex-direction:column;
            background-color: rgba(0, 0, 0, 0.5);
            width: 300px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 40px;
            margin-right: 60px;
            align-self: center;
            margin-top: 5px;
            padding-top: 10px;
            text-align:center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: white;
        }
        .login-container label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: white;
            text-align:left;
        }
        .login-container input {
            width: 95%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .login-container input[type="checkbox"] {
            width: auto;
            margin-right: 5px;
        }
        .login-container a {
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }
        .login-container .btn {
            width: 100%;
            background: #0056b3;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .login-container .btn:hover {
            background: #003d80;
        }
        .login-container .register {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
        .register a{
   color:rgb(220, 93, 93);
        }
        .login-container .register a {
            color: #f1c40f;
            font-weight: bold;
        }
        /* Navbar Styles */
.navbar {
    display: flex;
    justify-content: space-between; /* Space between logo and navigation links */
    align-items: center;
    padding: 10px 2px;
    background-color: #ffffff; /* White background */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
    position: fixed; /* Sticks to the top of the page */
    top: 0;
    width: 100%; /* Full width */
    z-index: 1000; 
    
   /* Add a subtle box shadow */
/* Ensures it stays above other elements */
}

.navbar .logo {
    display: flex;
    align-items: center;
}

.navbar .logo img {
    height: 40px;
    margin-right: 10px;
}

.navbar .logo span {
    font-size: 20px;
    font-weight: bold;
    color: #0056b3; /* Blue color for "JOBS" */
}

.navbar a {
    color: #333; /* Text color */
    text-decoration:none;
    margin-left: 20px;
    font-size: 16px;
    transition: color 0.3s ease;
    padding:15px;
}

.navbar a:hover {
    color: #0056b3;
    text-decoration: underline; /* Blue highlight on hover */
}

/* Active link style (optional) */
.navbar a.active {
    font-weight: bold;
    color: #0056b3;
}

    
    </style>
</head>
<body>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="logo.png" alt="Logo"> <!-- Replace 'logo.png' with your actual logo path -->
            <span>JOBS</span>
        </div>
        <div>
        <a href="index1.php">Home</a> 
             <a href="Aboutus.html">About Us</a>
             <a href="contact.html">Contact Us</a>
            <a href="jobseeker1.php">Jobseekers</a>
            <a href="employerlogin.php">Employers</a>
           
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Content area -->
        <div class="content-area">
            <!-- Add any left-side content here -->
        </div>

        <!-- Login Form -->
        <div class="login-container">
            <h2>Jobseeker Login</h2>
            <form action="login.php" method="post">
                <label for="email">E-mail address</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
                
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember" style="display: inline;">Remember Me</label>
                    </div>
                    <a href="#">Forgot Password?</a>
                </div>
                
                <button type="submit" class="btn">Login</button>
            </form>
            <div class="register">
              <span style="color:white" > Don't have an account?</span> <a href="jobseeker2.php">Register Now</a>
            </div>
        </div>
    </div>
</body>
</html>





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

$jobseeker_id = $_SESSION['jobseeker_id'];

// Fetch employer details
$sql = "SELECT * FROM jobseeker2 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $jobseeker_id);
$stmt->execute();
$result = $stmt->get_result();
$jobseeker = $result->fetch_assoc();
$stmt->close();
// Ensure user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: jobseeker1.php");
    exit();
}

$user_id = $_SESSION['id'];

// Fetch user details
$sql = "SELECT * FROM jobseeker2 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
//$stmt->close();

// Fetch available jobs
//$sql_jobs = "SELECT * FROM jobs ORDER BY posted_date DESC";
//$jobs_result = $conn->query($sql_jobs);
$conn->close();
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
