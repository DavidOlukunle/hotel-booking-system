<?php

namespace app\models;

use app\core\Database;
use PDOException;

require_once __DIR__ . "/../core/Database.php";

class Activities
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    //logging a new activity
    public function create($type, $message, $bookingId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO activities (type,message,is_read,booking_id,created_at) VALUES(?,?,0,?, NOW())");
        $stmt->execute([$type, $message, $bookingId]);
    }

    public function getUnreadActivities()
    {
        $stmt = $this->pdo->query("SELECT * FROM activities where is_read = 0 ORDER BY created_at DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function markAsRead($activityId)
    {
        $stmt = $this->pdo->prepare("
            UPDATE activities 
            SET is_read = 1 
            WHERE id = ?
        ");
        $stmt->execute([$activityId]);
    }
    public function cleanupOldActivities($days = 30)
    {
        $this->pdo->prepare("
            DELETE FROM activities 
            WHERE created_at < NOW() - INTERVAL ? DAY
        ")->execute([$days]);
    }
}
