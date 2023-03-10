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
  $type = $_POST["type"];
  $quantity = $_POST["quantity"];
  $price = $_POST["price"];
  $other_details = $_POST["other_details"];
  $vendor_id = $_SESSION["user_id"];

  // Insert the new scrap listing into the Scrap table
  $query = "INSERT INTO Scrap (type, quantity, price, other_details, vendor_id) VALUES (?, ?, ?, ?, ?)";
  $stmt = $db->prepare($query);
  $stmt->bind_param("siiss", $type, $quantity, $price, $other_details, $vendor_id);
  $stmt->execute();

  // Redirect back to the vendor dashboard
  header("Location: vendor_dashboard.php");
  exit;
}

?>
