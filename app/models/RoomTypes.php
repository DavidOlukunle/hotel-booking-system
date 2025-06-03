<?php

namespace app\models;

use app\core\Database;
use PDOException;

require_once __DIR__ .  "/../core/Database.php";

class RoomsTypes
{
    public $type_name;
    public $description;
    public $price;
    public $image;
    private $pdo;
    private $roomNumbers;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function createRoomTypes($type_name, $description, $price, $roomNumbers)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO room_types (type_name, description, price) VALUES(?, ?, ?)");
            $stmt->execute([$type_name, $description, $price]);
            
            //get inserted room_type_id
            $room_type_id = $this->pdo->lastInsertId();
            
           // Process room numbers
        $numbers = explode(',', $roomNumbers);
        $stmtRoom = $this->pdo->prepare("INSERT INTO rooms (room_number, room_type_id) VALUES (?, ?)");

        foreach ($numbers as $num) {
            $cleanedNum = trim($num);
            if (!empty($cleanedNum)) {
                $stmtRoom->execute([$cleanedNum, $room_type_id]);
            }
        }
         return $room_type_id;
        } catch (\PdoException $e) {
            error_log("failed" . $e->getMessage());
        }
    }

    public function addMultipleImages(array $images)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO room_images (room_type_id, img_url) 
            VALUES (:room_type_id, :img_url)
        ");

        $this->pdo->beginTransaction();

        try {
            foreach ($images as $image) {
                $stmt->execute([
                    ':room_type_id' => $image['room_type_id'],
                    ':img_url' => $image['img_url']
                ]);
            }

            return $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

   

    // get All roomtypes
    public function showAllRoomTypes()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT room_types.id, room_types.type_name, room_types.description, room_types.price, room_images.img_url, room_images.room_type_id  FROM room_types JOIN room_images ON room_types.id = room_images.room_type_id WHERE room_images.is_main = 1");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("failed" . $e->getMessage());
        }
    }

    public function fetchLimitedRooms()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT room_types.id, room_types.type_name, room_types.description, room_types.price, room_images.img_url, room_images.room_type_id  FROM room_types JOIN room_images ON room_types.id = room_images.room_type_id WHERE room_images.is_main = 1 LIMIT 3");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("failed" . $e->getMessage());
        }
    }



    // getting the image for the show.php
    public function getMainImage($roomTypeId)
    {

        try {

            $roomTypeStmt = $this->pdo->prepare("SELECT img_url FROM room_images where room_type_id = ? AND is_main = 1 LIMIT 1");

            $roomTypeStmt->execute([$roomTypeId]);
            return $roomTypeStmt->fetch();
        } catch (PDOException $e) {
            error_log("failed" . $e->getMessage());
        }
    }

    //getting the details for the show.php
    public function getRoomDetails($roomTypeId)
    {

        try {

            $roomDetails = $this->pdo->prepare("SELECT * FROM room_types WHERE id = ?");
            $roomDetails->execute([$roomTypeId]);
            return $roomDetails->fetch();
        } catch (PDOException $e) {
            error_log("failed" . $e->getMessage());
        }
    }

    //gallery images fetch

    public function fetchGalleryImages($roomTypeId)
    {
        $galleryStmt = $this->pdo->prepare("SELECT img_url FROM room_images WHERE room_type_id = ? AND is_main = 0");
        $galleryStmt->execute([$roomTypeId]);
        return $galleryStmt->fetchAll();
    }



    //fetch room byid
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM room_types WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

     //update room type information
    public function updateRoomType($id, $type_name, $description, $price)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE room_types SET type_name = :type_name, description = :description, price = :price WHERE id = :id ");
            return $stmt->execute([
                ':type_name' => $type_name,
                ':description' => $description,
                ':price' => $price,
                ':id' => $id

            ]);
        } catch (PdoException $e) {
            error_log("update failed" . $e->getMessage());
        }
    }
}
