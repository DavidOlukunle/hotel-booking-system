<?php
namespace app\models;
use app\core\Database;
use PDOException;
require_once __DIR__ . "/../core/Database.php";

class Bookings{
    public $check_in_date;
    public $check_out_date;
    public $status;
    public $number_of_guests;
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function createBooking($room_type_id, $user_id, $check_in_date, $check_out_date, $status, $number_of_guests){
        try{
            $stmt = $this->pdo->prepare("INSERT INTO bookings (room_type_id, user_id,  check_in_date, check_out_date, status, number_of_guests, created_at, updated_at) 
            VALUES(:room_type_id, :user_id,  :check_in_date, :check_out_date, :status, :number_of_guests, NOW(), NOW())");
             $result = $stmt->execute([

                'room_type_id' => $room_type_id,
                  'user_id' => $user_id,
                'check_in_date' => $check_in_date,
                'check_out_date'=> $check_out_date,
                'status'=> $status,
                'number_of_guests'=>$number_of_guests,
               
                
            ]);

              if (!$result) {
                // Get more detailed error info
                $errorInfo = $stmt->errorInfo();
                error_log("PDO Error: " . print_r($errorInfo, true));
                return false;
            }
            
            return true;
    
        }
        catch(PDOException $e){
            error_log("failed" . $e->getMessage());
        }
    }


    //view all bookings by admin

    public function fetchBooking(){
        try{
            $stmt = $this->pdo->query("SELECT users.name, users.email, bookings.id, bookings.room_type_id, bookings.user_id, bookings.check_in_date, bookings.check_out_date,  bookings.status, bookings.created_at, bookings.updated_at, bookings.number_of_guests, bookings.room_id, room_types.type_name  FROM bookings JOIN users ON bookings.user_id = users.id JOIN  room_types ON bookings.room_type_id = room_types.id  ");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(PdoException $e){
            error_log('could not fetch'. $e->getMessage());
        }
    }



    //single user boookings in the dashboard

    public function fetchUserBooking($userId){
        $userId = $_SESSION['user']['id'];
        try{
           
         $stmt = $this->pdo->prepare("SELECT users.name, users.email, bookings.id, bookings.room_type_id, bookings.user_id, bookings.check_in_date, bookings.check_out_date,  bookings.status, bookings.created_at, bookings.updated_at, bookings.number_of_guests, bookings.room_id, room_types.type_name  FROM bookings JOIN users ON bookings.user_id = users.id JOIN  room_types ON bookings.room_type_id = room_types.id WHERE users.id = ? ");
         $stmt->execute([$userId]);  
         return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(PdoException $e){
            error_log('could not fetch'. $e->getMessage());
        }
    }
}