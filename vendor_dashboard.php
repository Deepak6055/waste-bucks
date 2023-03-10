<?php

// Start the session
session_start();

// Make sure the user is logged in and is a vendor
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] != "vendor") {
  header("Location: login.php");
  exit;
}

// Connect to the database
$db = new mysqli("localhost", "root", "", "scrap_management");

// Get the vendor's current scrap listings
$vendor_id = $_SESSION["user_id"];
$query = "SELECT * FROM Scrap WHERE vendor_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $vendor_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
<style>
  table, td, th {
  border: 1px solid black;
  width: 900px;
  height: 70px;
  text-align: center;
}
</style>
  <title>Waste Bucks-Vendor Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
    th ,td,tr{
    border:20px solid;
    border-color:#88b0b5;

    }
    .hi{
        background-color:#c9edf2;
      }
    </style>

</head>
<body>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex justify-content-between align-items-center">

      <div class="logo">
        <h1 class="text-light"><a href="index.html"><span>Waste Bucks</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="" href="../index.html">Home</a></li>
          <li><a class="active" href="../about.html">About</a></li>
          <li><a href="../userregistration.html">User and worker login</a></li></a></li>
          <li><a href="../portfolio.html">Registration</a></li>
          <li><a href="../team.html">Team</a></li>
        
          <li><a href="../contact.html">Contact Us</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
      

    </div>
  </header><!-- End Header -->
  <main id="main">
  <section class="breadcrumbs">
  <div class="hi">
  <h1>Vendor Dashboard</h1>
  <h2>Welcome to Dashboard session </br><?php echo $_SESSION["name"]; ?></h2>
  <h3>Current Scrap Listings </h3>
  <table>
    <tr>
      <th>Type</th>
      <th>Quantity</th>
      <th>Price</th>
      <th>Other Details</th>
      <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $row["type"]; ?></td>
        <td><?php echo $row["quantity"]; ?></td>
        <td><?php echo $row["price"]; ?></td>
                <td><?php echo $row["other_details"]; ?></td>
                <td>
                  <a href="edit_scrap.php?scrap_id=<?php echo $row["scrap_id"]; ?>">Edit</a> | 
                  <a href="delete_scrap.php?scrap_id=<?php echo $row["scrap_id"]; ?>">Delete</a>
                </td>
              </tr>
            <?php } ?>
          </table>

          <h3>Add New Scrap Listing</h3>
          <form action="add_scrap.php" method="POST">
            <label for="type">Type:</label><br>
            <input type="text" name="type" required><br>
            <label for="quantity">Quantity:</label><br>
            <input type="number" name="quantity" required><br>
            <label for="price">Price:</label><br>
            <input type="number" name="price" required><br>
            <label for="other_details">Other Details:</label><br>
            <textarea name="other_details"></textarea><br><br>
            <input type="submit" value="Add Scrap">
          </form>
        
          <h3>Outstanding Orders</h3>
          <!-- TODO: Add code to display the vendor's outstanding orders -->
        
          <h3>Update Profile</h3>
          <form action="update_profile.php" method="POST">
            <label for="name">Name:</label><br>
            <input type="text" name="name" value="<?php echo $_SESSION["name"]; ?>" required><br>
            <label for="email">Email:</label><br>
            <!-- TODO: Add code to retrieve the vendor's current email -->
            <input type="email" name="email" required><br>
            <label for="password">Password:</label><br>
            <input type="password" name="password"><br>
            <label for="address">Address:</label><br>
            <!-- TODO: Add code to retrieve the vendor's current address -->
            <input type="text" name="address"><br>
            <label for="phone">Phone:</label><br>
            <!-- TODO: Add code to retrieve the vendor's current phone -->
            <input type="text" name="phone"><br><br>
            <input type="submit" value="Update Profile">
          </form>
    </section>
    </div>
    <br>
<a href="vendor_logout.php";style="border:orange; border-width:5px; border-style:solid;">Logout</a>
        <!-- ======= Footer ======= -->
 <footer id="footer" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">

<div class="footer-newsletter">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <h4>Our Newsletter</h4>
        <p>To get our newsletter please Subscribe</p>
      </div>
      <div class="col-lg-6">
        <form action="" method="post">
          <input type="email" name="email"><input type="submit" value="Subscribe">
        </form>
      </div>
    </div>
  </div>
</div>

<div class="footer-top">
  <div class="container">
    <div class="row">

      <div class="col-lg-3 col-md-6 footer-links">
        <h4>Useful Links</h4>
        <ul>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6 footer-links">
        <h4>Our Services</h4>
        <ul>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Paper recycling</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Aluminum recycling</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Bulk pickup</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Volunteering</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Swach Bharath</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6 footer-contact">
        <h4>Contact Us</h4>
        <p>
          B609 baker's street<br>
          Bangalore,916005<br>
          India <br><br>
          <strong>Phone:</strong>+919886655442<br>
          <strong>Email:</strong>infowastebucks@ggmail.com<br>
        </p>

      </div>

      <div class="col-lg-3 col-md-6 footer-info">
        <h3>About Waste bucks</h3>
        <p>It is a start up company which is trying to make this world a better place to live follwing the golden 3R rule reduce,reuse,recycle</p>
        <div class="social-links mt-3">
          <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
          <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
          <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
          <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="container">
  <div class="copyright">
    &copy; Copyright <strong><span>WASTE BUCKS</span></strong>. All Rights Reserved
  </div>
  <div class="credits">
    <!-- All the links in the footer should remain intact. -->
    <!-- You can delete the links only if you purchased the pro version. -->
    <!-- Licensing information: https://bootstrapmade.com/license/ -->
    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/free-bootstrap-template-corporate-moderna/ -->
    Designed by <a href="https://bootstrapmade.com/">Baskhar and Deepak</a>
  </div>
</div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
        </body>
        </html>
        