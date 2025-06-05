<?php
require_once __DIR__ . "/../../app/controllers/InviteController.php";
use app\controllers\InviteController;

$test = new InviteController();
$invite = $test->getInvite();
$test->processInvite();

$token = $_GET['token'] ?? null;



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h2>Confirm Booking and Create Your Account</h2>
<form action="" method="POST">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($invite['email']); ?>" readonly><br><br>

    <label>Full Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($invite['name']); ?>" readonly><br><br>

    <label>Set Your Password:</label>
    <input type="password" name="password" required><br><br>

    <button type="submit">Confirm & Register</button>
</form>
</body>
</html>
