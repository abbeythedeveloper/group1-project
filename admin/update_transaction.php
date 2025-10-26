<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "../db.php";

// Ensure logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Only admins can access
if ($_SESSION['role'] != "admin") {
    header("Location: ../dashboard.php");
    exit;
}

// Get transaction ID
if (!isset($_GET['transaction_id'])) {
    die("Transaction ID not provided.");
}
$transaction_id = intval($_GET['transaction_id']);
if ($transaction_id <= 0) {
    die("Invalid transaction ID.");
}

// Fetch transaction data
$sql = "SELECT * FROM transactions WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $transaction_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Transaction not found (ID: $transaction_id).");
}

$transaction = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $return_date = $_POST['returndate'] ?? '';

    if ($return_date === '') {
        $form_error = "Return date is required.";
    } else {
        $update_sql = "UPDATE transactions SET return_date = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $return_date, $transaction_id);

        if ($update_stmt->execute()) {
            // ✅ Make sure this matches your actual file name
            header("Location: view_trransactions.php?success=1");
            exit;
        } else {
            $form_error = "Error updating: " . htmlspecialchars($update_stmt->error);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Update Transaction</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">
      Update Transaction #<?php echo htmlspecialchars($transaction_id); ?>
    </h2>

    <?php if (!empty($form_error)): ?>
      <div class="mb-4 text-sm text-red-700 bg-red-100 border border-red-200 p-3 rounded">
        <?php echo htmlspecialchars($form_error); ?>
      </div>
    <?php endif; ?>

    <form action="update_transaction.php?transaction_id=<?php echo $transaction_id; ?>" method="POST" class="space-y-4">
      <div>
        <label class="block text-gray-600 text-sm font-semibold mb-2">Return Date</label>
        <input type="date" name="returndate" required
               value="<?php echo htmlspecialchars($transaction['return_date'] ?? ''); ?>"
               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>

      <div class="flex justify-between mt-6">
        <a href="view_trransactions.php" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">Cancel</a>
        <button type="submit" name="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">Update</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
