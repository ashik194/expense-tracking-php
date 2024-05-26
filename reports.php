<?php
require 'db_config.php';
require 'all_query.php';

$monthly_summary = getMonthlySummary($conn);
$category_breakdown = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['generate_breakdown'])) {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $category_breakdown = getCategoryBreakdown($conn, $start_date, $end_date);
    }
}
?>

<?php include("layouts/header.php"); ?>

<div class="flex gap-4 min-h-screen">
    <!-- Sidebar -->
    <?php include("layouts/sidebar.php"); ?>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <div class="flex flex-col md:flex-row md:space-x-6">
            <!-- Reports Section -->
            <div class="bg-white shadow-md rounded-lg p-6 w-full">
                <h2 class="text-xl font-bold mb-4">Reports</h2>
                <div class="mb-4">
                    <h3 class="text-lg font-semibold">Monthly Summary</h3>
                    <table class="min-w-full bg-white mt-2">
                        <thead>
                            <tr>
                                <th class="py-2 px-2 text-left border-b">Month</th>
                                <th class="py-2 px-2 text-left border-b">Total Expense</th>
                            </tr>
                        </thead>
                        <tbody id="monthly-summary">
                            <?php foreach ($monthly_summary as $summary): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($summary['month']); ?></td>
                                <td class="py-2 px-4 border-b">$ <?php echo htmlspecialchars($summary['total']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div>
                    <h3 class="text-lg font-semibold">Category Breakdown</h3>
                    <form id="breakdown-form" class="mb-4" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="generate_breakdown" value="1">
                        <div class="flex space-x-4">
                            <div>
                                <label for="start-date" class="block text-gray-700">Start Date</label>
                                <input type="date" id="start-date" class="p-2 border border-gray-300 rounded mt-1" name="start_date">
                            </div>
                            <div>
                                <label for="end-date" class="block text-gray-700">End Date</label>
                                <input type="date" id="end-date" class="p-2 border border-gray-300 rounded mt-1" name="end_date">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Generate</button>
                            </div>
                        </div>
                    </form>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-2 text-left border-b">Category</th>
                                <th class="py-2 px-2 text-left border-b">Total Expense</th>
                            </tr>
                        </thead>
                        <tbody id="category-breakdown">
                            <?php foreach ($category_breakdown as $breakdown): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($breakdown['category']); ?></td>
                                <td class="py-2 px-4 border-b">$ <?php echo htmlspecialchars($breakdown['total']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("layouts/footer.php"); ?>

</body>
</html>
