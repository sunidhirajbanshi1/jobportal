<?php
// Include database connection
include('db.php');

// Fetch all job applications
$sql = "
    SELECT 
        applications.id AS application_id,
        job_seekers.name AS job_seeker_name,
        job_seekers.email AS job_seeker_email,
        jobs.title AS job_title,
        applications.cover_letter,
        applications.status
    FROM 
        applications
    INNER JOIN 
        jobseeker2 ON applications.job_seeker_id = job_seekers.id
    INNER JOIN 
        jobs1 ON applications.job_id = jobs.id
    ORDER BY 
        applications.id DESC
";
$applications = $conn->query($sql);

// Update application status
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_status'])) {
    $application_id = intval($_POST['application_id']);
    $new_status = trim($_POST['status']);

    if (in_array($new_status, ['pending', 'accepted', 'rejected'])) {
        $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $application_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: view_job_application.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job Applications</title>
    <style>
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
            text-align: center;
            font-size: 24px;
            color: #444;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background-color: #007BFF;
            color: #fff;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .status-btn {
            padding: 5px 10px;
            font-size: 14px;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .status-pending {
            background-color: #ffc107;
        }

        .status-accepted {
            background-color: #28a745;
        }

        .status-rejected {
            background-color: #dc3545;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%;
            background: #fff;
            border: 1px solid #ccc;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            z-index: 1000;
            padding: 20px;
        }

        .modal-header {
            font-size: 18px;
            margin-bottom: 10px;
            text-align: center;
        }

        .modal-close {
            float: right;
            cursor: pointer;
            color: #888;
        }

        .modal-close:hover {
            color: #444;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Job Applications</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Job Seeker</th>
                    <th>Email</th>
                    <th>Job Title</th>
                    <th>Cover Letter</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($application = $applications->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $application['application_id']; ?></td>
                    <td><?php echo htmlspecialchars($application['job_seeker_name']); ?></td>
                    <td><?php echo htmlspecialchars($application['job_seeker_email']); ?></td>
                    <td><?php echo htmlspecialchars($application['job_title']); ?></td>
                    <td><?php echo htmlspecialchars(substr($application['cover_letter'], 0, 50)) . '...'; ?></td>
                    <td>
                        <span class="status-btn status-<?php echo $application['status']; ?>">
                            <?php echo ucfirst($application['status']); ?>
                        </span>
                    </td>
                    <td>
                        <button class="edit-btn" data-id="<?php echo $application['application_id']; ?>" data-status="<?php echo $application['status']; ?>">Update Status</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="modal" id="status-modal">
        <div class="modal-header">
            Update Application Status
            <span class="modal-close" id="close-modal">&times;</span>
        </div>
        <form method="POST">
            <input type="hidden" name="application_id" id="application-id">
            <label for="status">Select Status:</label>
            <select name="status" id="status" required>
                <option value="pending">Pending</option>
                <option value="accepted">Accepted</option>
                <option value="rejected">Rejected</option>
            </select>
            <button type="submit" name="update_status">Save Changes</button>
        </form>
    </div>
    <div class="overlay" id="overlay"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editButtons = document.querySelectorAll(".edit-btn");
            const modal = document.getElementById("status-modal");
            const overlay = document.getElementById("overlay");
            const closeModal = document.getElementById("close-modal");
            const applicationIdField = document.getElementById("application-id");
            const statusField = document.getElementById("status");

            editButtons.forEach(button => {
                button.addEventListener("click", function () {
                    applicationIdField.value = this.dataset.id;
                    statusField.value = this.dataset.status;
                    modal.style.display = "block";
                    overlay.style.display = "block";
                });
            });

            closeModal.addEventListener("click", function () {
                modal.style.display = "none";
                overlay.style.display = "none";
            });

            overlay.addEventListener("click", function () {
                modal.style.display = "none";
                overlay.style.display = "none";
            });
        });
    </script>
</body>
</html>