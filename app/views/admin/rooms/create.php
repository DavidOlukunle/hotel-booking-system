<!-- views/admin/manage_room_types.php -->

<?php
use app\controllers\RoomController;
require_once __DIR__ . "/../../../../app/controllers/RoomController.php";
 require_once __DIR__ . '/../../components/header.php'; 

$createRoom = new RoomController();

$createRoom->createRoomType();





?>

<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow mt-10">
  <h2 class="text-2xl font-semibold mb-6 text-gray-700">Add New Room Type</h2>

  <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
    <!-- Room Type Name -->
    <div>
      <label class="block text-gray-600 mb-1" for="name">Room Type Name</label>
      <input type="text" id="name" name="type_name" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. Deluxe Room" required>
    </div>

    <!-- Description -->
    <div>
      <label class="block text-gray-600 mb-1" for="description">Description</label>
      <textarea id="description" name="description" rows="4" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Short description of the room type" required></textarea>
    </div>

    <!-- Price -->
    <div>
      <label class="block text-gray-600 mb-1" for="price">Price per Night ($)</label>
      <input type="number" id="price" name="price" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01" required>
    </div>

    <div>
      <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Add Room Type</button>
    </div>
  </form>
</div>

<?php  require_once __DIR__ . '/../../components/header.php';  ?>
