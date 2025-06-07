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
    protected $registered_via_invite;
    private $created_at;

    public function __construct(){
        $this->pdo = Database::connect();
    }

    public function registerUser($name, $email,  $password, $role, $registered_via_invite = false)  {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->pdo->prepare(
                "INSERT INTO users (name, email, password, role, registered_via_invite) VALUES (:name, :email, :password, :role, :registered_via_invite)"
            );
            
            $success =  $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':role' => $role,
                ':registered_via_invite'=> $registered_via_invite
            ]);
            
            if($success){
                return $this->pdo->lastInsertId();
            }
            else{
                return false;
            }
            
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
        //revoked user 
        
        try{
            $stmt = $this->pdo->prepare("SELECT email, role, is_active, password, id, name FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($password, $user['password'])) {
               
                    
                
                
                session_start();
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' =>$user['name'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'is_active' => $user['is_active']
                ];
            
                return true;
               
        }
            return false;
        }
        catch(PdoException $e){
            error_log("Login error :" . $e->getMessage());
        }
    }

    //fetch all users
    public function fetchUsers(){
        try{
             $stmt = $this->pdo->query("SELECT * FROM users");
            
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PdoException $e){
        error_log("unable to fetch". $e->getMessage());
    }
        }
       

}