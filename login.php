<head>
  <style type="text/css">
    /* Your CSS goes here */
  </style>
</head>
<?php

// Connect to the database
$db = new mysqli("localhost", "root", "", "scrap_management");

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $email = $_POST["email"];
  $password = $_POST["password"];

  // Query the database to check if the email and password match a user in any of the tables
  $query = "SELECT * FROM Vendor WHERE email = ? AND password = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    // Login successful - set the session variables and redirect to the dashboard
    session_start();
    $_SESSION["user_id"] = $result->fetch_assoc()["vendor_id"];
    $_SESSION["name"] = $result->fetch_assoc()["name"];
    $_SESSION["role"] = "vendor";
    header("Location: vendor/vendor_dashboard.php");
    exit;
  } else {
    $query = "SELECT * FROM Buyer WHERE email = ? AND password = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      // Login successful - set the session variables and redirect to the dashboard
      session_start();
      $_SESSION["user_id"] = $result->fetch_assoc()["buyer_id"];
      $_SESSION["name"] = $result->fetch_assoc()["name"];
      $_SESSION["role"] = "buyer";
      header("Location: buyer/buyer_dasboard.php");
      exit;
    } else {
      $query = "SELECT * FROM Employee WHERE email = ? AND password = ?";
      $stmt = $db->prepare($query);
      $stmt->bind_param("ss", $email, $password);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        // Login successful - set the session variables and redirect to the dashboard
        session_start();
        $_SESSION["user_id"] = $result->fetch_assoc()["employee_id"];
        $_SESSION["name"] = $result->fetch_assoc()["name"];
        $_SESSION["role"] = "employee";
        header("Location: employee/employee_dashboard.php");
        exit;
      } else {
        // Login failed - show an error message
        echo "Invalid email or password";
      }
    }
  }
}

?>

