<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        // Continue rendering page
    } else {
        header("Location: ../dashboard.php");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>

<?php 
include "../heading.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- ✅ Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-green-600 text-white px-6 py-4 flex justify-between items-center shadow-md">
        <h1 class="text-xl font-semibold">Admin Dashboard</h1>
        <div class="flex items-center space-x-4">
            <a href="view_trransactions.php" class="bg-white text-green-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-50 transition">
                View Transactions
            </a>
            <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                Logout
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center justify-center text-center p-6">
        <div class="bg-white shadow-lg rounded-2xl p-8 max-w-md w-full">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Welcome, Admin!</h2>
            <p class="text-gray-600 mb-6">
                You are logged in as <span class="font-medium text-green-700"><?php echo htmlspecialchars($_SESSION['role']); ?></span>.
            </p>
            <a href="view_trransactions.php" class="bg-green-600 hover:bg-green-700 text-white font-medium px-5 py-3 rounded-lg transition">
                Manage Transactions
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-200 text-gray-600 text-sm py-4 text-center">
        &copy; <?php echo date('Y'); ?> Library Management System. All rights reserved.
    </footer>

</body>
</html>
