<?php
namespace app\models;
use app\core\Database;
use PDOException;
require_once __DIR__ .  "/../core/Database.php";




class Rooms{
private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function fetchRooms(){
      $stmt =  $this->pdo->query("SELECT rooms.id, rooms.room_number, rooms.status, room_types.type_name, room_types.price FROM rooms JOIN room_types ON rooms.room_type_id = room_types.id");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>

    
