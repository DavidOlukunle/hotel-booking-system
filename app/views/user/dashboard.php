<?php
session_start();
require_once __DIR__ . "/../../../app/controllers/BookingController.php";
use app\controllers\BookingController;
 $book = new BookingController();

$bookings = $book->getUserBookings();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

  <div class="flex flex-col md:flex-row">

    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-white shadow-md h-auto md:h-screen p-5">
      <h2 class="text-2xl font-bold text-indigo-600 mb-6">Dashboard</h2>
      <nav class="flex flex-col space-y-4">
        <a href="../user/bookings.php" class="text-gray-700 hover:text-indigo-600 transition">🏨 Bookings</a>
        <a href="" class="text-gray-700 hover:text-indigo-600 transition">👤 Profile</a>
        <a href="../user/chat.php" class="text-gray-700 hover:text-indigo-600 transition">💬 Chat</a>
        <a href="#" class="text-gray-700 hover:text-indigo-600 transition">🚪 Logout</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <h1 class="text-3xl font-semibold text-gray-800 mb-4">Welcome, <?php echo $_SESSION['user']['name']?>!</h1>

     
       
      <div class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <div class="bg-white p-4 rounded shadow">
          <!-- <?php if(is_array($bookings)) : ?> -->
          <?php foreach($bookings as $booking) : ?>
          <h3 class="text-lg font-bold text-gray-700 mb-2">Upcoming Booking</h3>
          <p class="text-sm text-gray-600">Type: <?= htmlspecialchars($booking['type_name'])?></p>
          <p class="text-sm text-gray-600">Check-in: <?php echo $booking['check_in_date']?></p>
          <p class="text-sm text-gray-600">Check-out: <?= htmlspecialchars($booking['check_out_date']) ?></p>
          <p class="text-sm text-gray-600">Status: <?php echo $booking['status'] ?></p>
          
        <?php endforeach; ?>
        <!-- <?php endif; ?>  -->


        </div>

       
      </div>
    </main>

  </div>

</body>
</html>
