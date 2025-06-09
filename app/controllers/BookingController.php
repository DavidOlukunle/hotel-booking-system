<?php

namespace app\controllers;

use app\models\Rooms;

use app\models\Bookings;
use DateTime;

require_once __DIR__ . "/../models/Rooms.php";
require_once __DIR__ . "/../models/Bookings.php";

class BookingController
{
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

  public function storeBookings()
  {

    if ($_SERVER['REQUEST_METHOD'] === "POST") {

      if (!isset($_SESSION['user']['id'])) {

        die("Error: Please login first");
      }

      $room_type_id = $_POST['room_type_id'];
      $user_id = $_SESSION['user']['id'];
      $checkin = $_POST['checkin'];
      $checkout = $_POST['checkout'];
      $checkInDate = new DateTime($checkin);
      $checkOutDate = new DateTime($checkout);
      $status = $_POST['status'];
      $number_of_guests = $_POST['number_of_guests'];
      $price_per_night = $_POST['price_per_night'];
      $totalNights = $checkInDate->diff($checkOutDate)->days;
      $totalAmount = $totalNights * $price_per_night;
      $vat = $totalAmount * 0.075;
      $grandTotal = $totalAmount + $vat;




      $result = $this->bookingModel->createBooking(
        $room_type_id,
        $user_id,
        $checkin,
        $checkout,
        $status,
        $number_of_guests,
        $totalNights,
        $totalAmount,
        $vat,
        $grandTotal
      );

      $_SESSION['success'] = "Room successfully booked. view booking on your dashboard";

      header("Location: ../home.php");
    }
  }

  //catch all booking
  public function getBookings()
  {
    return $this->bookingModel->fetchBooking();
  }

  //get bookings for individual users in their dashboard
  public function getUserBookings()
  {
    if (!isset($_SESSION['user']['id'])) {
      return "invalid";
    }
    return $this->bookingModel->fetchUserBooking($_SESSION['user']['id']);
  }


  //get room  numbers

  public function getRoomNumber()
  {
    return $this->roomModel->fetchAllRooms();
  }

  //get unassigned room number
  public function getUnassignedRoom()
  {
    return $this->roomModel->fetchUnassignedRoom();
  }
}
