<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("location: ../login.php");
        include '../db.php';

        $alert = ''; // variable to hold feedback message

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $isbn = $_POST['isbn'];
        $image = $_FILES['image']['name'];
        $quantity = $_POST['quantity'];

         // Save to database
            $sql = "INSERT INTO books (title, author, isbn, image, quantity) 
            VALUES ('$title', '$author', '$isbn', '$image', '$quantity')";
             $result = mysqli_query($conn, $sql);

        if (!$result) {
            $alert = "<div id='alert-box' class='bg-red-100 border border-red-400   text-red-700 px-4 py-3 rounded-lg mb-4 transition-opacity duration-700'>
                    <strong class='font-semibold'>Error:</strong> {$conn->error}
                  </div>";
        }else {
            // Move uploaded file
            $image_location = $_FILES['image']['tmp_name'];
            $upload_location = "../images/";
            move_uploaded_file($image_location, $upload_location . $image);

            $alert = "<div id='alert-box' class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 transition-opacity duration-700'>
                    <strong class='font-semibold'>Success!</strong> Book added successfully ✅
                  </div>";
        }
    }
}else {
    header("location: ../login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../heading.php'; ?>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <form 
        action="add_book.php" 
        method="post" 
        enctype="multipart/form-data"
        class="bg-white shadow-md rounded-2xl p-8 w-full max-w-md border border-gray-200 relative"
    >
        <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center">
            Add New Book
        </h2>

        <!-- Alert message (success or error) -->
        <?php if (!empty($alert)) echo $alert; ?>

        <div class="mb-4">
            <label for="title" class="block text-gray-600 font-medium mb-2">Book Title</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                required 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        <div class="mb-4">
            <label for="author" class="block text-gray-600 font-medium mb-2">Author</label>
            <input 
                type="text" 
                id="author" 
                name="author" 
                required 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        <div class="mb-4">
            <label for="isbn" class="block text-gray-600 font-medium mb-2">ISBN</label>
            <input 
                type="text" 
                id="isbn" 
                name="isbn" 
                required 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-600 font-medium mb-2">Book Cover Image</label>
            <input 
                type="file" 
                id="image" 
                name="image" 
                required 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 
                       file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm 
                       file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
            >
        </div>

        <div class="mb-6">
            <label for="quantity" class="block text-gray-600 font-medium mb-2">Number of Copies</label>
            <input 
                type="number" 
                id="quantity" 
                name="quantity" 
                required 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        <button 
            type="submit" 
            class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition duration-200"
        >
            Add Book
        </button>
    </form>

    <script>
        // Auto-dismiss alert after 4 seconds
        const alertBox = document.getElementById('alert-box');
        if (alertBox) {
            setTimeout(() => {
                alertBox.classList.add('opacity-0');
                setTimeout(() => alertBox.remove(), 700); // remove after fade-out
            }, 4000);
        }
    </script>

</body>
</html>
