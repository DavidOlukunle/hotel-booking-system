<?php

namespace app\controllers;

require_once __DIR__ . "/../core/Mailer.php";
require_once __DIR__ . "/../models/invite.php";
require_once __DIR__ . "/../models/users.php";
require_once __DIR__ . "/../models/Bookings.php";

use app\core\Mailer;
use app\models\Invite;
use app\models\users;
use app\models\Bookings;
use PDO;
use PdoException;



class InviteController
{
    private $mailerModel;
    private $inviteModel;
    public $bookingModel;
    public $userModel;
    private $pdo;

    public function __construct()
    {
        $this->mailerModel = new Mailer();
        $this->inviteModel = new Invite();
        $this->bookingModel = new Bookings();
        $this->userModel = new users();
    }

    public function sendInvite()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $check_in = $_POST['check_in'];
            $check_out = $_POST['check_out'];
            $room_type_id = $_POST['room_type_id'];



            // Generate unique token
            $token = bin2hex(random_bytes(16));

            $inviteLink = "http://localhost/HOTEL/app/views/confirm_invite.php?token=" . $token;


            $sent = $this->mailerModel->sendInvite($email, $name, $inviteLink);

            if ($sent === true) {

                $this->inviteModel->storeInvites($email, $name, $token, $check_in, $check_out, $room_type_id);
                // Redirect with success message
                header("Location: ../admin/invite.php?success=Invite sent successfully!");
            } else {
                // Redirect with error
                header("Location: ../admin/invite.php?error=" . urlencode($sent));
            }
        }
    }

    public function getInvite()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['token'])) {
            $token = $_GET['token'];
        } else {
            echo "invalid or no token.";
            exit;
        }

        $invite =  $this->inviteModel->fetchInvite($token);

        if (!$invite) {
            echo "Invalid or expired token";
            exit;
        }

        return $invite;
    }

    public function processInvite()
    {

         $token = $_GET['token'] ?? null;
        $password = $_POST['password'] ?? null;
        

        // if (!$token || !$password) {
        //     die("Missing token or password.");
        // }
        $invite = $this->inviteModel->fetchInvite($token);
        if (!$invite || $invite['status'] === 'accepted') {
            die("Invalid or expired invite.");
        }
        
        

        $name = $invite['name'];
        $email = $invite['email'];
        $check_in_date = $invite['check_in'];
        $check_out_date = $invite['check_out'];
         $room_type_id = $invite['room_type_id'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $status = "pending";
        $number_of_guests = 1;
        $registered_via_invite = 1;




       $user_id =  $this->userModel->registerUser($name, $email, $hashedPassword,  $registered_via_invite);
     
        $this->bookingModel->createBooking($room_type_id, $user_id,  $check_in_date, $check_out_date, $status, $number_of_guests, );
        $this->inviteModel->updateInvite($token);
    }
}
