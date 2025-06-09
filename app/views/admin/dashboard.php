<?php
session_start();
include "components/nav.php";
require_once __DIR__ . "/../../../app/controllers/BookingController.php";
require_once __DIR__ . "/../../../app/controllers/AdminController.php";

use app\controllers\AdminController;

$activities = new AdminController();
$activities->checkBookingActivities();
$rooms = $activities->getCountedRoom();
$bookings =  $activities->getCountedBookings();
$users = $activities->getCountedUsers();


?>


      <!-- Overlay for mobile -->
      <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>

      <!-- Main Content -->
      <main class="flex-1 p-4 md:p-8 md:ml-64">
        <h1 class="text-2xl font-bold mb-6">Dashboard Overview</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Total Rooms</h2>
            <p class="text-3xl text-blue-600 mt-2"><?php echo htmlspecialchars($rooms) ?></p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Bookings</h2>
            <p class="text-3xl text-green-600 mt-2"><?php echo htmlspecialchars($bookings) ?></p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Users</h2>
            <p class="text-3xl text-purple-600 mt-2"><?php echo htmlspecialchars($users) ?></p>
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
        <!-- invite for guests -->
        <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Send Invite to Guest</h2>

    <form action="../controllers/InviteController.php" method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Check-in Date</label>
            <input type="date" name="check_in" required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Check-out Date</label>
            <input type="date" name="check_out" required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="text-center">
            <button type="submit"
                class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-700 transition duration-200">
                Send Invite
            </button>
        </div>
    </form>
</div>


      </main>
    </div>

    <!-- Toggle Sidebar Script -->
    <script src = "components/toggle.js">
     
    </script>
  </body>
</html>
