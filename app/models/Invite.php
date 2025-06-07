<?php
namespace app\models;
use app\core\Database;
use PDOException;
require_once __DIR__ . "/../core/Database.php";

class Invite{
    private $pdo;
    public $name;
    public $email;
    public $password;
    public $check_in;
    public $check_out;
    public $token;


    public function __construct(){
        $this->pdo = Database::connect();
    }

    public function storeInvites( $email, $name, $token,  $check_in, $check_out, $room_type_id){
        try{
            $stmt = $this->pdo->prepare("INSERT INTO invites (email, name, token, check_in, check_out, room_type_id) VALUES (?, ?, ?, ?, ?, ? )");
            $stmt->execute([ $email, $name, $token, $check_in, $check_out, $room_type_id]);
        }
        catch(PdoException $e){
            error_log("could not store invite". $e->getMessage());
        }
    }

    public function fetchInvite($token){
        
        $stmt = $this->pdo->prepare("SELECT * FROM invites WHERE token = ? LIMIT 1");
         $stmt->execute([$token]);
         return $stmt->fetch();
    }

    //update invite status
    public function updateInvite($token){
        $stmt = $this->pdo->prepare("UPDATE invites SET status = 'accepted' WHERE token = ?");
        return $stmt->execute([$token]);
    }
}