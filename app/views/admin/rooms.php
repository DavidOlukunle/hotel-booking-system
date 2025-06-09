<?php
include "components/nav.php";
 require_once __DIR__ . "/../../../app/controllers/BookingController.php";
 use app\controllers\BookingController;

 $room = new BookingController();
  $book = new BookingController();

  $booking = $book->getBookings();
 $roomDetails = $room->getRoomNumber();
?>


<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>
 
    <div class="container mx-auto px-4 py-6">
  <h2 class="text-2xl font-bold mb-4">All Rooms</h2>

   <div>
     <a href="../admin/rooms/create.php" class="inline-block mt-3 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
              Add a new room number
            </a>
  </div>

  <div class="overflow-x-auto shadow rounded-lg border border-gray-200">
    <table class="min-w-full bg-white">
      <thead class="bg-gray-100 text-gray-700 text-sm font-semibold">
        <tr>
          <th class="px-4 py-3 text-left">Room Number</th>
          <th class="px-4 py-3 text-left">Room Type</th>
          <th class="px-4 py-3 text-left">Price</th>
          <th class="px-4 py-3 text-left">Status</th>
          <th class="px-4 py-3 text-left">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-600 text-sm divide-y divide-gray-200">
       
         <?php foreach($roomDetails as $room) : ?>
        <tr>
          <td class="px-4 py-3"><?= $room['room_number']?></td>
          <td class="px-4 py-3"><?=$room['type_name']?></td>
          <td class="px-4 py-3"><?=$room['price']?></td>
          <td class="px-4 py-3">
            <span class="inline-block px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
              <?=$room['status']?>
            </span>
          </td>
          <td class="px-4 py-3">
            <a href="#" class="text-blue-600 hover:underline text-sm">View</a>
          </td>
        </tr>
        <?php endforeach; ?>
   
      </tbody>
    </table>
  </div>
</div>

<script src = "components/toggle.js"></script>
 </body>
 </html>