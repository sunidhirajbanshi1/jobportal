<?php
// job_listings.php

// Enable error reporting (for development purposes)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include your database connection file
include('db.php');

// Fetch the logo from the database (assuming you want the first logo)
$logoQuery = "SELECT logo_url FROM logos ORDER BY logo_id ASC LIMIT 1";
$logoResult = $conn->query($logoQuery);
$logo = $logoResult->fetch_assoc();

// Query to get all jobs (customize the ORDER BY or LIMIT as needed)
$query = "SELECT * FROM jobs ORDER BY job_id DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Job Listings</title>
  <style>
    /* Basic Reset */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
    }
    
    header {
      display: flex;
      align-items: center;
      padding: 10px 20px;
      background-color: #fff;
      border-bottom: 1px solid #ddd;
      margin-bottom: 20px;
    }
    
    header img {
      max-height: 60px;
      margin-right: 20px;
    }
    
    header h1 {
      color: #0056b3;
    }
    
    .job-listings-container {
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .job-card {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 5px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      transition: transform 0.2s;
    }
    
    .job-card:hover {
      transform: translateY(-3px);
    }
    
    .job-card h2 {
      font-size: 24px;
      margin-bottom: 10px;
      color: #0056b3;
    }
    
    .job-card p {
      margin-bottom: 8px;
      color: #555;
    }
    
    .job-card .job-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      font-size: 14px;
      color: #777;
      margin: 15px 0;
    }
    
    .job-card a {
      display: inline-block;
      padding: 10px 15px;
      background-color: #0056b3;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
    }
    
    .job-card a:hover {
      background-color: #003f7f;
    }
  </style>
</head>
<body>
  <!-- Header with Logo (fetched from the database) -->
  <header>
    <?php if (!empty($logo['logo_url'])): ?>
      <img src="<?php echo htmlspecialchars($logo['logo_url']); ?>" alt="Company Logo">
    <?php else: ?>
      <!-- Fallback if no logo is set -->
      <img src="logo.png" alt="Company Logo">
    <?php endif; ?>
    <h1>Job Portal</h1>
  </header>

  <div class="job-listings-container">
    <h1>Latest Job Listings</h1>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($job = $result->fetch_assoc()): ?>
        <div class="job-card">
          <h2><?php echo htmlspecialchars($job['job_title']); ?></h2>
          <div class="job-meta">
            <span><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></span>
            <span><strong>Experience:</strong> <?php echo htmlspecialchars($job['experience']); ?></span>
            <span><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?></span>
            <span><strong>Deadline:</strong> <?php echo htmlspecialchars($job['deadline']); ?></span>
          </div>
          <p>
            <?php 
              // Show a short snippet of the job description (first 100 characters)
              echo htmlspecialchars(substr($job['description'], 0, 100)) . '...'; 
            ?>
          </p>
          <a href="jobdetails.php?id=<?php echo $job['job_id']; ?>">View Details</a>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No job listings available at the moment.</p>
    <?php endif; ?>
  </div>
</body>
</html>
