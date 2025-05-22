<?php
require_once __DIR__ . "/../../../app/controllers/RoomController.php";
use app\controllers\RoomController;

$images = new RoomController();

$displayRooms = $images->getImage();

?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <!-- Mobile Nav Toggle -->
  <div class="md:hidden flex justify-between items-center p-4 bg-white shadow">
    <h1 class="text-lg font-bold text-blue-600">Admin Panel</h1>
    <button id="mobile-menu-btn" class="text-gray-700 text-2xl focus:outline-none">&#9776;</button>
  </div>

  <!-- Wrapper -->
  <div class="flex flex-col md:flex-row min-h-screen">

    <!-- Sidebar -->
    <aside id="sidebar" class="bg-white w-64 shadow-md fixed md:relative z-30 top-0 left-0 h-full transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:block hidden">
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

    <!-- Main Content -->
    <main class="flex-1 md:ml-64 p-4 sm:p-6 lg:p-8">
      <h1 class="text-2xl font-bold mb-6 text-center md:text-left">Room Types</h1>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($displayRooms as $type): ?>
        <div class="relative group bg-white shadow-lg rounded-xl overflow-hidden transition transform hover:-translate-y-1">
       
          <?= htmlspecialchars($type['img_url']) ?>" 

          <div class="p-4">
            <h3 class="text-lg font-bold"><?= htmlspecialchars($type['type_name']) ?></h3>
            <p class="text-gray-600 text-sm"><?= htmlspecialchars($type['description']) ?></p>
            <p class="text-blue-600 font-semibold mt-2">₦<?= number_format($type['price']) ?>/night</p>
          </div>

          <!-- Tap & Hover Overlay Button -->
          <a href="/upload?room_id=<?= $type['id'] ?>" 
             class="absolute inset-0 bg-black bg-opacity-50 flex flex-col items-center justify-center text-white text-sm font-medium opacity-0 group-hover:opacity-100 group-focus:opacity-100 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v8m-4-4h8m-8-4h8" />
            </svg>
            Add More Images
          </a>
        </div>
        <?php endforeach; ?>
      </div>
    </main>
  </div>

  <!-- Toggle sidebar on mobile -->
  <script>
    const menuBtn = document.getElementById("mobile-menu-btn");
    const sidebar = document.getElementById("sidebar");

    menuBtn.addEventListener("click", () => {
      if (sidebar.classList.contains("translate-x-0")) {
        sidebar.classList.add("-translate-x-full");
        sidebar.classList.remove("translate-x-0");
      } else {
        sidebar.classList.remove("-translate-x-full");
        sidebar.classList.add("translate-x-0");
      }
    });
  </script>
</body>
</html>
