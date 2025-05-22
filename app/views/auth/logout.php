<?php
use app\controllers\AuthController;
 require_once __DIR__ . "/../../../app/controllers/AuthController.php";

$auth = new AuthController();
$auth->logout();


