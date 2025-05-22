<?php include '../components/header.php';


require_once __DIR__ . "/../../../app/controllers/RoomController.php";
require_once __DIR__ . "/../../../app/controllers/BookingController.php";
use app\controllers\BookingController;
use app\controllers\RoomController;

$images = new RoomController();
$booking = new BookingController();

$displayRooms = $images->getAll();
//  $details = $images->getDetails();
// $galleryImages = $images->getGalleryImage();






?>

<!-- Main Room Image -->
<div class="mb-6">
  <img src="/HOTEL/app/views/admin/public/<?= htmlspecialchars($displayRooms['img_url']) ?>" alt="Main Room Image" class="w-full h-96 object-cover rounded-md shadow-md">
</div>