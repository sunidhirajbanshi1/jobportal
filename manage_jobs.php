<?php
// Include database connection
include('../includes/db.php');

// Add a new job (for demonstration)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_job'])) {
    $job_title = trim($_POST['job_title']);
    $job_description = trim($_POST['job_description']);
    $category_id = intval($_POST['category_id']);
    if (!empty($job_title) && !empty($job_description) && $category_id > 0) {
        $stmt = $conn->prepare("INSERT INTO jobs (job_title, job_description, category_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $job_title, $job_description, $category_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Edit a job
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit_job'])) {
    $job_id = intval($_POST['job_id']);
    $job_title = trim($_POST['job_title']);
    $job_description = trim($_POST['job_description']);
    $category_id = intval($_POST['category_id']);
    if (!empty($job_title) && !empty($job_description) && $category_id > 0) {
        $stmt = $conn->prepare("UPDATE jobs SET job_title = ?, job_description = ?, category_id = ? WHERE job_id = ?");
        $stmt->bind_param("ssii", $job_title, $job_description, $category_id, $job_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Delete a job
if (isset($_GET['delete'])) {
    $job_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM jobs WHERE job_id = ?");
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_jobs.php");
}

// Fetch all jobs
$jobs = $conn->query("
    SELECT jobs.job_id, jobs.job_title, jobs.job_description, job_categories.category_name
    FROM jobs
    JOIN job_categories ON jobs.category_id = job_categories.category_id
    ORDER BY jobs.job_id DESC
");

// Fetch all categories for the dropdown
$categories = $conn->query("SELECT * FROM job_categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Jobs</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ccc;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h1 {
            font-size: 24px;
            color: #444;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        input[type="text"], textarea, select, button {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background-color: #007BFF;
            color: white;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editButtons = document.querySelectorAll(".edit-btn");
            const addForm = document.getElementById("add-job-form");
            const jobTitleInput = document.getElementById("job_title");
            const jobDescriptionInput = document.getElementById("job_description");
            const categorySelect = document.getElementById("category_id");

            // Handle Edit Button Click
            editButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    const jobId = this.dataset.id;
                    const jobTitle = this.dataset.title;
                    const jobDescription = this.dataset.description;
                    const categoryId = this.dataset.category;

                    // Prefill the form with job data
                    jobTitleInput.value = jobTitle;
                    jobDescriptionInput.value = jobDescription;
                    categorySelect.value = categoryId;

                    // Change the form action for editing
                    addForm.innerHTML = `
                        <input type="hidden" name="job_id" value="${jobId}">
                        <label for="job_title">Edit Job:</label>
                        <input type="text" id="job_title" name="job_title" value="${jobTitle}" required>
                        <label for="job_description">Job Description:</label>
                        <textarea id="job_description" name="job_description" required>${jobDescription}</textarea>
                        <label for="category_id">Category:</label>
                        <select id="category_id" name="category_id">
                            ${categorySelect.innerHTML}
                        </select>
                        <button type="submit" name="edit_job">Save Changes</button>
                        <button id="cancel-edit" type="button">Cancel</button>
                    `;

                    // Cancel Edit Action
                    document.getElementById("cancel-edit").addEventListener("click", function () {
                        location.reload(); // Reload the page to reset the form
                    });
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Manage Jobs</h1>
        
        <!-- Add or Edit Job Form -->
        <form id="add-job-form" method="POST">
            <label for="job_title">Job Title:</label>
            <input type="text" id="job_title" name="job_title" required>
            <label for="job_description">Job Description:</label>
            <textarea id="job_description" name="job_description" required></textarea>
            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id" required>
                <?php while ($category = $categories->fetch_assoc()): ?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo htmlspecialchars($category['category_name']); ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" name="add_job">Add Job</button>
        </form>

        <!-- Job List Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Job Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($job = $jobs->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $job['job_id']; ?></td>
                    <td><?php echo htmlspecialchars($job['job_title']); ?></td>
                    <td><?php echo htmlspecialchars($job['job_description']); ?></td>
                    <td><?php echo htmlspecialchars($job['category_name']); ?></td>
                    <td>
                        <button class="edit-btn" 
                            data-id="<?php echo $job['job_id']; ?>" 
                            data-title="<?php echo htmlspecialchars($job['job_title']); ?>" 
                            data-description="<?php echo htmlspecialchars($job['job_description']); ?>" 
                            data-category="<?php echo $job['category_id']; ?>">Edit</button>
                        <a href="manage_jobs.php?delete=<?php echo $job['job_id']; ?>" 
                            onclick="return confirm('Are you sure you want to delete this job?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>