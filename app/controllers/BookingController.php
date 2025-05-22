<?php
namespace app\controllers;
use app\models\Rooms;

use app\models\Bookings;
require_once __DIR__ . "/../models/Rooms.php";
require_once __DIR__ . "/../models/Bookings.php";

class BookingController{
  public $bookingModel;
  public $roomModel;
  
  public function __construct()
  {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }       
    $this->bookingModel = new Bookings();
     $this->roomModel = new Rooms();
  }

  public function storeBookings(){
      
    if($_SERVER['REQUEST_METHOD'] === "POST"){
     
        if (!isset($_SESSION['user']['id'])) {
         
            die("Error: Please login first");
           
        }
      
        $room_type_id = $_POST['room_type_id'];
      $user_id = $_SESSION['user']['id'];
    $check_in_date = $_POST['check_in_date'];
   $check_out_date = $_POST['check_out_date'];
   $status = $_POST['status'];
   $number_of_guests = $_POST['number_of_guests'];
   

   
           
      $result =$this->bookingModel->createBooking($room_type_id, $user_id,  $check_in_date,
   $check_out_date,
   $status,
   $number_of_guests,
  );
   
  $_SESSION['success'] = "Room successfully booked. view booking on your dashboard";
   
   header("Location: ../home.php");
  }
}

//catch all booking
public function getBookings(){
  return $this->bookingModel->fetchBooking();
}

//get bookings for individual users in their dashboard
public function getUserBookings(){
 if(!isset($_SESSION['user']['id'])){
  return "invalid";
 }
 return $this->bookingModel->fetchUserBooking($_SESSION['user']['id']);
  
}


    //get room  numbers

    public function getRoomNumber(){
        return $this->roomModel->fetchRooms();
    }
}
