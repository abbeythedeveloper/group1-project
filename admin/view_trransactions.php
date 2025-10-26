<?php
session_start();
include "../db.php";

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

// Only admins can view transactions
if($_SESSION['role'] != "admin"){
    header("Location: ../dashboard.php");
    exit;
}

// Fetch all transactions
$sql = "SELECT * FROM transactions ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if(!$result){
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transactions</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Transactions</h1>
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">User ID</th>
                    <th class="py-3 px-6 text-left">Book ID</th>
                    <th class="py-3 px-6 text-left">Issue Date</th>
                    <th class="py-3 px-6 text-left">Return Date</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['id']); ?></td>
                        <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['user_id']); ?></td>
                        <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['book_id']); ?></td>
                        <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['issue_date']); ?></td>
                        <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['return_date']); ?></td>
                        <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['status']); ?></td>
                        <td class="py-3 px-6 text-center space-x-2">
                            <!-- Update Button -->
                            <a href="update_transaction.php?transaction_id=<?php echo $row['id']; ?>" 
                               class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg text-xs">
                               Update
                            </a>

                            <!-- Delete Button -->
                            <a href="delete_transaction.php?transaction_id=<?php echo $row['id']; ?>" 
                               class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg text-xs"
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
