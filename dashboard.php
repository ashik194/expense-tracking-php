<?php 
require 'db_config.php';
require 'all_query.php';

$monthly_summary = getDashboardMonthlySummary($conn);
$category_breakdown = getDashboardCategoryBreakdown($conn);
$trends_over_time = getTrendsOverTime($conn);
$recent_expenses = getRecentExpenses($conn);

$monthly_summary_chart = formatExpensesForChart($monthly_summary, 'month', 'total');
$category_breakdown_chart = formatExpensesForChart($category_breakdown, 'category', 'total');
$trends_over_time_chart = formatExpensesForChart($trends_over_time, 'week', 'total');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your head content here -->
</head>
<body>
  <!-- Navbar -->
<?php include("layouts/header.php"); ?>

 <div class="flex gap-4 min-h-screen">
     <!-- Sidebar -->
  <?php include("layouts/sidebar.php");?>

    <!-- Main Content -->
    <div class="w-full p-6">
      <div class="grid grid-cols-1 grid-flow-row-dens md:grid-cols-3 gap-6">
        
        <!-- Monthly Summary Card -->
        <div class="bg-white shadow-md rounded-lg p-6">
          <h2 class="text-xl font-bold mb-4">Monthly Summary</h2>
          <div class="flex items-center justify-between">
            <span class="text-3xl font-semibold">$<?php echo number_format(array_sum(array_column($monthly_summary, 'total')), 2); ?></span>
            <span class="text-green-500">+10%</span>
          </div>
          <div class="mt-4">
            <canvas id="monthlySummaryChart"></canvas>
          </div>
        </div>

        <!-- Category Breakdown Card -->
        <div class="bg-white shadow-md rounded-lg p-6">
          <h2 class="text-xl font-bold mb-4">Category Breakdown</h2>
          <div class="mt-4">
            <canvas id="categoryBreakdownChart"></canvas>
          </div>
        </div>

        <!-- Recent Expenses Card -->
        <div class="bg-white shadow-md rounded-lg p-6">
          <h2 class="text-xl font-bold mb-4">Recent Expenses</h2>
          <ul>
            <?php foreach ($recent_expenses as $expense): ?>
              <li class="flex justify-between items-center mb-2">
                <span><?php echo htmlspecialchars($expense['description']); ?></span>
                <span class="text-red-500">-$<?php echo number_format($expense['amount'], 2); ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
          <a href="#" class="text-blue-600 hover:underline">View All</a>
        </div>
      </div>

      <!-- Charts Section -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

        <!-- Trends Over Time Card -->
        <div class="bg-white shadow-md rounded-lg p-6">
          <h2 class="text-xl font-bold mb-4">Trends Over Time</h2>
          <div class="mt-4">
            <canvas id="trendsOverTimeChart"></canvas>
          </div>
        </div>

        <!-- Export Data Card -->
        <div class="bg-white shadow-md rounded-lg p-6">
          <h2 class="text-xl font-bold mb-4">Export Data</h2>
          <form action="export.php" method="POST">
            <button type="submit" name="export_csv" class="bg-blue-600 text-white px-4 py-2 rounded">Export to CSV</button>
            <!-- <button type="submit" name="export_excel" class="bg-blue-600 text-white px-4 py-2 rounded ml-2">Export to Excel</button> -->
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include("layouts/footer.php");?>

  <!-- Chart.js Script -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const monthlySummaryData = <?php echo json_encode($monthly_summary_chart); ?>;
    const categoryBreakdownData = <?php echo json_encode($category_breakdown_chart); ?>;
    const trendsOverTimeData = <?php echo json_encode($trends_over_time_chart); ?>;

    const ctxMonthly = document.getElementById('monthlySummaryChart').getContext('2d');
    new Chart(ctxMonthly, {
      type: 'line',
      data: {
        labels: monthlySummaryData.labels,
        datasets: [{
          label: 'Expenses',
          data: monthlySummaryData.data,
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 2,
          fill: false,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
      }
    });

    const ctxCategory = document.getElementById('categoryBreakdownChart').getContext('2d');
    new Chart(ctxCategory, {
      type: 'pie',
      data: {
        labels: categoryBreakdownData.labels,
        datasets: [{
          data: categoryBreakdownData.data,
          backgroundColor: [
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)'
          ],
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
      }
    });

    const ctxTrends = document.getElementById('trendsOverTimeChart').getContext('2d');
    new Chart(ctxTrends, {
      type: 'line',
      data: {
        labels: trendsOverTimeData.labels,
        datasets: [{
          label: 'Expenses',
          data: trendsOverTimeData.data,
          borderColor: 'rgba(153, 102, 255, 1)',
          borderWidth: 2,
          fill: false,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
      }
    });

    // Sidebar toggle script
    document.getElementById('menu-btn').addEventListener('click', () => {
      document.getElementById('sidebar').classList.toggle('sidebar-closed');
    });
  </script>
</body>
</html>
