<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
require 'db_config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Validate input
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Please fill all required fields!';
        return;
    }

    // Fetch the user from the database
    $stmt = $conn->prepare('SELECT id, password FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify the password
    if (password_verify($password, $hashed_password)) {
        session_start();
        $_SESSION['user_id'] = $id;
        header("Location: dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = 'Invalid email or password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen bg-cover bg-center" style="background-image: url('images/6379114.jpg');">
        <div class="bg-white bg-opacity-80 p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-3xl font-bold mb-4 text-center text-gray-800">Login</h2>
            <?php if(isset($_SESSION['error'])): ?>
                <div class="text-red-500 text-sm"><?php echo $_SESSION['error']; ?></div>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                    <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded py-2 px-3 focus:outline-none focus:border-blue-500" placeholder="Enter your email address">
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded py-2 px-3 focus:outline-none focus:border-blue-500" placeholder="Create a password">
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded focus:outline-none focus:bg-blue-600 hover:bg-blue-600 w-full">Login</button>
                </div>
                <div class="mt-4 text-center">
                    <a href="signup.php" class="text-blue-500 hover:text-blue-600 text-sm">Don't have an account? SignUp</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
