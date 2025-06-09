<?php
namespace app\models;
use app\core\Database;
require_once __DIR__ . "/../core/Database.php";
use PDO;
use PdoException;

class PasswordReset{
    protected $pdo;

    public function __construct(){
         $this->pdo = Database::connect();
    }

    public function create($email, $token, $expiresAt){
        $stmt = $this->pdo->prepare("INSERT INTO password_resets(email, token, expires_at) VALUES(?, ?, ?)");
        return $stmt->execute([$email, $token, $expiresAt]);
    }

    public function findByToken($token){
        $stmt = $this->pdo->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()");
         $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function deleteByEmail($email){
        $stmt = $this->pdo->prepare("DELETE FROM password_resets WHERE email = ?");
        return $stmt->execute([$email]);
    }

}