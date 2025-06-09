<?php
include "components/nav.php";
    require_once __DIR__ . "/../../../app/controllers/InviteController.php";
    require_once __DIR__ . "/../../../app/controllers/RoomController.php";
    
    use app\controllers\InviteController;
     use app\controllers\RoomController;

    $invite = new InviteController();

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $invite->sendInvite();
    }

    $room = new RoomController();
    $types = $room->getImage();
    

    
?>

       <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>
       <main class="flex-1 p-4 md:p-8 md:ml-64">
 <!-- invite for guests -->
               <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Send Invite to Guest</h2>

    <form action="" method="POST" class="space-y-4">
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

        <label class="block text-sm font-medium text-gray-700">select room type</label>
         <select name="room_type_id" class="border rounded px-2 py-1"> 
                                <?php if(is_array($types)) : ?>
                                <?php foreach($types as $type) : ?>
                                    <option value="<?= $type['id'] ?>"><?= $type["type_name"]?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                            </select>

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

      <script src = "components/toggle.js"></script>
    </body>
    </html>
    