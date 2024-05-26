<?php
require 'db_config.php';
require 'all_query.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_category'])) {
        $name = $_POST['name'];
        addCategory($conn, $name);
    }else if(isset($_POST['edit_category'])){
        $id = $_POST['id'];
        $name = $_POST['name'];
        updateCategory($conn, $id, $name);
    }else if(isset($_POST['delete_category'])){
        $id = $_POST['id'];
        deketeCategory($conn, $id);
    }
}

$all_categories = getCategories($conn);
?>

  <!-- Navbar -->
<?php include("layouts/header.php"); ?>

 <div class="flex gap-4 min-h-screen">
     <!-- Sidebar -->
  <?php include("layouts/sidebar.php");?>

    <div class="container p-6">
        <div class="flex justify-between gap-8">
            <div class="flex-1 bg-white shadow-md rounded-lg p-6 mt-6">
                <h2 class="text-xl font-bold mb-4">Add Category</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
                    <input type="hidden" name="add_category" value="1">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Category Name</label>
                        <input type="text" id="name" class="w-full p-2 border border-gray-300 rounded mt-1" name="name" required>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Add Category</button>
                </form>
            </div>

            <div class="flex-1 bg-white shadow-md rounded-lg p-6 mt-6">
                <h2 class="text-xl font-bold mb-4">Categories</h2>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 text-left border-b">ID</th>
                            <th class="py-2 text-left border-b">Name</th>
                            <th class="py-2 text-left border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody id="category-list">
                        <?php foreach ($all_categories as $category): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($category['id']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($category['name']); ?></td>
                            <td class="py-2 px-4 border-b">
                                <button class="bg-green-500 text-white px-2 py-1 rounded" onclick="openEditModal('<?php echo $category['id']; ?>', '<?php echo htmlspecialchars($category['name']); ?>')">Edit</button>
                             <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST" class="inline-block">
                                <input type="hidden" name="delete_category" value="1">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($category['id']); ?>">
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                            </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include("layouts/footer.php"); ?>






<div id="editCategoryModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white shadow-md rounded-lg p-6 w-1/3">
        <h2 class="text-xl font-bold mb-4">Edit Category</h2>
        <form id="edit-category-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
            <input type="hidden" name="edit_category" value="1">
            <input type="hidden" id="edit-category-id" name="id" >
            <div class="mb-4">
                <label for="edit-name" class="block text-gray-700">Category Name</label>
                <input type="text" id="edit-name" class="w-full p-2 border border-gray-300 rounded mt-1" name="name">
            </div>
            <div class="flex justify-end">
                <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded mr-2" onclick="closeModal()">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Changes</button>
            </div>
        </form>
    </div>
</div>



<script>
function openEditModal(id, name) {
    document.getElementById('edit-category-id').value = id;
    document.getElementById('edit-name').value = name;
    document.getElementById('editCategoryModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('editCategoryModal').classList.add('hidden');
}
</script>

</body>
</html>
