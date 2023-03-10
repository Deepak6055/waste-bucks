<!DOCTYPE html>
<html>
<head>
  <title>Scrap Management - Transactions</title>
</head>
<body>
  <h1>Transactions</h1>
  <?php
  // Start the session
  session_start();

  if (!isset($_SESSION["user_id"])) {
    // Redirect to the login page
    header("Location: login.php");
    exit;
  }

  // Connect to the database
  $db = new mysqli("localhost", "root", "", "scrap_management");

  // Get the transactions for the current user
  $user_id = $_SESSION["user_id"];
  $query = "SELECT * FROM Transactions WHERE buyer_id = ? OR vendor_id = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("ii", $user_id, $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  ?>
  <table>
    <tr>
      <th>Type</th>
      <th>Quantity</th>
      <th>Price</th>
      <th>Vendor</th>
      <th>Buyer</th>
      <th>Date</th>
      <th>Status</th>
    </tr>
    <?php while ($transaction = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo $transaction["type"]; ?></td>
        <td><?php echo $transaction["quantity"]; ?></td>
        <td><?php echo $transaction["price"]; ?></td>
        <td>
          <?php
          // Get the vendor for the transaction
          $vendor_id = $transaction["vendor_id"];
          $query = "SELECT * FROM Vendor WHERE vendor_id = ?";
          $stmt = $db->prepare($query);
          $stmt->bind_param("i", $vendor_id);
          $stmt->execute();
          $vendor_result = $stmt->get_result();
          $vendor = $vendor_result->fetch_assoc();
          echo $vendor["name"];
          ?>
        </td>
        <td>
          <?php
          // Get the buyer for the transaction
          $buyer_id = $transaction["buyer_id"];
          $query = "SELECT * FROM Buyer WHERE buyer_id = ?";
          $stmt = $db->prepare($query);
          $stmt->bind_param("i", $buyer_id);
          $stmt->execute();
          $buyer_result = $stmt->get_result();
         $buyer = $buyer_result->fetch_assoc();
          echo $buyer["name"]; ?>
        </td>
        <td><?php echo $transaction["date"]; ?></td>
        <td><?php echo $transaction["status"]; ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>

