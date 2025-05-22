<?php include '../components/header.php';


require_once __DIR__ . "/../../../app/controllers/RoomController.php";
require_once __DIR__ . "/../../../app/controllers/BookingController.php";
use app\controllers\BookingController;
use app\controllers\RoomController;

if (!isset($_SESSION['user']['id'])) {
  header("Location: ../auth/login.php");
  exit();
}

$images = new RoomController();
$booking = new BookingController();

$displayRooms = $images->getAll();
 $details = $images->getDetails();
$galleryImages = $images->getGalleryImage();

  $booking->storeBookings();


?>



<!-- Main Room Image -->
<div class="mb-6">
  <img src="/HOTEL/app/views/admin/public/<?= htmlspecialchars($displayRooms['img_url']) ?>" alt="Main Room Image" class="w-full h-96 object-cover rounded-md shadow-md">
</div>

<!-- Room Info -->
 
  <h2 class="text-2xl font-bold mb-2"><?= htmlspecialchars($details['type_name']) ?></h2>
<p class="text-gray-700 mb-4"><?= htmlspecialchars($details['description']) ?></p>
<p class="text-blue-600 font-semibold mb-6">₦<?= number_format($details['price']) ?>/night</p> 

<?php if (isset($_SESSION['user'])): ?>
  <a href="#bookingForm" class="inline-block bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md mt-4">
    Book Room
  </a>
<?php else: ?>
  <a href="/login.php" class="inline-block bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md mt-4">
    Login to Book
  </a>
<?php endif; ?>

<!-- Gallery -->
 <h3 class="text-xl font-semibold mb-4">Room Gallery</h3>
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"> 
  
  <?php foreach ($galleryImages as $image): ?>
    <img src="/HOTEL/app/views/admin/public/<?= htmlspecialchars($image['img_url']) ?>" alt="Gallery Image" class="w-full h-40 object-cover rounded-lg shadow">
  <?php endforeach; ?>
 
</div> 


<?php if (isset($_SESSION['user'])): ?>
  <div id="bookingForm" class="mt-10 bg-white shadow-md p-6 rounded-lg">
    <h3 class="text-xl font-semibold mb-4">Book This Room</h3>
    <form action="" method="POST" class="space-y-4">
      <input type="hidden" name="room_type_id" value="<?= htmlspecialchars($details['id']) ?>">
      <input type="hidden" name="status" value="pending">
      <input type="hidden" name="user_id" value="<?= isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '' ?>">
      <div>
        <label class="block mb-1">Check-in Date</label>
        <input type="date" name="check_in_date" required class="border rounded p-2 w-full">
      </div>
      <div>
        <label class="block mb-1">Check-out Date</label>
        <input type="date" name="check_out_date" required class="border rounded p-2 w-full">
      </div>
      <div>
        <label class="block mb-1">Number of Guests</label>
        <input type="number" name="number_of_guests" min="1" required class="border rounded p-2 w-full">
      </div>
      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Confirm Booking
      </button>
    </form>
  </div>
<?php endif; ?>

