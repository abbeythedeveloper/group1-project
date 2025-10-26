<?php
session_start();
include "db.php";

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == "user") {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM transactions WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        
        if (!$result) {
            echo "Error: {$conn->error}";
        }
    } else {
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library Transactions</title>
    <!-- ✅ Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center p-6">

    <div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl overflow-hidden">
        <header class="bg-green-600 text-white py-4 px-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold tracking-wide">Library Transactions</h1>
            <a href="logout.php" 
               class="bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-4 py-2 rounded-full transition">
                Logout
            </a>
        </header>

        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse">
                <thead class="bg-green-100 border-b border-green-300">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">User ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Book ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Issue Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Return Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (isset($result) && mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-sm text-gray-700 text-center"><?php echo htmlspecialchars($row['user_id']); ?></td>
                                <td class="px-6 py-3 text-sm text-gray-700 text-center"><?php echo htmlspecialchars($row['book_id']); ?></td>
                                <td class="px-6 py-3 text-sm text-gray-700 text-center"><?php echo htmlspecialchars($row['issue_date']); ?></td>
                                <td class="px-6 py-3 text-sm text-gray-700 text-center"><?php echo htmlspecialchars($row['return_date']); ?></td>
                                <td class="px-6 py-3 text-sm text-gray-700 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium 
                                        <?php echo ($row['status'] == 'returned') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                No transactions found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>