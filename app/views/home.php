<!-- home.php -->
<?php
 include 'components/header.php';

require_once __DIR__ . "/../../app/controllers/RoomController.php";
use app\controllers\RoomController;

if (!isset($_SESSION['user']['id'])) {
  header("Location: ../login.php");
  exit();
}
$images = new RoomController();

$displayRooms = $images->getImage();

?>

<!-- Hero Section -->
<section class="relative bg-cover bg-center h-[80vh] flex items-center justify-center" style="background-image: url('/HOTEL/app/public/assets/hero.jpg');">
  <!-- Overlay -->
  <div class="absolute inset-0 bg-black bg-opacity-50"></div>

  <!-- Content -->
  <div class="relative text-center text-white px-4">
 
    <h1 class="text-4xl md:text-6xl font-bold mb-4">Welcome to Paradise Hotel</h1>
    <p class="text-lg md:text-2xl mb-6">Comfort that feels like home.</p>
    <a href="/rooms" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-md text-lg font-semibold">Explore Rooms</a>
  </div>
</section>

<!-- Rooms Preview Section -->
<section class="py-12 bg-gray-100">
  <div class="max-w-7xl mx-auto px-4">
    <h2 class="text-3xl font-bold text-center mb-10">Our Rooms</h2>

    
</div> 

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Example Room Card -->
      <?php if(is_array($displayRooms)) : ?>
      <?php foreach($displayRooms as $room): ?>
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <img src ="/HOTEL/app/views/admin/public/<?= htmlspecialchars($room['img_url']) ?>" alt="Room Image" class="h-56 w-full object-cover">
        <div class="p-6">
          <h3 class="text-xl font-semibold mb-2"><?=htmlspecialchars(ucfirst($room['type_name'])) ?></h3>
          <h3 class="text-gray-600 mb-2"><?=htmlspecialchars(ucfirst($room['description'])) ?></h3>
          <p class="text-gray-600 mb-4">₦<?=htmlspecialchars(ucfirst($room['price'])) ?>/night</p>
        <a href="../views/rooms/show.php?id=<?= $room['id']?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">View Details</a>
        </div>
      </div>
      <?php endforeach; ?>
      <?php endif; ?>
    </div> 

    <div class="text-center mt-12">
      <a href="/rooms" class="inline-block bg-gray-800 hover:bg-gray-900 text-white py-3 px-6 rounded-md">View All Rooms</a>
    </div>
  </div>
</section>

<!-- About Section -->
<section class="py-16">
  <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-10 items-center">
    <div>
      <h2 class="text-3xl font-bold mb-4">About Paradise Hotel</h2>
      <p class="text-gray-600 mb-6">
        Enjoy luxurious comfort with our premium rooms, 24/7 support, free Wi-Fi, and complimentary breakfast. Your satisfaction is our priority!
      </p>
      <a href="/about" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-md">Learn More</a>
    </div>
    <div>
      <img src="/public/assets/about.jpg" alt="About Hotel" class="rounded-lg shadow-lg">
    </div>
  </div>
</section>

<?php include 'components/footer.php'; ?>
