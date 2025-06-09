<?php
namespace app\controllers;
use app\models\PasswordReset;
use app\core\Mailer;
use app\models\Users;

require_once __DIR__ . "/../models/Users.php";
require_once __DIR__ . "/../models/PasswordReset.php";
require_once __DIR__ . "/../core/Mailer.php";

class ForgotPasswordController{

    private $mailerModel;
    private $resetModel;
    public $bookingModel;
    public $userModel;
    private $pdo;

    public function __construct(){
          $this->mailerModel = new Mailer();
        $this->resetModel = new PasswordReset();
       // $this->bookingModel = new Bookings();
        $this->userModel = new users();
    }

    public function sendResetEmail(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $email = $_POST['email'];
            
            $user = $this->userModel->getUserByEmail($email);

            

            if($user){
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

                $this->resetModel->create($email, $token, $expires);

                 $resetLink = "http://localhost/HOTEL/app/views/auth/reset-password.php?token=" . $token;

                  $this->mailerModel->sendResetEmail($email, $resetLink);

                

                    echo "email sent successfully";
                 }

               else{
                    echo "email not found";
                 }  

            }
            
            

        }
    }


