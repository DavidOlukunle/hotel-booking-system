<?php
    require_once __DIR__ . "/../../../app/controllers/BookingController.php";
    require_once __DIR__ . "/../../../app/controllers/AdminController.php";
    use app\controllers\AdminController;
    use app\controllers\BookingController;

    $book          = new BookingController();
    $updateBooking = new AdminController();

    $bookings = $book->getBookings();
    $rooms    = $book->getRoomNumber();

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $updateBooking->assignRoom();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <h1 class="text-3xl font-bold mb-4">Admin Dashboard</h1>

    <?php if (isset($_SESSION['success'])): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        <?php echo $_SESSION['success'];?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?php echo $_SESSION['error'];?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

    <table class="min-w-full bg-white border border-gray-300 shadow-md">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Booking ID</th>
                <th class="px-4 py-2">User</th>
               <th class="px-4 py-2">Room TypeID</th>
                <th class="px-4 py-2">Assigned Room</th>
                <th class="px-4 py-2">Guests</th>
                <th class="px-4 py-2">Check-in</th>
                <th class="px-4 py-2">Check-out</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr class="text-center border-t">
                    <td class="px-4 py-2"><?php echo $booking['id']?></td>
                    <td class="px-4 py-2"><?php echo htmlspecialchars($booking['name'])?><br><?php echo $booking['email']?></td>
                    <td class="px-4 py-2"><?php echo $booking['room_type_id']?><br><?php echo $booking['type_name']?></td>
                    <td class="px-4 py-2"><?php echo $booking['room_id'] ?? 'Unassigned'?></td>
                    <td class="px-4 py-2"><?php echo $booking['number_of_guests']?></td>
                    <td class="px-4 py-2"><?php echo $booking['check_in_date']?></td>
                    <td class="px-4 py-2"><?php echo $booking['check_out_date']?></td>
                    <td class="px-4 py-2 font-semibold"><?php echo ucfirst($booking['status'])?></td>
                    <td class="px-4 py-2">
                         <form action="" method="POST" class="flex flex-col gap-2">
                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']?>"> 

                            <select name="room_id" class="border rounded px-2 py-1">
                                <?php if(is_array($rooms)) : ?>
                                <?php foreach($rooms as $room) : ?>
                                    <option value="<?= $room['room_number'] ?>">Room<?= $room["room_number"]?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                            </select>

                            <select name="status" class="border rounded px-2 py-1">
                                <option <?php echo $booking['status'] == 'pending' ? 'selected' : ''?> value="pending">Pending</option>
                                <option <?php echo $booking['status'] == 'confirmed' ? 'selected' : ''?> value="confirmed">Confirmed</option>
                                <option <?php echo $booking['status'] == 'cancelled' ? 'selected' : ''?> value="cancelled">Cancelled</option>
                            </select>

                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Update</button>
                        </form> 
                    </td>
                </tr>
            <?php endforeach?>
        </tbody>
    </table>
</body>
</html>
