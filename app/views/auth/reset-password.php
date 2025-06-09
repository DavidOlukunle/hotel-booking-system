<?php

use app\controllers\ResetPasswordController;

require_once __DIR__ . "/../../../app/controllers/ResetPasswordController.php";
require_once '../components/header.php';

$reset = new ResetPasswordController();
$reset->resetPassword();

?>
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Reset password</h2>

<form method="post" action="" class = "space-y-5" >
    <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
    <div>
        <label class="block mb-1 text-gray-700"></label>
        <input type="password" name="password" required class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="please enter your new password">
    </div>
    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                reset password
            </button>
</form>
    </div>
</div>
</form>
