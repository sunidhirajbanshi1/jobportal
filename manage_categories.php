<?php
// Include database connection
include('../includes/db.php');

// Add a new category
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_category'])) {
    $category_name = trim($_POST['category_name']);
    if (!empty($category_name)) {
        $stmt = $conn->prepare("INSERT INTO job_categories (category_name) VALUES (?)");
        $stmt->bind_param("s", $category_name);
        $stmt->execute();
        $stmt->close();
    }
}

// Edit a category
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit_category'])) {
    $category_id = intval($_POST['category_id']);
    $category_name = trim($_POST['category_name']);
    if (!empty($category_name)) {
        $stmt = $conn->prepare("UPDATE job_categories SET category_name = ? WHERE category_id = ?");
        $stmt->bind_param("si", $category_name, $category_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Delete a category
if (isset($_GET['delete'])) {
    $category_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM job_categories WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_categories.php");
}

// Fetch all categories
$result = $conn->query("SELECT * FROM job_categories ORDER BY category_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
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

        input[type="text"], button {
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
            const addForm = document.getElementById("add-category-form");
            const categoryNameInput = document.getElementById("category_name");

            // Handle Edit Button Click
            editButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    const categoryId = this.dataset.id;
                    const categoryName = this.dataset.name;

                    // Prefill the form with the category data
                    categoryNameInput.value = categoryName;

                    // Change the form action for editing
                    addForm.innerHTML = `
                        <input type="hidden" name="category_id" value="${categoryId}">
                        <label for="category_name">Edit Category:</label>
                        <input type="text" id="category_name" name="category_name" value="${categoryName}" required>
                        <button type="submit" name="edit_category">Save Changes</button>
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
        <h1>Manage Categories</h1>
        
        <!-- Add or Edit Category Form -->
        <form id="add-category-form" method="POST">
            <label for="category_name">Add New Category:</label>
            <input type="text" id="category_name" name="category_name" required>
            <button type="submit" name="add_category">Add Category</button>
        </form>

        <!-- Category List Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['category_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    <td>
                        <button class="edit-btn" data-id="<?php echo $row['category_id']; ?>" 
                            data-name="<?php echo htmlspecialchars($row['category_name']); ?>">Edit</button>
                        <a href="manage_categories.php?delete=<?php echo $row['category_id']; ?>" 
                            onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>