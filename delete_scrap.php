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

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $scrap_id = $_POST["scrap_id"];

  // Delete the scrap listing from the Scrap table
  $query = "DELETE FROM Scrap WHERE scrap_id = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("i", $scrap_id);
  $stmt->execute();

  // Redirect back to the vendor dashboard
  header("Location: vendor_dashboard.php");
  exit;
}

// Get the scrap_id from the URL
$scrap_id = $_GET["scrap_id"];

// Get the scrap listing from the Scrap table
$query = "SELECT * FROM Scrap WHERE scrap_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $scrap_id);
$stmt->execute();
$result = $stmt->get_result();
$scrap = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Waste Bucks-Delete Scrap</title>
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
</head>
<body>
<main id="main">

<section class="breadcrumbs">
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
          <li><a class="" href="index.html">Home</a></li>
          <li><a class="" href="about.html">About</a></li>
          <li><a href="userregistration.html">User and worker login</a></li></a></li>
          <li><a href="portfolio.html">Registration</a></li>
          <li><a href="team.html">Team</a></li>
          <li><a href="contact.html">Contact Us</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
  <h1>Delete Scrap</h1>
  <p>Are you sure you want to delete the following scrap listing?</p>
  <p>Type: <?php echo $scrap["type"]; ?></p>
  <p>Quantity: <?php echo $scrap["quantity"]; ?></p>
  <p>Price: <?php echo $scrap["price"]; ?></p>
  <p>Other Details: <?php echo $scrap["other_details"]; ?></p>
  <form action="delete_scrap.php" method="POST">
    <input type="hidden" name="scrap_id" value="<?php echo $scrap_id; ?>">
    <input type="submit" value="Delete">
  </form>
</main>
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

