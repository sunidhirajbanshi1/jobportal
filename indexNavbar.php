<!DOCTYPE html>
<title></title>
<head>
 <style>
  .navbar {
  display: flex; /* Use flexbox for horizontal layout */
  justify-content: space-between; /* Align logo to left and nav to right */
  align-items: center; /* Vertically center items */
  padding: 5px; /* Add some padding for spacing */
  background-color: #fff; /* Set background color for the navbar */
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Add a subtle box shadow */
}

.logo {
  display: flex; /* Use flexbox for logo and text */
  align-items: center; 
}

.logo img {
  margin-right: 10px; 
}

.logo span {
  font-size: 20px;
  font-weight: bold;
  color: #0056b3; /* Customize logo color */
}

nav {
  display: flex; /* Use flexbox for horizontal navigation links */
}

nav a {
  color: #333; /* Set link color */
  text-decoration: none;
  margin-left: 20px; /* Add spacing between links */
  transition: color 0.3s ease; /* Smooth color transition on hover */
}

nav a:hover {
  color: #0056b3; /* Change link color on hover */
}</style>
</head>
<div class="navbar">
<div class="logo">
            <img src="logo.png" alt="Logo">
            <span>JOBS</span>
        </div>
       
      
       <nav class="navbar1.php">
          <a href="index1.php">Home</a> 
             <a href="Aboutus.html">About Us</a>
             <a href="contact.html">Contact Us</a>
            <a href="jobseeker1.php">Jobseekers</a>
            <a href="employerlogin.php">Employers</a>
           
          
          <!-- <li><a href="">About Us</a></li> -->
          <!-- <li><a href="">Contact Us</a></li> -->

</nav>
    </div>

   
  
