<?php
// Include database connection
include('../includes/db.php');

// Add or edit a user
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit_user'])) {
    $user_id = intval($_POST['user_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']); // 'job_seeker' or 'employer'

    if (!empty($name) && !empty($email) && in_array($role, ['job_seeker', 'employer'])) {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $name, $email, $role, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Delete a user
if (isset($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_users.php");
}

// Fetch all users
$users = $conn->query("SELECT * FROM users ORDER BY user_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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

        button {
            padding: 5px 10px;
            font-size: 14px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            color: #007BFF;
        }

        a:hover {
            text-decoration: underline;
        }

        .edit-form {
            margin-top: 20px;
        }

        input[type="text"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Users</h1>

        <!-- User List Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $users->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $user['user_id']; ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <button class="edit-btn" 
                                data-id="<?php echo $user['user_id']; ?>" 
                                data-name="<?php echo htmlspecialchars($user['name']); ?>" 
                                data-email="<?php echo htmlspecialchars($user['email']); ?>" 
                                data-role="<?php echo htmlspecialchars($user['role']); ?>">Edit</button>
                        <a href="manage_users.php?delete=<?php echo $user['user_id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Edit User Form -->
        <form method="POST" class="edit-form" id="edit-form">
            <input type="hidden" name="user_id" id="user_id">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="job_seeker">Job Seeker</option>
                <option value="employer">Employer</option>
            </select>
            <button type="submit" name="edit_user">Save Changes</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editButtons = document.querySelectorAll(".edit-btn");
            const editForm = document.getElementById("edit-form");

            // Handle Edit Button Click
            editButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    const userId = this.dataset.id;
                    const userName = this.dataset.name;
                    const userEmail = this.dataset.email;
                    const userRole = this.dataset.role;

                    // Populate form fields with user data
                    editForm.user_id.value = userId;
                    editForm.name.value = userName;
                    editForm.email.value = userEmail;
                    editForm.role.value = userRole;

                    // Scroll to form for better visibility
                    editForm.scrollIntoView({ behavior: "smooth" });
                });
            });
        });
    </script>
</body>
</html>