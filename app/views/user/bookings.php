<?php
 require_once __DIR__ . "/../../../app/controllers/BookingController.php";
    require_once __DIR__ . "/../../../app/controllers/AdminController.php";
    use app\controllers\AdminController;
    use app\controllers\BookingController;

$book = new BookingController();
$bookings = $book->getUserBookings();

    $updateBooking = new AdminController();

   


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="min-h-screen bg-gray-100 py-10 px-5">
  <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">Welcome, <?= $_SESSION['user']['name'] ?? 'Guest' ?> </h2>

    <!-- Flash Message -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
      </div>
    <?php endif; ?>

    <h3 class="text-xl font-semibold mb-3">My Bookings</h3>

    <div class="overflow-x-auto">
      <table class="min-w-full border text-sm text-gray-600">
        <thead class="bg-gray-200 text-gray-700 uppercase">
          <tr>
            <th class="py-3 px-4 text-left">Booking ID</th>
            <th class="py-3 px-4 text-left">Room Type</th>
            <th class="py-3 px-4 text-left">Room Number</th>
            <th class="py-3 px-4 text-left">Guests</th>
            <th class="py-3 px-4 text-left">Check-In</th>
            <th class="py-3 px-4 text-left">Check-Out</th>
            <th class="py-3 px-4 text-left">Status</th>
            <th class="py-3 px-4 text-left">Action</th>
          </tr>
        </thead>
        <tbody class="bg-white">
          <?php foreach ($bookings as $booking): ?>
            <tr class="border-t">
              <td class="py-2 px-4"><?= $booking['id'] ?></td>
              <td class="py-2 px-4"><?= $booking['type_name'] ?></td>
              <td class="py-2 px-4"><?= $booking['room_number'] ?? 'Pending' ?></td>
              <td class="py-2 px-4"><?= $booking['number_of_guests'] ?></td>
              <td class="py-2 px-4"><?= $booking['check_in_date'] ?></td>
              <td class="py-2 px-4"><?= $booking['check_out_date'] ?></td>
              <td class="py-2 px-4">
                <span class="px-2 py-1 text-xs rounded-full <?= $booking['status'] === 'confirmed' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' ?>">
                  <?= ucfirst($booking['status']) ?>
                </span>
              </td>
              <td class="py-2 px-4">
                <a href="view-booking.php?id=<?= $booking['id'] ?>" class="text-blue-600 hover:underline">View</a>
                
                  <form action="" method="POST" class="inline-block ml-2">
                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                    <button type="submit" class="text-red-600 hover:underline">Cancel</button>
                  </form>
              
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
