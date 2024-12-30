<?php include "conn.php"; ?>
<html>
  <title></title>
  <head>
    <link rel=" stylesheet" href="style.css">
  </head>

<body>
  <?php include "indexNavbar.php"; ?>
 
  <div class="search-bar">
                <input type="text" placeholder="Search by job title, keywords, companies">
                <button>Search</button>
            </div>
            <?php include("joblisting.php")?>
    

    <!-- Footer -->
    <div id="footer">
      <!-- Footer Widgets -->
      <?php include 'footer1.php'; ?>
      <!-- Footer Copyrights -->
      <?php include 'footer.php'; ?>
    </div>
  </div>

 
</body>
</html>
