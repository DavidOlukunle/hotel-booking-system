<?php
namespace app\models;

use app\core\Database;
use PDOException;

require_once __DIR__ . "/../core/Database.php";



class Admin
{
    private $pdo;
    public $roomId;
    public $bookingsId;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    //update all bookings
    public function UpdateBookings($roomId, $bookingsId)
    {
        try {
            $this->pdo->beginTransaction();

            //getting the room id which is the room id , different from the room number which i used room_id for
            $stmt = $this->pdo->prepare("SELECT id from rooms WHERE room_number = ?");
            $stmt->execute([$roomId]);
            $room = $stmt->fetch(\PDO::FETCH_ASSOC);

            $roomDbId =$room['id'];
            //for updating the bookings table...this room_id is the room_number.
            $stmt = $this->pdo->prepare("UPDATE bookings SET room_id = ? , status = 'confirmed' WHERE id = ?");
            $stmt->execute([$roomId, $bookingsId]);

            // updating the room status to booked
            $stmt = $this->pdo->prepare("UPDATE rooms SET status = 'booked' WHERE id = ?");
            $stmt->execute([$roomDbId]);

            $this->pdo->commit();
            return true;

        } catch (PdoException $e) {
            $this->pdo->rollBack();
            error_log("failed" . $e->getMessage());
            $_SESSION['error'] = "Error assigning room: " . $e->getMessage();
            header("Location: ../admin/dashboard.php");
            exit;
        }
    }


   public function activityCheck()
{
    $today = date('Y-m-d');
    error_log("Today: $today");

    if (!isset($_SESSION)) session_start();
    if (!isset($_SESSION['activity_messages'])) {
        $_SESSION['activity_messages'] = [];
    }

    // Handle check-ins
    $checkInStmt = $this->pdo->prepare("SELECT bookings.id AS booking_id, rooms.room_number, users.name 
    FROM bookings 
    JOIN rooms ON bookings.room_type_id = rooms.room_type_id
    JOIN users ON bookings.user_id = users.id 
    WHERE DATE(bookings.check_in_date) = ? AND bookings.status ='confirmed'
    ");
    
   if (!$checkInStmt->execute([$today])) {
        error_log("Query error: " . print_r($checkInStmt->errorInfo(), true));
        return;
    }
    $checkIns = $checkInStmt->fetchAll(\PDO::FETCH_ASSOC);
    error_log("Fetched check-ins: " . print_r($checkIns, true));

    foreach ($checkIns as $booking) {
        $this->pdo->prepare("UPDATE bookings SET status = 'checked_in' WHERE id = ?")
                  ->execute([$booking['booking_id']]);

        $_SESSION['activity_messages'][] = "{$booking['name']} checked in to Room {$booking['room_number']}.";
    }

    // Handle check-outs
    $checkOutStmt = $this->pdo->prepare("SELECT bookings.id AS booking_id, rooms.id AS room_id, rooms.room_number, users.name 
        FROM bookings 
        JOIN rooms ON bookings.room_id = rooms.room_type_id 
        JOIN users ON bookings.user_id = users.id 
        WHERE bookings.check_out_date = ? AND bookings.status = 'checked_in'
    ");
    $checkOutStmt->execute([$today]);
    $checkOuts = $checkOutStmt->fetchAll(\PDO::FETCH_ASSOC);
   

    foreach ($checkOuts as $booking) {
        $this->pdo->prepare("UPDATE bookings SET status = 'checked_out' WHERE id = ?")
                  ->execute([$booking['booking_id']]);

        $this->pdo->prepare("UPDATE rooms SET status = 'available' WHERE id = ?")
                  ->execute([$booking['room_id']]);

        $_SESSION['activity_messages'][] = "{$booking['name']} checked out of Room {$booking['room_number']}.";
    }
    error_log("Activity check triggered");
}

    //updating the checkout status and room avalability
    public function processCheckOut($bookingid) {
        $stmt = $this->pdo->prepare("UPDATE bookings SET status = 'checked_out' WHERE id = ? ");
        $stmt->execute([$bookingid]);

        //updating room
        $roomId = $this->pdo->query("SELECT room_id FROM bookings WHERE id = $bookingid")->fetchColumn();

        $this->pdo->prepare("UPDATE rooms SET status = 'available' WHERE id = ? ")->execute([$roomId]);
        return true;
    }

   

    // checking activities
    public function getActivities(){
        $today = ('Y-m-d');

        //get all check ins today
       
        $stmt = $this->pdo->prepare("SELECT bookings.id, users.name as guest_name, rooms.room_number FROM bookings JOIN users ON bookings.user_id = users.id JOIN rooms ON bookings.room_id = rooms.id WHERE DATE(bookings.check_in_date) = :today AND bookings.status = 'confirmed'");
       $stmt->execute([':today' => $today]);
        $checkIns = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        //get all checkouts today

        $stmt = $this->pdo->prepare("SELECT bookings.id, users.name as guest_name, rooms.room_number FROM bookings JOIN users ON bookings.user_id = users.id JOIN rooms ON bookings.room_id = rooms.id WHERE DATE(bookings.check_in_date) = :today AND bookings.status = 'checked_in'");
        $stmt->execute([':today' => $today]);
        $checkOuts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return [
            'check_ins' => $checkIns,
            'check_outs' => $checkOuts
        ];
    
    }


}