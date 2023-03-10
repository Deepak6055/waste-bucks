<?php
// Start the session
session_start();

// Connect to the database
$db = new mysqli("localhost", "root", "", "scrap_management");

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
  // Redirect to the login page
  header("Location: ../login.html");
  exit;
}

// Get the list of orders
$query = "SELECT * FROM Orders";
$result = $db->query($query);

// Get the list of scrap listings
$query = "SELECT * FROM Scrap";
$scrap_result = $db->query($query);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $order_id = $_POST["order_id"];
  $status = $_POST["status"];

  // Validate the form data
  if (empty($order_id)) {
    $error = "Order ID is required";
  } else if (empty($status)) {
    $error = "Status is required";
  } else {
    // Update the order status
    $query = "UPDATE Orders SET status = ? WHERE order_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<head>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  .tb{
    border:10px solid;
    width:100%;
    text-align:center;

  }

  <title>Waste Bucks-About</title>
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
table{
  border: 1px solid black;
  width: 900px;
  height: 70px;
  text-align: center;
}

th ,td,tr{
    border:20px solid;
    border-color:#88b0b5;

    }
    .hi{
        background-color:#c9edf2;
      }
</style>
  <title>Waste bucks - Employee Dashboard</title>
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
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->
  <main id="main">
   <section class = "hi">
  <h1>Employee Dashboard</h1>
  <h2>Orders</h2>
  <table>
  <tr>
    <th>Order ID</th>
    <th>Type</th>
    <th>Quantity</th>
    <th>Price</th>
    <th>Buyer</th>
    <th>Vendor</th>
    <th>Status</th>
    <th>Action</th>
  </tr>
  <?php while ($order = $result->fetch_assoc()): ?>
    <tr>
      <td><?php echo $order["order_id"]; ?></td>
      <td><?php echo $order["type"]; ?></td>
      
      <td><?php echo $order["quantity"]; ?></td>
      <td><?php echo $order["price"]; ?></td>
      <td>
  <?php
  // Get the buyer for the order
  $buyer_id = $order["buyer_id"];
  $query = "SELECT * FROM Buyer WHERE buyer_id = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("i", $buyer_id);
  $stmt->execute();
  $buyer_result = $stmt->get_result();
  $buyer = $buyer_result->fetch_assoc();
  echo $buyer["name"];
  ?>
</td>
<td>
  <?php
  // Get the vendor for the order
  $vendor_id = $order["vendor_id"];
  $query = "SELECT * FROM Vendor WHERE vendor_id = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("i", $vendor_id);
  $stmt->execute();
  $vendor_result = $stmt->get_result();
  $vendor = $vendor_result->fetch_assoc();
  echo $vendor["name"];
  ?>
</td>
<td><?php echo $order["status"]; ?></td>
<td>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <input type="hidden" name="order_id" value="<?php echo $order["order_id"]; ?>">
    <select name="status">
      <option value="pending" <?php if ($order["status"] == "pending") echo "selected"; ?>>Pending</option>
      <option value="in progress" <?php if ($order["status"] == "in progress") echo "selected"; ?>>In Progress</option>
      <option value="completed" <?php if ($order["status"] == "completed") echo "selected"; ?>>Completed</option>
    </select>
    <input type="submit" value="Update Status">
  </form>
</td>
</tr>
<?php endwhile; ?>
</table>
<h2>Scrap Listings</h2>


<?php
// Check if the form was submitted
if (isset($_POST["submit"])) {
  // Get the order ID and status from the form
  $order_id = $_POST["order_id"];
  $status = $_POST["status"];

  // Update the status of the order
  $query = "UPDATE Orders SET status = ? WHERE order_id = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("si", $status, $order_id);
  $stmt->execute();

  // Get the order details
  $query = "SELECT * FROM Orders WHERE order_id = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("i", $order_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $order = $result->fetch_assoc();

  // Get the vendor and buyer IDs
  $vendor_id = $order["vendor_id"];
  $buyer_id = $order["buyer_id"];

  // Get the type and quantity of scrap
  $type = $order["type"];
  $quantity = $order["quantity"];

  // Get the price of the scrap
  $price = $order["price"];

  // Insert a new row into the Transactions table
  $query = "INSERT INTO Transactions (vendor_id, buyer_id, type, quantity, price, date, status) VALUES (?, ?, ?, ?, ?, NOW(), ?)";
  $stmt = $db->prepare($query);
  $stmt->bind_param("iisidi", $vendor_id, $buyer_id, $type, $quantity, $price, $status);
  $stmt->execute();
}
?>

<!-- Form to update the status of an order -->
<form action="" method="POST">
  <label for="order_id">Order ID:</label>
  <input type="text" name="order_id" id="order_id">
  <br>
  <label for="status">Status:</label>
  <select name="status" id="status">
    <option value="completed">Completed</option>
    <option value="cancelled">Cancelled</option>
  </select>
  <br>
  <input type="submit" name="submit" value="Update">
</form>
</section>
<br>
<a href="employee_logout.php";style="border:orange; border-width:5px; border-style:solid;">Logout</a>
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
</body>
</html>
