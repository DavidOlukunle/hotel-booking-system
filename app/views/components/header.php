<?php
// Check if user is logged in
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$isLoggedIn = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paradise Hotel</title>


  <script src="https://cdn.tailwindcss.com"></script>

  
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<header class="bg-white shadow-md">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
    
    <div class="flex-shrink-0">
      <a href="/" class="text-2xl font-bold text-blue-600">ParadiseHotel</a>
    </div>

    
    <nav class="hidden md:flex space-x-8">
      <a href="../home.php" class="text-gray-600 hover:text-blue-600">Home</a>
      <a href="/rooms" class="text-gray-600 hover:text-blue-600">Rooms</a>
      <a href="/contact" class="text-gray-600 hover:text-blue-600">Contact</a>
      
      <?php if ($isLoggedIn): ?>
        <a href="../views/user/dashboard.php" class="text-gray-600 hover:text-blue-600">Dashboard</a>
        <a href="auth/logout.php" class="text-red-500 hover:text-red-700">Logout</a>
      <?php else: ?>
        <a href="../auth/login.php" class="text-gray-600 hover:text-blue-600">Login</a>
        <a href="../auth/register.php" class="text-blue-600 border border-blue-600 px-4 py-1 rounded hover:bg-blue-600 hover:text-white transition">Register</a>
      <?php endif; ?>
    </nav>

  
    <div class="md:hidden flex items-center">
      <button id="mobile-menu-button" class="text-gray-600 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Menu (hidden by default) -->
  <div id="mobile-menu" class="md:hidden hidden px-4 pt-2 pb-4 space-y-2 bg-white shadow">
    <a href="/" class="block text-gray-600 hover:text-blue-600">Home</a>
    <a href="/rooms" class="block text-gray-600 hover:text-blue-600">Rooms</a>
    <a href="/contact" class="block text-gray-600 hover:text-blue-600">Contact</a>
    
    <?php if ($isLoggedIn): ?>
      <a href="/user/dashboard" class="block text-gray-600 hover:text-blue-600">Dashboard</a>
      <a href="/logout" class="block text-red-500 hover:text-red-700">Logout</a>
    <?php else: ?>
      <a href="/login" class="block text-gray-600 hover:text-blue-600">Login</a>
      <a href="/register" class="block text-blue-600 border border-blue-600 px-4 py-1 rounded hover:bg-blue-600 hover:text-white transition">Register</a>
    <?php endif; ?>
  </div>

  <script>
    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    menuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>
</header>
