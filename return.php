<?php
session_start();
include "../db.php"; // adjust path if needed

// Require admin
if(!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin'){
    header("Location: ../login.php");
    exit;
}

// configuration
$fine_per_day = 50.00; // currency units per day (change as needed)

if(!isset($_GET['transaction_id']) && !isset($_POST['transaction_id'])){
    echo "Missing transaction id.";
    exit;
}

$transaction_id = (int)($_GET['transaction_id'] ?? $_POST['transaction_id'] ?? 0);
if($transaction_id <= 0){
    echo "Invalid transaction id.";
    exit;
}

// Helper: fetch transaction and book + user info
function fetch_transaction($conn, $id){
    $sql = "SELECT t.*, b.title AS book_title, b.quantity AS book_quantity, u.username AS borrower
            FROM transactions t
            JOIN books b ON b.id = t.book_id
            JOIN users u ON u.id = t.user_id
            WHERE t.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
    return $row;
}

$tx = fetch_transaction($conn, $transaction_id);
if(!$tx){
    echo "Transaction not found.";
    exit;
}

// If form submitted, process return
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_return'])){
    $return_date_input = trim($_POST['return_date'] ?? '');
    // Accept various formats, convert to Y-m-d
    try {
        $return_dt = new DateTime($return_date_input);
        $return_date = $return_dt->format('Y-m-d');
    } catch (Exception $e) {
        $_SESSION['flash'] = "Invalid return date format.";
        header("Location: return.php?transaction_id=$transaction_id");
        exit;
    }

    // compute overdue
    $due_date = $tx['due_date']; // expected as Y-m-d in DB
    $due_dt = new DateTime($due_date);
    $overdue_days = 0;
    if($return_dt > $due_dt){
        $interval = $due_dt->diff($return_dt);
        $overdue_days = (int)$interval->days;
    }

    $fine_amount = $overdue_days * $fine_per_day;

    // Update transaction: set return_date, status, fine
    $update_sql = "UPDATE transactions SET return_date = ?, status = 'returned', fine = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sdi", $return_date, $fine_amount, $transaction_id);
    if(!$stmt->execute()){
        $err = $stmt->error;
        $stmt->close();
        $_SESSION['flash'] = "Error updating transaction: $err";
        header("Location: return.php?transaction_id=$transaction_id");
        exit;
    }
    $stmt->close();

    // Increase book quantity by 1 (atomic with simple UPDATE)
    $update_book = $conn->prepare("UPDATE books SET quantity = quantity + 1 WHERE id = ?");
    $update_book->bind_param("i", $tx['book_id']);
    if(!$update_book->execute()){
        // roll back the transaction update? (No transaction started here) — notify admin
        $err = $update_book->error;
        $_SESSION['flash'] = "Transaction updated but failed to update book quantity: $err";
        $update_book->close();
        header("Location: view_transactions.php");
        exit;
    }
    $update_book->close();

    $_SESSION['flash'] = "Book returned successfully. Overdue days: $overdue_days. Fine: {$fine_amount}";
    header("Location: view_transactions.php");
    exit;
}

// Show confirmation form (GET)
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Process Return</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
    <h1>Process Return for Transaction #<?php echo htmlspecialchars($transaction_id); ?></h1>
    <?php if(!empty($_SESSION['flash'])){ echo "<p style='background:#efe;padding:8px;border:1px solid #cfc;'>".htmlspecialchars($_SESSION['flash'])."</p>"; unset($_SESSION['flash']); } ?>
    <p><strong>Borrower:</strong> <?php echo htmlspecialchars($tx['borrower']); ?></p>
    <p><strong>Book:</strong> <?php echo htmlspecialchars($tx['book_title']); ?></p>
    <p><strong>Issue date:</strong> <?php echo htmlspecialchars($tx['issue_date']); ?></p>
    <p><strong>Due date:</strong> <?php echo htmlspecialchars($tx['due_date']); ?></p>
    <p><strong>Current status:</strong> <?php echo htmlspecialchars($tx['status']); ?></p>

    <form method="post" action="return.php">
        <input type="hidden" name="transaction_id" value="<?php echo $transaction_id; ?>">
        <label>Return date:
            <input type="date" name="return_date" required value="<?php echo date('Y-m-d'); ?>">
        </label><br><br>
        <button type="submit" name="confirm_return">Confirm Return</button>
        <a href="view_transactions.php">Cancel</a>
    </form>
</body>
</html>
