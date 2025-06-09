<?php
include "components/nav.php";
require_once __DIR__ . "/../../../app/controllers/RoomController.php";
use app\controllers\RoomController;

$images = new RoomController();

$displayRooms = $images->getImage();

?>




<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>

    <!-- Main Content -->
   <main class="flex-1 md:ml-64 p-4 sm:p-6 lg:p-8">
  <h1 class="text-2xl font-bold mb-6 text-center md:text-left">Room Types</h1>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($displayRooms as $type): ?>
    <div class="relative bg-white shadow-lg rounded-xl overflow-hidden transition transform hover:-translate-y-1 group">

      <!-- Room Info -->
      <div class="p-4">
        <h3 class="text-lg font-bold"><?= htmlspecialchars($type['type_name']) ?></h3>
        <p class="text-gray-600 text-sm"><?= htmlspecialchars($type['description']) ?></p>
        <p class="text-blue-600 font-semibold mt-2">₦<?= number_format($type['price']) ?>/night</p>
      </div>

      <!-- Buttons Container -->
      <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 text-white text-sm font-medium 
                  bg-black bg-opacity-50 transition-opacity duration-300
                  opacity-100 md:opacity-0 md:group-hover:opacity-100">

        <!-- Add Images Button -->
        <a href="../admin/rooms/upload.php?room_id=<?= $type['id'] ?>" 
           class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-full shadow-md w-40 text-center">
          Add Images
        </a>

        <!-- Edit Images Button -->
        <a href="../admin/rooms/edit.php?room_id=<?= $type['id'] ?>" 
           class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full shadow-md w-40 text-center">
          Edit Room type
        </a>
      </div>

    </div>
    <?php endforeach; ?>
  </div>
  
    <div>
     <a href="../admin/rooms/create.php" class="inline-block mt-3 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
              Create  new room type
            </a>
  </div>
</main>

     

    </main>
  </div>

 
  <!-- Toggle sidebar on mobile -->
  <script src = "components/toggle.js">
     
    </script>
</body>
</html>
