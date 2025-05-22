<?php
namespace app\controllers;
use app\models\users;
require_once __DIR__ . "/../models/users.php";

class AuthController{
   private $userModel;

   public function __construct()
   {
    $this->userModel = new users();
   }

   public function registerUser() {
    if($_SERVER['REQUEST_METHOD'] === "POST") {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $role = $_POST['role'];
   


        if($user = $this->userModel->registerUser($name, $email,  $password, $role)){
            
            session_start();
            $_SESSION['user'] =[
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ];

    header("Location: ../home.php");
    exit;

        }
        else{
            echo 'failed';
        }
        
    }
   }

   public function loginUser(){
    
    if(isset($_SESSION['user'])){
        header("Location: ../home.php");
    }

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $email = $_POST['email'];
        $password = $_POST["password"];
  

    if($this->userModel->loginUser($email, $password)){
   
        header("Location: ../home.php");
    }
    else{
        echo ":login failed";
    }
    }
    
    
   }

   public function logout() {
    session_start();
    session_destroy();
    header("Location: ../home.php");
   }
}