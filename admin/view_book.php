<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("location: ../login.php");
} else {
   header("location: ../dashboard.php");
}

include "../db.php";

$sql = "SELECT * FROM books";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching books: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include "../heading.php"; ?>
<body class="bg-gray-50 min-h-screen p-6">
    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-2xl p-6">
        <h1 class="text-2xl font-bold text-center text-green-700 mb-6">📚 Library Books</h1>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-blue-600 text-white text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Author</th>
                        <th class="px-4 py-3 text-left">ISBN</th>
                        <th class="px-4 py-3 text-left">Image</th>
                        <th class="px-4 py-3 text-left">Quantity</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-700">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="hover:bg-blue-200 transition-colors">
                            <td class="px-4 py-3 font-medium"><?php echo htmlspecialchars($row['title']); ?></td>
                            <td class="px-4 py-3"><?php echo htmlspecialchars($row['author']); ?></td>
                            <td class="px-4 py-3"><?php echo htmlspecialchars($row['isbn']); ?></td>
                            <td class="px-4 py-3">
                                <?php if (!empty($row['image'])) { ?>
                                    <img src="../images/<?php echo htmlspecialchars($row['image']); ?>" 
                                         alt="Book cover" 
                                         class="w-16 h-20 object-cover rounded-md shadow-sm border">
                                <?php } else { ?>
                                    <span class="text-gray-400 italic">No image</span>
                                <?php } ?>
                            </td>
                            <td class="px-4 py-3 text-center"><?php echo htmlspecialchars($row['quantity']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
