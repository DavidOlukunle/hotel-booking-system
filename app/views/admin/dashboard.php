<?php
session_start();
require_once __DIR__ . "/../../../app/controllers/BookingController.php";
require_once __DIR__ . "/../../../app/controllers/AdminController.php";

use app\controllers\AdminController;

$activities = new AdminController();
$activities->checkBookingActivities();


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-100">

    <!-- Mobile Nav Toggle -->
    <div class="md:hidden flex justify-between items-center p-4 bg-white shadow">
      <h1 class="text-lg font-bold text-blue-600">Admin Panel</h1>
      <button id="mobile-menu-btn" class="text-gray-700 text-2xl focus:outline-none">
        &#9776;
      </button>
    </div>

    <div class="flex min-h-screen">
      <!-- Sidebar -->
      <aside id="sidebar" class="bg-white w-64 shadow-md hidden md:block md:relative fixed md:static z-30 inset-y-0 left-0 transform md:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="p-6 text-center border-b">
          <h2 class="text-xl font-bold text-blue-600">Admin Panel</h2>
        </div>
        <nav class="mt-6">
          <ul>
            <li><a href="/admin" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Dashboard</a></li>
            <li><a href="../admin/room-types.php" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Room Types</a></li>
            <li><a href="../admin/rooms.php" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Rooms</a></li>
            <li><a href="../admin/bookings.php" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Bookings</a></li>
            <li><a href="/admin/users" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Users</a></li>
            <li><a href="/logout" class="block px-6 py-3 text-red-600 hover:bg-red-100">Logout</a></li>
          </ul>
        </nav>
      </aside>

      <!-- Overlay for mobile -->
      <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>

      <!-- Main Content -->
      <main class="flex-1 p-4 md:p-8 md:ml-64">
        <h1 class="text-2xl font-bold mb-6">Dashboard Overview</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Total Rooms</h2>
            <p class="text-3xl text-blue-600 mt-2">30</p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Bookings</h2>
            <p class="text-3xl text-green-600 mt-2">12</p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Users</h2>
            <p class="text-3xl text-purple-600 mt-2">8</p>
          </div>
        </div>

        <!-- Activities Panel -->
        <div class="activities-panel bg-white shadow-lg rounded-2xl p-6 w-full max-w-3xl mx-auto mt-6">
          <h3 class="text-2xl font-bold text-gray-800 mb-4">Today's Activities</h3>

          <?php if (!empty($_SESSION['activity_messages'])): ?>
          <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4 shadow-md">
            <h3 class="font-bold mb-2">Today Activities</h3>
            <ul class="list-disc list-inside space-y-1">
              <?php foreach ($_SESSION['activity_messages'] as $message): ?>
              <li><?= htmlspecialchars($message) ?></li>
              <?php endforeach; ?>
            </ul>
            <button onclick="this.parentElement.remove();" 
                    class="absolute top-0 right-0 mt-2 mr-3 text-xl text-blue-600 hover:text-red-600" 
                    title="Dismiss">&times;</button>
          </div>
          <?php endif; ?>
        </div>
      </main>
    </div>

    <!-- Toggle Sidebar Script -->
    <script>
      const mobileMenuBtn = document.getElementById('mobile-menu-btn');
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');

      mobileMenuBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('hidden');
        overlay.classList.toggle('hidden');
      });

      overlay?.addEventListener('click', () => {
        sidebar.classList.add('hidden');
        overlay.classList.add('hidden');
      });
    </script>
  </body>
</html>
