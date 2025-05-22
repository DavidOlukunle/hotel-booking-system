<?php

namespace app\controllers;

use app\models\Rooms;
use app\models\Admin;
use app\models\Activities;
use app\models\Bookings;

require_once __DIR__ . "/../models/Rooms.php";
require_once __DIR__ . "/../models/Bookings.php";
require_once __DIR__ . "/../models/Admin.php";
require_once __DIR__ . "/../models/Activities.php";


class AdminController
{
    public $roomModel;
    public $bookingModel;
    public $adminModel;
    private $activityModel;

    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $this->adminModel = new Admin();
        $this->activityModel = new Activities();
    }

    public function assignRoom()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $bookingsId = $_POST['booking_id'];
            $roomId = $_POST['room_id'];

            if ($this->adminModel->updateBookings($roomId, $bookingsId)) {
              
                $_SESSION['success'] = "Booking confirmed and room assigned successfully.";
                header("Location: ../admin/bookings.php");
                exit;
            }
        }
    }

    public function checkBookingActivities() {
    $this->adminModel->activityCheck();
}


}
