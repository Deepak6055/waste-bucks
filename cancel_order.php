<?php
// Start the session
session_start();

if (!isset($_SESSION["user_id"])) {
  // Redirect to the login page
  header("Location: buyer_login.php");
  exit;
}

// Connect to the database
$db = new mysqli("localhost", "root", "", "scrap_management");

// Check if the form was submitted
if (isset($_POST["order_id"])) {
  // Get the order details
  $order_id = $_POST["order_id"];
  $query = "SELECT * FROM Orders WHERE order_id = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("i", $order_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $order = $result->fetch_assoc();

  // Check if the order is pending
  if ($order["status"] == "pending") {
    // Cancel the order
    $query = "UPDATE Orders SET status = 'cancelled' WHERE order_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    // Redirect to the buyer dashboard
    header("Location: buyer_dasboard.php");
    exit;
  } else {
    // Display an error message
    echo "Error: The order cannot be cancelled because it is not pending.";
  }
} else {
  // Display an error message
  echo "Error: Invalid request.";
}
?>
