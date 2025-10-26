<?php
session_start();
include "../db.php";

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Only admin can access
if ($_SESSION['role'] != "admin") {
    header("Location: ../dashboard.php");
    exit;
}

// Delete transaction if ID is provided
if (isset($_GET['transaction_id'])) {
    $transaction_id = intval($_GET['transaction_id']);

    $stmt = $conn->prepare("DELETE FROM transactions WHERE id = ?");
    $stmt->bind_param("i", $transaction_id);

    if ($stmt->execute()) {
        // Redirect with success flag to refresh the list
        header("Location: view_trransactions.php?deleted=1");
        exit;
    } else {
        header("Location: view_trransactions.php?error=" . urlencode($stmt->error));
        exit;
    }
}

// Fetch all transactions
$sql = "SELECT * FROM transactions ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>View Transactions</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="container mx-auto px-4 py-8">
  <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Library Transactions</h1>

  <!-- ✅ Success & Error Messages -->
  <?php if (isset($_GET['deleted'])): ?>
    <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg text-center">
      ✅ Transaction deleted successfully!
    </div>
  <?php elseif (isset($_GET['error'])): ?>
    <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg text-center">
      ❌ Error deleting transaction: <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
  <?php endif; ?>

  <div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-lg shadow-md">
      <thead>
        <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
          <th class="py-3 px-6 text-left">User ID</th>
          <th class="py-3 px-6 text-left">Book ID</th>
          <th class="py-3 px-6 text-left">Issue Date</th>
          <th class="py-3 px-6 text-left">Return Date</th>
          <th class="py-3 px-6 text-left">Status</th>
          <th class="py-3 px-6 text-center">Action</th>
        </tr>
      </thead>
      <tbody class="text-gray-600 text-sm font-light">
        <?php while ($row = $result->fetch_assoc()) { ?>
          <tr class="border-b border-gray-200 hover:bg-gray-100">
            <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['user_id']); ?></td>
            <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['book_id']); ?></td>
            <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['issue_date']); ?></td>
            <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['return_date']); ?></td>
            <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['status']); ?></td>
            <td class="py-3 px-6 text-center">
              <a href="update_transactions.php?transaction_id=<?php echo $row['id']; ?>"
                 class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-xs mr-2">
                 Update
              </a>
              <a href="view_trransactions.php?transaction_id=<?php echo $row['id']; ?>"
                 class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-xs"
                 onclick="return confirm('Are you sure you want to delete this transaction?');">
                 Delete
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
