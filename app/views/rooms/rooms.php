<?php
require_once __DIR__ . "/../../../app/controllers/RoomController.php";
require_once __DIR__ . "/../../../app/controllers/BookingController.php";
use app\controllers\BookingController;
use app\controllers\RoomController;

$images = new RoomController();

$displayRooms = $images->getImage();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View All Rooms</title>
  <link href="assets/css/tailwind.min.css" rel="stylesheet">
   <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <div class="max-w-7xl mx-auto p-6">
    <h2 class="text-3xl font-bold mb-6 text-center">All Available Rooms</h2>

    <!-- Filter Form -->
    <form method="POST" class="flex flex-wrap gap-4 justify-center mb-8">
      <select name="type" class="px-4 py-2 border rounded shadow">
        <option value="">All Types</option>
        <option value="Deluxe Room">Deluxe Room</option>
        <option value="Suite Room">Suite Room</option>
        <option value="Single Room">Single Room</option>
      </select>

      <input type="number" name="max_price" placeholder="Max Price" class="px-4 py-2 border rounded shadow">

      <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Filter
      </button>
    </form>

    <!-- Room Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
     <?php if(is_array($displayRooms)) : ?>
      <?php foreach($displayRooms as $room): ?>
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <img src ="/HOTEL/app/views/admin/public/<?= htmlspecialchars($room['img_url']) ?>" alt="Room Image" class="h-56 w-full object-cover">
        <div class="p-6">
          <h3 class="text-xl font-semibold mb-2"><?=htmlspecialchars(ucfirst($room['type_name'])) ?></h3>
          <h3 class="text-gray-600 mb-2"><?=htmlspecialchars(ucfirst($room['description'])) ?></h3>
          <p class="text-gray-600 mb-4">₦<?=htmlspecialchars(ucfirst($room['price'])) ?>/night</p>
          
            <a href="book.php?room=<?= urlencode($room['type_name']) ?>" class="inline-block mt-3 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
              Book Now
            </a>
          </div>
        </div>
      <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>
