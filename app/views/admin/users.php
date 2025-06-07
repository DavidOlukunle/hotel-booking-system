<?php
require_once __DIR__ . "/../../../app/controllers/AuthController.php";
use app\controllers\AuthController;

$auth = new AuthController();
$users = $auth->getAllUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin users</title>
     <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="p-4">
    <h2 class="text-2xl font-bold mb-4">All Registered Users</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Role</th>
                    <th class="px-4 py-2 text-left">Invite?</th>
                    <th class = "px-4 py-2 text-left">Active</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($users)) : ?>
                <?php foreach($users as $user): ?>
                <tr class="border-t hover:bg-gray-50">
                    <!--  -->
                 <td class="px-4 py-2"><?= htmlspecialchars($user['id']) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($user['name']) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($user['email']) ?></td>
                    <td class="px-4 py-2 capitalize"><?= htmlspecialchars($user['role']) ?></td>
                    <td class="px-4 py-2">
                        <?= $user['registered_via_invite'] ? '<span class="text-green-600">Yes</span>' : 'No' ?>
                    </td>
                     <td class="px-4 py-2">
                        <?= $user['is_active'] ? '<span class="text-green-600">Yes</span>' : 'No' ?>
                    </td>
                    <td class="px-4 py-2">
                        <a href="edit_user.php?id=<?= $user['id'] ?>" class="text-blue-600 hover:underline">Edit</a> |
                        <a href="delete_user.php?id=<?= $user['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>