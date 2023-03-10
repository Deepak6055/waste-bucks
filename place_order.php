<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
  // Redirect to the login page
  header("Location: login.php");
  exit;
}

// Check if the form was submitted
if (isset($_POST["scrap_id"])) {
  // Get the form data
  $scrap_id = $_POST["scrap_id"];
  $buyer_id = $_SESSION["user_id"];

  // Connect to the database
  $db = new mysqli("localhost", "root", "", "scrap_management");

  // Get the scrap details
  $query = "SELECT * FROM Scrap WHERE scrap_id = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("i", $scrap_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $scrap = $result->fetch_assoc();

  // Get the vendor details
  $vendor_id = $scrap["vendor_id"];
  $query = "SELECT * FROM Vendor WHERE vendor_id = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("i", $vendor_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $vendor = $result->fetch_assoc();

  // Insert the order into the database
  $query = "INSERT INTO Orders (buyer_id, vendor_id, scrap_id, type, quantity, price, status, timestamp) VALUES (?, ?, ?, ?, ?, ?, 'pending', CURRENT_TIMESTAMP)";
  $stmt = $db->prepare($query);
  $stmt->bind_param("iisiid", $buyer_id, $vendor_id, $scrap_id, $scrap["type"], $scrap["quantity"], $scrap["price"]);
  $stmt->execute();

  

  // Redirect to the buyer dashboard
  header("Location: buyer_dasboard.php");
  exit;
}

