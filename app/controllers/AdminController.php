<?php

namespace app\controllers;

use app\models\Rooms;
use app\models\Admin;
use app\models\Activities;
use app\models\Bookings;
use app\models\users;

require_once __DIR__ . "/../models/Rooms.php";
require_once __DIR__ . "/../models/Bookings.php";
require_once __DIR__ . "/../models/Admin.php";
require_once __DIR__ . "/../models/Activities.php";
require_once __DIR__ . "/../models/users.php";


class AdminController
{
    public $roomModel;
    public $bookingModel;
    public $adminModel;
    public $userModel;
    private $activityModel;

    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $this->adminModel = new Admin();
        $this->activityModel = new Activities();
        $this->userModel = new users();
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

    public function checkBookingActivities()
    {
        $this->adminModel->activityCheck();
    }

    //get counted room

    public function getCountedRoom()
    {
        return $this->adminModel->countRoom();
    }

    //get total number of bookings

    public function getCountedBookings()
    {
        return $this->adminModel->countBookings();
    }

    //get all user count
    public function getCountedUsers()
    {
        return $this->adminModel->countUsers();
    }

    //update user status
    public function setUserStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $user_id = $_POST['user_id'];
            $currentStatus = $_POST['current_status'] ?? null;

            if ($user_id !== null && $currentStatus !== null) {
                $newStatus = $currentStatus == 1 ? 0 : 1;
                $this->userModel->updateStatus($user_id, $newStatus);
                header("Location: ../admin/users.php?success=status updated");
            }
        }
    }
}
