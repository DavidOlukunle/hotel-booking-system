<?php
namespace app\models;
use app\core\Database;
use PDOException;
require_once __DIR__ .  "/../core/Database.php";

class RoomsTypes{
    public $type_name;
    public $description;
    public $price;
    public $image;
    private $pdo;
    
    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function createRoomTypes($type_name, $description, $price){
        try{
            $stmt = $this->pdo->prepare("INSERT INTO room_types (type_name, description, price) VALUES(?, ?, ?)");
            $stmt->execute([$type_name, $description, $price]);
            return $this->pdo->lastInsertId();
        }
        catch(\PdoException $e){
            error_log("failed" . $e->getMessage());
        }
    }
    
    public function addMultipleImages(array $images) {
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

    // get Allimage
    public function showAllRoomTypes(){
        try{
            $stmt = $this->pdo->prepare("SELECT room_types.id, room_types.type_name, room_types.description, room_types.price, room_images.img_url, room_images.room_type_id  FROM room_types JOIN room_images ON room_types.id = room_images.room_type_id WHERE room_images.is_main = 1");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            error_log("failed" . $e->getMessage());
        }
    }



    // getting the image for the show.php
    public function getMainImage($roomTypeId){

        try{

        $roomTypeStmt = $this->pdo->prepare("SELECT img_url FROM room_images where room_type_id = ? AND is_main = 1 LIMIT 1");

        $roomTypeStmt->execute([$roomTypeId]);
        return $roomTypeStmt->fetch();
       
    }catch(PDOException $e){
        error_log("failed" . $e->getMessage());
    }
}

//getting the details for the show.php
    public function getRoomDetails($roomTypeId){

try{
    
    $roomDetails = $this->pdo->prepare("SELECT * FROM room_types WHERE id = ?");
    $roomDetails->execute([$roomTypeId]);
   return $roomDetails->fetch();


}catch(PDOException $e){
    error_log("failed" . $e->getMessage());
}
    }

//gallery images fetch

public function fetchGalleryImages($roomTypeId){
    $galleryStmt = $this->pdo->prepare("SELECT img_url FROM room_images WHERE room_type_id = ? AND is_main = 0");
$galleryStmt->execute([$roomTypeId]);
return $galleryStmt->fetchAll();
}

    
    
}
