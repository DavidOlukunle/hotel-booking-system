<?php
namespace app\models;
use app\core\Database;
require_once __DIR__ . "/../core/Database.php";
use PDO;
use PdoException;

class users {
    protected $id;
    protected $name;
    protected $email;
    protected $password;
    protected $phoneNumber;
    protected $role;
    private $pdo;
    private $created_at;

    public function __construct(){
        $this->pdo = Database::connect();
    }

    public function registerUser($name, $email,  $password, $role) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->pdo->prepare(
                "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)"
            );
            
            return $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':role' => $role
            ]);
        } catch (PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            return false;
        }
    }
   

    public function getUserByEmail($email) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->execute([':email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }

    public function loginUser($email, $password) {
        try{
            $stmt = $this->pdo->prepare("SELECT email, role, password, id, name FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' =>$user['name'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];
                return true;
            }
            return false;
        }
        catch(PdoException $e){
            error_log("Login error :" . $e->getMessage());
        }
    }

}