<?php
include "components/nav.php";
require_once __DIR__ . "/../../../app/controllers/AuthController.php";

use app\controllers\AuthController;

require_once __DIR__ . "/../../../app/controllers/AdminController.php";

use app\controllers\AdminController;

$auth = new AuthController();
$users = $auth->getAllUsers();

$adminTogggle = new AdminController();
$adminTogggle->setUserStatus();
?>


    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>
    
  <?php if (isset($_GET['success'])): ?>
    <p class="text-green-600"><?php echo $_GET['success']; ?></p>
<?php elseif (isset($_GET['error'])): ?>
    <p class="text-red-600"><?php echo $_GET['error']; ?></p>
<?php endif; ?>
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
                        <th class="px-4 py-2 text-left">Active</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($users)) : ?>
                        <?php foreach ($users as $user): ?>
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
                                    <span class="badge <?= $user['is_active'] ? 'badge-active' : 'badge-inactive' ?>">
                                        <?= $user['is_active'] ? 'Yes' : 'No' ?>
                                    </span>
                                </td>

                                <td class="px-4 py-2">
                                        <form method="POST" action="">
                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                <input type="hidden" name="current_status" value="<?= $user['is_active'] ?>">
                <button type="submit">
                    <?= $user['is_active'] ? 'Deactivate' : 'Activate' ?>
                </button>
            </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>


    <script>
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;

            fetch(`../admin/users.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${userId}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert(`User is now ${data.new_status == 1 ? 'active' : 'inactive'}`);
                        location.reload(); // or update button text dynamically
                    }
                });
        });
    });
</script>
  <script src = "components/toggle.js">
     
    </script>

</body>




</html>