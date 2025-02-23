<?php
// Include database connection
include('db.php');

// Fetch all categories
$result = $conn->query("SELECT * FROM job_categories ORDER BY category_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Categories</title>
  <style>
    body {
      font-family: sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f0f0f0;
    }

    .container {
      max-width: 960px;
      margin: 0 auto;
      padding: 20px;
    }

    h3 {
      text-align: center;
      margin-bottom: 20px;
    }

    select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      background-color: #fff;
      margin-bottom: 20px;
    }

    .button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      text-align: center;
      margin-top: 10px;
    }

    .button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

<div class="container">
   
    <form method="GET" action="joblisting.php">
      <select name="category" id="category-dropdown" required>
        <option value="">Job Categories</option>
        <?php while ($row = $result->fetch_assoc()): ?>
          <option value="<?php echo htmlspecialchars($row['category_id']); ?>">
            <?php echo htmlspecialchars($row['category_name']); ?>
          </option>
        <?php endwhile; ?>
      </select>
      <button class="button" type="submit">View Jobs</button>
    </form>
  </div>

</body>
</html>


