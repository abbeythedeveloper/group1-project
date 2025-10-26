<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    $result = mysqli_query($conn, $sql);

if ($result) {
    $message = "
    <div class='fixed bottom-5 left-1/2 transform -translate-x-1/2 
                bg-green-100 border border-green-400 text-green-700 
                px-6 py-3 rounded-lg shadow-lg z-50'>
        <strong class='font-semibold'>Success!</strong> Registration successful 🎉
    </div>";
} else {
    $message = "
    <div class='fixed bottom-5 left-1/2 transform -translate-x-1/2 
                bg-red-100 border border-red-400 text-red-700 
                px-6 py-3 rounded-lg shadow-lg z-50'>
        <strong class='font-semibold'>Error!</strong> Unable to register user. Please try again.
    </div>";
}

}
?>

<!DOCTYPE html>
<html lang="en">
<?php include "heading.php" ?>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<?php if (!empty($message)) echo $message; ?>

  <form action="register.php" method="post" 
        class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md space-y-5">
    <h2 class="text-2xl font-bold text-center text-blue-600">Create Account</h2>

    <div>
      <label class="block text-gray-700 mb-1 font-medium">Username</label>
      <input type="text" name="username" placeholder="Enter username" required
             class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

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

    <input type="text" name="role" value="user" hidden>

    <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition-all duration-200">
      Sign Up
    </button>

    <p class="text-center text-gray-600 text-sm">
      Already have an account?
      <a href="login.php" class="text-blue-600 hover:underline">Log in</a>
    </p>
  </form>

  <script>
  setTimeout(() => {
    const alert = document.querySelector('.bg-green-100, .bg-red-100');
    if (alert) alert.style.display = 'none';
  }, 4000);
</script>

</body>
</html>