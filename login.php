<?php
include 'db.php';
session_start();
$message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Set session data
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on role
        if ($row['role'] === 'admin') {
            header("Location: admin/dashboard.php");
            exit;
        } else {
            header("Location: dashboard.php");
            exit;
        }
    } else {
        $message = "
            <div class='fixed bottom-5 left-1/2 transform -translate-x-1/2 
                        bg-red-100 border border-red-400 text-red-700 
                        px-6 py-3 rounded-lg shadow-lg z-50'>
                <strong class='font-semibold'>Error!</strong> Incorrect email or password ❌
            </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include "heading.php" ?>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<?php if (!empty($message)) echo $message; ?>

<form action="login.php" method="post" 
      class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md space-y-5">
  <h2 class="text-2xl font-bold text-center text-blue-600">Login 👋</h2>

  <div>
    <label class="block text-gray-700 mb-1 font-medium">Email</label>
    <input type="email" name="email" placeholder="Enter email" required
           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
  </div>

  <div>
    <label class="block text-gray-700 mb-1 font-medium">Password</label>
    <input type="password" name="password" placeholder="Enter password" required
           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
  </div>

  <button type="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition-all duration-200">
      Login
  </button>

  <p class="text-center text-gray-600 text-sm">
    Don't have an account?
    <a href="register.php" class="text-blue-600 hover:underline">Sign up.</a>
  </p>
</form>

<script>
  setTimeout(() => {
    const alert = document.querySelector('.fixed.bottom-5');
    if (alert) alert.remove();
  }, 4000);
</script>

</body>
</html>
