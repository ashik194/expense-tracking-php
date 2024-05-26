<?php
require 'db_config.php';
require 'all_query.php';

$expenses = [];
$total_amount = 0.00;
$filter_criteria = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['filter_month'])) {
        $month = $_POST['month'];
        $expenses = getExpensesByMonth($conn, $month);
        $total_amount = array_sum(array_column($expenses, 'amount'));
        $filter_criteria = "Month: " . date("F", mktime(0, 0, 0, $month, 10));
    } elseif (isset($_POST['filter_date'])) {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $expenses = getExpensesByDateRange($conn, $start_date, $end_date);
        $total_amount = array_sum(array_column($expenses, 'amount'));
        $filter_criteria = "Date Range: " . $start_date . " to " . $end_date;
    }
}

?>

<?php include("layouts/header.php"); ?>

<div class="flex gap-4 min-h-screen">
    <!-- Sidebar -->
    <?php include("layouts/sidebar.php"); ?>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-6 mb-6" id="invoiceSection">
            <h2 class="text-xl font-bold mb-4">Invoice</h2>

            <div class="mb-6">
                <!-- <h3 class="text-lg font-semibold">Invoice Details</h3> -->
                <div class="pr-10 mt-2">
                    <div class="text-right">
                        <label for="invoice-date" class="block text-gray-700">Invoice Date</label>
                        <!-- <input type="date" id="invoiceDate" onload="getDate()" class="w-full p-2 border border-gray-300 rounded mt-1"> -->
                        <p id="invoiceDate" onload="getDate()"></p>
                    </div>
                    <!-- <div>
                        <label for="invoice-number" class="block text-gray-700">Invoice Number</label>
                        <input type="text" id="invoice-number" class="w-full p-2 border border-gray-300 rounded mt-1" value="INV-001" disabled>
                    </div> -->
                </div>
            </div>

            <div class="mb-6" id="nonPrint">
                <h3 class="text-lg font-semibold">Filter Expenses</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mb-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="month" class="block text-gray-700">Month</label>
                            <select id="month" name="month" class="w-full p-2 border border-gray-300 rounded mt-1">
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" name="filter_month" class="bg-blue-600 text-white px-4 py-2 rounded">Filter by Month</button>
                        </div>
                    </div>
                </form>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mb-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="start-date" class="block text-gray-700">Start Date</label>
                            <input type="date" id="start-date" name="start_date" class="w-full p-2 border border-gray-300 rounded mt-1">
                        </div>
                        <div>
                            <label for="end-date" class="block text-gray-700">End Date</label>
                            <input type="date" id="end-date" name="end_date" class="w-full p-2 border border-gray-300 rounded mt-1">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" name="filter_date" class="bg-blue-600 text-white px-4 py-2 rounded">Filter by Date</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold">Filtered Criteria</h3>
                <p class="text-gray-700"><?php echo htmlspecialchars($filter_criteria); ?></p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold">Expenses</h3>
                <table class="min-w-full bg-white mt-2">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Date</th>
                            <th class="py-2 px-4 border-b">Category</th>
                            <th class="py-2 px-4 border-b">Description</th>
                            <th class="py-2 px-4 border-b">Amount</th>
                        </tr>
                    </thead>
                    <tbody id="invoice-expenses">
                        <?php foreach ($expenses as $expense): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($expense['date']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($expense['category']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($expense['description']); ?></td>
                            <td class="py-2 px-4 border-b">$<?php echo htmlspecialchars(number_format($expense['amount'], 2)); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="py-2 px-4 border-b text-right font-bold">Total</td>
                            <td class="py-2 px-4 border-b font-bold" id="total-amount">$<?php echo number_format($total_amount, 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="text-right">
                <button class="bg-blue-600 text-white px-4 py-2 rounded no-print" onclick="printInvoice()">Print Invoice</button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include("layouts/footer.php"); ?>


<script type="text/javascript">
  function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [year, month, day].join('-');
        }

        // Set today's date as default
        document.addEventListener("DOMContentLoaded", function(){
            var today = new Date();
            var dateInput = document.getElementById('invoiceDate');
            dateInput.innerHTML = formatDate(today);
        });
  function printInvoice() {
    if(document.getElementById("invoiceDate").value !=""){
      document.getElementById("nonPrint").style.display = "none";
      const invoiceSection = document.getElementById('invoiceSection').innerHTML;

      const originalContents = document.body.innerHTML;
      document.body.innerHTML = invoiceSection;
      window.print();
      document.body.innerHTML = originalContents;
      window.location.reload();
    }else{
      alert("Please select Invoice date first");
      document.getElementById("invoiceDate").focus()
      document.getElementById("invoiceDate").style.border = "2px solid red"
    }
}
</script>
</body>
</html>
