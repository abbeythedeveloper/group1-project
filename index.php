<?php
include "db.php";

$sql = "SELECT * FROM books";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching books: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Home Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Header -->
    <header class="bg-blue-700 text-white text-center py-5 shadow-md">
        <h1 class="text-3xl font-bold">📚 Library Home Page</h1>
    </header>

    <!-- Book Section -->
    <section class="max-w-6xl mx-auto p-6">
        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-2xl transition-shadow flex flex-col justify-between">
                    <div>
                        <img src="images/<?php echo htmlspecialchars($row['image']); ?>" 
                             alt="<?php echo htmlspecialchars($row['title']); ?>" 
                             class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h2 class="text-lg font-semibold text-blue-700 mb-1">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </h2>
                            <h3 class="text-sm text-gray-600 mb-1">
                                Author: <span class="font-medium"><?php echo htmlspecialchars($row['author']); ?></span>
                            </h3>
                            <p class="text-sm text-gray-600 mb-1">
                                ISBN: <span class="font-medium"><?php echo htmlspecialchars($row['isbn']); ?></span>
                            </p>
                            <p class="text-sm text-gray-600">
                                Quantity: <span class="font-medium"><?php echo htmlspecialchars($row['quantity']); ?></span>
                            </p>
                        </div>
                    </div>

                    <!-- Borrow Button -->
                    <div class="p-4 text-center border-t">
                        <a href="borrow.php?book_id=<?php echo urlencode($row['id']); ?>"
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-full shadow-md transition-transform transform hover:-translate-y-1 hover:shadow-lg">
                           📖 Borrow Book
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center text-gray-600 text-sm py-4 border-t mt-10">
        © Group 1 Web Application — Online Library
    </footer>

</body>
</html>

