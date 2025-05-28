<?php 
use app\controllers\RoomController;
require_once __DIR__ . "/../../../../app/controllers/RoomController.php";
 require_once __DIR__ . '/../../components/header.php'; 

$update = new RoomController();
$roomid = $_GET['room_id'];
$rooms = $update->getRoom($roomid);

$update->updateRoom();




?>




    <div class="mt-5 bg-white shadow-md rounded-2xl p-8 max-w-lg w-full">
        <h2 class="text-2xl font-bold text-gray-700 mb-6 text-center">Edit Room Type</h2>

        <form action="" method="POST" class="space-y-5">

            <!-- Hidden ID -->
            
            <input type="hidden" name="id" value="<?= htmlspecialchars($rooms['id']) ?>">

            <!-- Type Name -->
            <div>
                <label for="type_name" class="block text-sm font-medium text-gray-600">Type Name</label>
                <input type="text" name="type_name" id="type_name"
                       value="<?= htmlspecialchars($rooms['type_name']) ?>"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-600">Description</label>
                <textarea name="description" id="description" rows="4"
                          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"><?= htmlspecialchars($rooms['description']) ?></textarea>
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-600">Price</label>
                <input type="text" name="price" id="price"
                       value="<?= htmlspecialchars($rooms['price']) ?>"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>


            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition">
                    Update Room Type
                </button>
            </div>
        </form>
    </div>

</body>
