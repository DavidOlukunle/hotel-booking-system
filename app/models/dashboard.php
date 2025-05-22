<?php
session_start();
require_once __DIR__ . "/../../../app/controllers/BookingController.php";
require_once __DIR__ . "/../../../app/controllers/AdminController.php";

use app\controllers\AdminController;

$activities = new AdminController();
$activities->checkBookingActivities();

echo '<pre>';
print_r($_SESSION['activity_messages']);
echo '</pre>';
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>

</head>

<body>



  <div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md">
      <div class="p-6 text-center border-b">
        <h2 class="text-xl font-bold text-blue-600">Admin Panel</h2>
      </div>
      <nav class="mt-6">
        <ul>
          <li><a href="/admin" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Dashboard</a></li>
          <li><a href="../admin/room-types.php" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Room Types</a></li>
          <li><a href="/admin/rooms" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Rooms</a></li>
          <li><a href="../admin/bookings.php" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Bookings</a></li>
          <li><a href="/admin/users" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Users</a></li>
          <li><a href="/logout" class="block px-6 py-3 text-red-600 hover:bg-red-100">Logout</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-8">
      <h1 class="text-2xl font-bold mb-6">Dashboard Overview</h1>

      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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

      <!-- activity panel -->

     <div class="activities-panel bg-white shadow-lg rounded-2xl p-6 max-w-2xl w-full mx-auto mt-6">
    <h3 class="text-2xl font-bold text-gray-800 mb-4">Today's Activities</h3>
    
  

<?php if (!empty($_SESSION['activity_messages'])): ?>
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4 shadow-md max-w-3xl mx-auto">
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
    <?php unset($_SESSION['activity_messages']); ?>
<?php endif; ?>

     </div>


      

    </main>

  </div>





</body>

</html>