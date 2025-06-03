<?php

namespace app\controllers;

use app\models\RoomsTypes;

require_once __DIR__ . "/../models/RoomTypes.php";

class RoomController
{
    public $roomTypeModel;
    public $roomModel;

    public function __construct()
    {
        $this->roomTypeModel = new RoomsTypes();
    }

    public function createRoomType()
    {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $type_name   = $_POST['type_name'];
            $description = $_POST['description'];
            $price       = $_POST['price'];
            $roomNumber = $_POST['room_numbers'];

            if (empty($type_name) || empty($description) || empty($price)) {
                header("Location: ../admin/manage_room.php");
                exit;
            }

            $room_type_id = $this->roomTypeModel->createRoomTypes($type_name, $description, $price, $roomNumber);

            if ($room_type_id) {
                header("Location: ../rooms/upload.php?room_id=" . $room_type_id);
                exit;
            } else {
                $_SESSION['error'] = "Failed to create room type";
                header("Location: ../admin/manage_room.php");
                exit;
            }
        }
    }


    public function uploadImage()
    {
        if (! isset($_GET['room_id']) || ! is_numeric($_GET['room_id'])) {
            die("Invalid Room ID");
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST" && ! empty($_FILES['images'])) {
            $room_type_id   = filter_input(INPUT_GET, 'room_id', FILTER_VALIDATE_INT);
            $uploadedImages = [];
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    $targetDir  = '../public/uploads/rooms/';
                    $filename   = uniqid() . '_' . basename($_FILES['images']['name'][$key]);
                    $targetPath = $targetDir . $filename;

                    if (move_uploaded_file($tmp_name, $targetPath)) {
                        $uploadedImages[] = [
                            'room_type_id' => $room_type_id,
                            'img_url'      => $targetPath,
                        ];
                    }
                }
            }

            if (! empty($uploadedImages)) {
                try {
                    $success = $this->roomTypeModel->addMultipleImages($uploadedImages);
                    if ($success) {
                        $message = count($uploadedImages) . " images uploaded successfully!";
                    } else {
                        $error = "Images uploaded but database insert failed!";
                    }
                } catch (\PDOException $e) {
                    $error = "Database error: " . $e->getMessage();
                }
            }
        }
    }

    
    //get All roomtypes
    public function getImage()
    {
        return $this->roomTypeModel->showAllRoomTypes();
    }

    //get limited images for the home page
    public function getLimitedImages()
    {
        return $this->roomTypeModel->fetchLimitedRooms();
    }

    // images for the show.php
    public function getAll()
    {
        $roomTypeId = $_GET['id'] ?? null;

        if (! $roomTypeId) {
            die("Room type ID not provided.");
        }

        return $this->roomTypeModel->getMainImage($roomTypeId);
    }


    public function getDetails()
    {
        $roomTypeId = $_GET['id'] ?? null;

        if (!$roomTypeId) {
            die("Room Type ID not provided.");
        }

        return $this->roomTypeModel->getRoomDetails($roomTypeId);
    }

    //getting gallery images

    public function getGalleryImage()
    {
        $roomTypeId = $_GET['id'] ?? null;

        if (!$roomTypeId) {
            die("Room Type ID not provided.");
        }
        return $this->roomTypeModel->fetchGalleryImages($roomTypeId);
    }


    //get the room by id for the edit page

    public function getRoom($id)
    {
        if (!isset($_GET['room_id'])) {
    die("Room ID not provided.");
}
        return $this->roomTypeModel->getById($id);
       
    }

    //update room

    public function updateRoom(){
        if ($_SERVER['REQUEST_METHOD'] === "POST"){
            $id = $_POST['id'] ?? null;
            $type_name = trim($_POST['type_name'] ?? "");
            $description = trim($_POST['description'] ?? "");
            $price = trim($_POST['price'] ?? "");

            if(!$id || !$type_name || !$description || !$price){
                die("all fields are required");
            }
            $success = $this->roomTypeModel->updateRoomType($id, $type_name, $description, $price);

            if($success){
                header("Location: ../room-types.php");
            }

        }
    }

}
