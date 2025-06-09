<?php
namespace app\controllers;

use app\models\PasswordReset;
use app\models\users;

require_once __DIR__ . "/../models/users.php";
require_once __DIR__ . '/../models/PasswordReset.php';

class ResetPasswordController{
    private  $resetModel;
    private $userModel;

    public function __construct(){
        $this->resetModel = new PasswordReset();
        $this->userModel = new users();
    }

    public function resetPassword(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $token = $_POST['token'];
            $password = $_POST['password'];

            $resetData = $this->resetModel->findByToken($token);
            
            

            if($resetData){
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $this->userModel->updatePassword($resetData['email'], $hashedPassword);
                $this->resetModel->deleteByEmail($resetData['email']);

                header("Location: ../auth/login.php?success = password updated, please log in again ");

            }
            else{
                echo "invalid or expired token";
            }

        }
    }
}