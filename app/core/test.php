<?php
namespace app\core;
use app\core\Database;
require_once __DIR__ . '/Database.php';


$pdo = Database::connect();
if ($pdo) {
    echo "✅ Database connection successful!";
} else {
    echo "❌ Database connection failed!";
}

