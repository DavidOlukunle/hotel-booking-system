<?php

use app\controllers\AuthController;

 require_once '../components/header.php'; 

require_once __DIR__ . "/../../../app/controllers/AuthController.php";

$auth = new AuthController();
$auth->loginUser();

?>

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Login to Paradise Hotel</h2>
        
        <form action="" method="POST" class="space-y-5">
            <div>
                <label class="block mb-1 text-gray-700">Email</label>
                <input type="email" name="email" required class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="you@example.com">
            </div>

            <div>
                <label class="block mb-1 text-gray-700">Password</label>
                <input type="password" name="password" required class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Login
            </button>

            <p class="text-center text-sm text-gray-600 mt-4">
                Don't have an account?
                <a href="../auth/register.php" class="text-blue-600 hover:underline">Register here</a>
            </p>
        </form>
    </div>
</div>

<?php require_once '../components/footer.php'; ?>
