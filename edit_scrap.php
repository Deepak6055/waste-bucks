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

// Get the scrap_id from the URL
$scrap_id = $_GET["scrap_id"];

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $type = $_POST["type"];
  $quantity = $_POST["quantity"];
  $price = $_POST["price"];
  $other_details = $_POST["other_details"];

  // Update the scrap listing in the Scrap table
  $query = "UPDATE Scrap SET type = ?, quantity = ?, price = ?, other_details = ? WHERE scrap_id = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("siisi", $type, $quantity, $price, $other_details, $scrap_id);
  $stmt->execute();

  // Redirect back to the vendor dashboard
  header("Location: vendor_dashboard.php");
  exit;
}

// Get the current scrap listing from the Scrap table
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
  <title>Waste Bucks - Edit Scrap Listing</title>
</head>
<body>
  <h1>Edit Scrap Listing</h1>
  <form action="edit_scrap.php?scrap_id=<?php echo $scrap_id; ?>" method="POST">
    <label for="type">Type:</label><br>
    <input type="text" name="type" value="<?php echo $scrap["type"]; ?>" required><br>
    <label for="quantity">Quantity:</label><br>
    <input type="number" name="quantity" value="<?php echo $scrap["quantity"]; ?>" required><br>
    <label for="price">Price:</label><br>
    <input type="number" name="price" value="<?php echo $scrap["price"]; ?>" required><br>
    <label for="other_details">Other Details:</label><br>
    <textarea name="other_details"><?php echo $scrap["other_details"]; ?></textarea><br><br>
    <input type="submit" value="Save Changes">
  </form>
</body>
</html>
