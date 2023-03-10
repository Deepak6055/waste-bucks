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
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $address = $_POST["address"];
  $phone = $_POST["phone"];
  $vendor_id = $_SESSION["user_id"];

  // Update the vendor's profile in the Vendor table
  $query = "UPDATE Vendor SET name = ?, email = ?, password = ?, address = ?, phone = ? WHERE vendor_id = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("sssssi", $name, $email, $password, $address, $phone, $vendor_id);
  $stmt->execute();

  // Update the session variables
  $_SESSION["name"] = $name;

  // Redirect back to the vendor dashboard
  header("Location: vendor_dashboard.php");
  exit;
}

// Get the current vendor's profile from the Vendor table
$vendor_id = $_SESSION["user_id"];
$query = "SELECT * FROM Vendor WHERE vendor_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $vendor_id);
$stmt->execute();
$result = $stmt->get_result();
$vendor = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head>
  <title>Waste Bucks - Update Profile</title>
</head>
<body>
  <h1>Update Profile</h1>
  <form action="update_profile.php" method="POST">
    <label for="name">Name:</label><br>
    <input type="text" name="name" value="<?php echo $vendor["name"]; ?>" required><br>
    <label for="email">Email:</label><br>
    <input type="email" name="email" value="<?php echo $vendor["email"]; ?>" required><br>
    <label for="password">Password:</label><br>
    <input type="password" name="password"><br>
    <label for="address">Address:</label><br>
    <input type="text" name="address" value="<?php echo $vendor["address"]; ?>"><br>
    <label for="phone">Phone:</label><br>
    <input type="text" name="phone" value="<?php echo $vendor["phone"]; ?>"><br><br>
    <input type="submit" value="Update Profile">
  </form>
</body>
</html>
