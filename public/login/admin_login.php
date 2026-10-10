<?php
// Include the AuthController for admin login logic
require_once '../../src/controllers/AuthController.php';

// Start session at the top for consistent session management
session_start();

$authController = new AuthController();
$message = ''; // Initialize message variable to avoid undefined notices

// Generate CSRF token if not already set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token to prevent cross-site request forgery
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF validation failed");
    }
    // Check if all required fields are provided
    if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['password'])) {
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password']; // Hashing handled in AuthController
        // Call the method in AuthController to handle admin login
        $message = $authController->admin_login($name, $phone, $email, $password);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Skill India</title>
    <link href="../../src/css/tailwind.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  
  
</head>
<body class="bg-gradient-to-tl from-slate-500 via-slate-200 to-slate-500 flex items-center justify-center min-h-screen ">
    <div class="bg-white/50 p-8 rounded-xl shadow-2xl w-full max-w-md transform transition-transform duration-300">
        <h2 class="text-center mb-6 text-2xl font-bold text-blue-600 tracking-tight">Admin Login</h2>

        <?php if ($message): ?>
            <div x-data="{ showError: true }" x-show="showError" @click.away="showError = false" class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded animate-fade-in">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form class="space-y-6" method="POST" action="admin_login.php" aria-label="Admin Login Form">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" aria-label="Admin Name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" required>
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" title="Enter a 10-digit phone number" placeholder="Enter your phone number" aria-label="Admin Phone Number" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" required>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" aria-label="Admin Email" title="Enter a valid email address" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" required>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" aria-label="Admin Password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-md">
                Login
            </button>
        </form>
    </div>
</body>
</html>

