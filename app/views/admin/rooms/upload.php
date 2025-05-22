
<?php use app\controllers\RoomController;
require_once __DIR__ . "/../../../../app/controllers/RoomController.php";
 require_once __DIR__ . '/../../components/header.php'; 


$image = new RoomController();
$image->uploadImage();

?>

<div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow-md rounded-md">
  <h2 class="text-2xl font-bold mb-4 text-center">Upload Room Type Image</h2>

  <?php if (!empty($success)): ?>
    <p class="text-green-600 mb-4"><?= htmlspecialchars($success) ?></p>
  <?php endif; ?>

  <?php if (!empty($error)): ?>
    <p class="text-red-600 mb-4"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
  

    <div>
      <label for="image" class="block text-sm font-medium">Choose Image</label>
      <input type="file" name="images[]" id="image" multiple accept="image/*" required class="mt-1 block w-full border rounded-md p-2" />
    </div>

    <div class="text-center">
      <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded hover:bg-blue-700">Upload</button>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/../../components/footer.php'; ?>
