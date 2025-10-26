<?php
session_start();
include "db.php";

if (isset($_GET['book_id'])) {
    $book_id = mysqli_real_escape_string($conn, $_GET['book_id']);
} else {
    die("<div class='text-center mt-10 text-red-600 font-semibold'>Invalid request — no book selected.</div>");
}

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];

    if ($role === "user") {
        // Insert transaction
        $sql = "INSERT INTO transactions (user_id, book_id, issue_date, status)
                VALUES ('$user_id', '$book_id', CURDATE(), 'borrowed')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Update book quantity
            $sql2 = "UPDATE books 
                     SET quantity = quantity - 1 
                     WHERE id = '$book_id' AND quantity > 0";
            $result2 = mysqli_query($conn, $sql2);

            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Borrow Book Confirmation</title>
                <script src="https://cdn.tailwindcss.com"></script>
            </head>
            <body class="bg-gray-50 flex items-center justify-center min-h-screen">
                <div class="bg-white shadow-lg rounded-lg p-8 text-center max-w-md">
                    <h1 class="text-2xl font-bold text-blue-700 mb-4">✅ Borrow Request Sent!</h1>
                    <p class="text-gray-700 mb-6">
                        Your request to borrow this book has been sent to the librarian.
                    </p>
                    <a href="index.php"
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-full shadow-md transition-transform transform hover:-translate-y-1">
                       ← Go Back to Home
                    </a>
                </div>
            </body>
            </html>
            <?php
        } else {
            echo "<div class='text-center mt-10 text-red-600 font-semibold'>
                    ❌ Error: {$conn->error}
                  </div>";
        }
    } else {
        header("Location: admin/dashboard.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>