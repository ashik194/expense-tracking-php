<?php 

require 'db_config.php';
require 'all_query.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_expense'])) {
        $amount = $_POST['amount'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        $user_id = $_POST['user_id'];
        
        addExpenseItem($conn, $amount, $description, $date, $user_id, $category_id);

    }else if(isset($_POST['edit_expense'])) {
      $id = $_POST['id'];
      $amount = $_POST['amount'];
      $category_id = $_POST['category_id'];
      $description = $_POST['description'];
      $date = $_POST['date'];

      updateExpenses($conn, $id, $amount, $description, $date, $category_id);
    }else if(isset($_POST["delete_category"])){
      $id = $_POST['id'];
      deleteExpense($conn, $id);
    }
}

$all_expenses = getExpenses($conn);
$all_categories = getCategories($conn);

if(isset($_REQUEST['action']) && $_REQUEST['action'] == "getEdit" && isset($_REQUEST['id'])){
    $expense_id = $_REQUEST['id'];
    getSingleExpense($conn, $expense_id);
    exit;
}
?>
  <!-- Navbar -->
<?php include("layouts/header.php"); ?>

 <div class="flex gap-4 min-h-screen">
     <!-- Sidebar -->
  <?php include("layouts/sidebar.php");?>

  <!-- Main Content -->
  <div class="container mx-auto p-6">
    <div class="flex flex-col md:flex-row md:space-x-6">

      <!-- Add/Edit Expense Form -->
      <div class="bg-white shadow-md rounded-lg p-6 mb-6 md:mb-0 w-full md:w-1/3">
        <h2 class="text-xl font-bold mb-4">Add/Edit Expense</h2>
        <form id="expense-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
          <input type="hidden" name="add_expense" value="1">
          <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
          <div class="mb-4">
            <label for="amount" class="block text-gray-700">Amount</label>
            <input type="number" id="amount" class="w-full p-2 border border-gray-300 rounded mt-1" name="amount" >
          </div>
          <div class="mb-4">
            <label for="category_id" class="block text-gray-700">Category</label>
            <select id="category_id" class="w-full p-2 border border-gray-300 rounded mt-1" name="category_id">
              <?php foreach ($all_categories as $key => $category): ?>
                <option value="<?php echo htmlspecialchars($category['id']); ?>"><?php echo htmlspecialchars($category['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-4">
            <label for="description" class="block text-gray-700">Description</label>
            <textarea id="description" class="w-full p-2 border border-gray-300 rounded mt-1" name="description"></textarea>
          </div>
          <div class="mb-4">
            <label for="date" class="block text-gray-700">Date</label>
            <input type="date" id="date" class="w-full p-2 border border-gray-300 rounded mt-1" name="date">
          </div>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Expense</button>
        </form>
      </div>

      <!-- Expense List -->
      <div class="bg-white shadow-md rounded-lg p-6 w-full md:w-2/3">
        <h2 class="text-xl font-bold mb-4">Expenses</h2>
        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th class="py-2 px-2 text-left border-b">SL</th>
              <th class="py-2 px-2 text-left border-b">Date</th>
              <th class="py-2 px-2 text-left border-b">Amount</th>
              <th class="py-2 px-2 text-left border-b">Category</th>
              <th class="py-2 px-2 text-left border-b">Description</th>
              <th class="py-2 px-2 text-left border-b">Actions</th>
            </tr>
          </thead>
          <tbody id="expense-list">
            <?php foreach ($all_expenses as $key => $expense): ?>
            <tr>
              <td class="py-2 px-4 border-b"><?php echo $key+1 ?></td>
              <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($expense['date']); ?></td>
              <td class="py-2 px-4 border-b">$<?php echo htmlspecialchars($expense['amount']); ?></td>
              <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($expense['name']); ?></td>
              <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($expense['description']); ?></td>
              <td class="py-2 px-4 border-b">
                <button class="bg-green-500 text-white px-2 py-1 rounded expenseEdit" id="expenseEdit" data-id="<?php echo htmlspecialchars($expense['id']);?>">Edit</button>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST" class="inline-block">
                    <input type="hidden" name="delete_category" value="1">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($expense['id']); ?>">
                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                </form>
              </td>
            </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

  <?php include("layouts/footer.php");?>

  

  <div id="editExpenseModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white shadow-md rounded-lg p-6 w-1/3">
        <h2 class="text-xl font-bold mb-4">Edit Expense</h2>
        <form id="edit-expense-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
            <input type="hidden" name="edit_expense" value="1">
            <input type="hidden" id="expense_id" name="id" >
            <div class="mb-4">
                <label for="editAmount" class="block text-gray-700">Amount</label>
                <input type="text" id="editAmount" class="w-full p-2 border border-gray-300 rounded mt-1" name="amount" id="editAmount">
            </div>
            <div class="mb-4">
                <label for="edit-name" class="block text-gray-700">Category Name</label>
                <select id="editCategory" class="w-full p-2 border border-gray-300 rounded mt-1" name="category_id">
                  <?php foreach ($all_categories as $key => $category): ?>
                    <option value="<?php echo htmlspecialchars($category['id']); ?>"  id="cate<?php echo htmlspecialchars($category['id']);?>"><?php echo htmlspecialchars($category['name']); ?></option>
                  <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="editDescription" class="block text-gray-700">Description</label>
                <textarea id="editDescription" class="w-full p-2 border border-gray-300 rounded mt-1" name="description" id="editDescription"></textarea>
            </div>
            <div class="mb-4">
                <label for="editDate" class="block text-gray-700">Date</label>
                <input type="date" id="editDate" class="w-full p-2 border border-gray-300 rounded mt-1" name="date" id="editDate">
            </div>
            <div class="flex justify-end">
                <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded mr-2" onclick="closeModal()">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
  

  let expenseEditBtns = document.querySelectorAll(".expenseEdit");

expenseEditBtns.forEach(btn => {
  btn.addEventListener("click", function() {
    var expense_id = btn.getAttribute('data-id');
  console.log(expense_id);

  let url = new URL('http://localhost/web-programming-lab/project/expense-tracking.php', window.location.origin);
  url.searchParams.append('action', 'getEdit');
  url.searchParams.append('id', expense_id);

  fetch(url, {
    method: 'GET',
  })
.then(response => {return response.json()})
  .then(data => openEditModal(data))
  .catch(error => {
    console.error('Error:', error);
  });
});
});



  function openEditModal(data) {
      document.getElementById('expense_id').value = data.id;
      document.getElementById('editAmount').value = data.amount;
      // document.getElementById('editCategory').value = data.category_id;
      document.getElementById('editDescription').value = data.description;
      document.getElementById('editDate').value = data.date;
      let editCategory = document.getElementById('editCategory');
      Array.from(editCategory.options).forEach(option => {
        if (option.value == data.category_id) {
          option.selected = true;
        } else {
          option.selected = false;
        }
      });
      document.getElementById('editExpenseModal').classList.remove('hidden');
  }

  function closeModal() {
      document.getElementById('editExpenseModal').classList.add('hidden');
  }
</script>
</body>
</html>


  