<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out</title>
    <!-- ✅ Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-xl rounded-2xl p-10 max-w-md w-full text-center">
        <!-- Logout Icon -->
        <div class="flex justify-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 fill="none" viewBox="0 0 24 24" 
                 stroke-width="1.5" stroke="currentColor" 
                 class="w-16 h-16 text-red-500">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M18 12H9m9 0l-3-3m3 3l-3 3" />
            </svg>
        </div>

        <!-- Message -->
        <h1 class="text-2xl font-bold text-gray-800 mb-2">You’ve been logged out</h1>
        <p class="text-gray-600 mb-6">
            Your session has ended successfully. Click below to sign in again.
        </p>

        <!-- Button -->
        <a href="login.php" 
           class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-3 rounded-lg transition duration-200">
            Go to Login
        </a>

        <!-- Footer Note -->
        <p class="text-gray-400 text-sm mt-8">
            &copy; <?php echo date("Y"); ?> Library Management System
        </p>
    </div>

</body>
</html>
