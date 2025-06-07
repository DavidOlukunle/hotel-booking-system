<?php
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
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-100">

  <?php if (isset($_GET['success'])): ?>
    <p class="text-green-600"><?php echo $_GET['success']; ?></p>
<?php elseif (isset($_GET['error'])): ?>
    <p class="text-red-600"><?php echo $_GET['error']; ?></p>
<?php endif; ?>


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
            <li><a href="/admin" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Dashboard</a></li>
            <li><a href="../admin/room-types.php" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Room Types</a></li>
            <li><a href="../admin/rooms.php" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Rooms</a></li>
            <li><a href="../admin/bookings.php" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Bookings</a></li>
            <li><a href="../admin/invite.php" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Invite Guests</a></li>
            <li><a href="/admin/users" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Users</a></li>
            <li><a href="/logout" class="block px-6 py-3 text-red-600 hover:bg-red-100">Logout</a></li>
          </ul>
        </nav>
      </aside> 
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