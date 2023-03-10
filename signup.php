<?php

// Connect to the database
$db = new mysqli("localhost", "root", "", "scrap_management");

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $role = $_POST["role"];

  // Insert the new user into the appropriate table
  if ($role == "vendor") {
    $address = $_POST["vendor-address"];
    $phone = $_POST["vendor-phone"];
    $query = "INSERT INTO Vendor (name, email, password, address, phone) VALUES (?, ?, ?, ?, ?)";
  } elseif ($role == "buyer") {
    $address = $_POST["buyer-address"];
    $phone = $_POST["buyer-phone"];
    $query = "INSERT INTO Buyer (name, email, password, address, phone) VALUES (?, ?, ?, ?, ?)";
  } elseif ($role == "employee") {
    $role = $_POST["employee-role"];
    $phone = $_POST["employee-phone"];
    $query = "INSERT INTO Employee (name, email, password, role, phone) VALUES (?, ?, ?, ?, ?)";
  }
  $stmt = $db->prepare($query);
  $stmt->bind_param("sssss", $name, $email, $password, $address, $phone);
  $stmt->execute();

  // Redirect to the login page
  header("Location: userregistration.html");
  exit;
}

?>
