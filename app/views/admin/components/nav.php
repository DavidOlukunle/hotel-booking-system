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
            <li><a href="../admin/dashboard.php" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Dashboard</a></li>
            <li><a href="../admin/room-types.php" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Room Types</a></li>
            <li><a href="../admin/rooms.php" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Rooms</a></li>
            <li><a href="../admin/bookings.php" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Bookings</a></li>
            <li><a href="../admin/invite.php" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Invite Guests</a></li>
            <li><a href="../admin/users.php" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Users</a></li>
            <li><a href="/logout" class="block px-6 py-3 text-red-600 hover:bg-red-100">Logout</a></li>
          </ul>
        </nav>
      </aside>