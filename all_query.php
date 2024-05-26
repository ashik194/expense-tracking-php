<?php
// Category Add Function
function addCategory($conn, $name){
    $stmt = $conn->prepare("INSERT INTO categories(name) VALUES(?)");
    $stmt->bind_param("s",$name);
    $stmt->execute();
    $stmt->close();
}

// All Categories 
function getCategories($conn) {
    $stmt = $conn->prepare("SELECT * from categories");
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $categories;
}

// Update Category
function updateCategory($conn, $id, $name) {
    $stmt = $conn->prepare('UPDATE categories SET name= ? WHERE id= ?');
    $stmt->bind_param('si', $name, $id);
    $stmt->execute();
    $stmt->close();
}

// Delete Category 
function deketeCategory($conn, $id) {
    $stmt = $conn->prepare('DELETE FROM categories WHERE id= ?');
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
}


// Function to add expense
function addExpenseItem($conn, $amount, $description, $date, $user_id, $category_id) {
    $stmt = $conn->prepare("INSERT INTO expenses (amount, description, date, user_id, category_id) VALUES (?,?,?,?,?)");
    $stmt->bind_param('ssssi', $amount, $description, $date, $user_id, $category_id);
    $stmt->execute();
    $stmt->close();

}

// All expenses
function getExpenses($conn) {
    $stmt = $conn->prepare("SELECT e.id, e.amount, e.description, e.date, c.name FROM expenses AS e LEFT JOIN categories AS c ON e.category_id = c.id");
    $stmt->execute();
    $result = $stmt->get_result();
    $expenses = $result->fetch_all(MYSQLI_ASSOC);
    // $expenses = $result->fetch_assoc();
    $stmt->close();
    return $expenses;
}

// Single expense data
function getSingleExpense($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM expenses WHERE id=?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $expense = $result->fetch_assoc();
    $stmt->close();
    echo json_encode($expense) ;
}

// Update expenses
function updateExpenses($conn, $id, $amount, $description, $date, $category_id) {
    $stmt = $conn->prepare("UPDATE expenses SET amount=?, description=?, date=?, category_id=? WHERE id=?");
    $stmt->bind_param("ssssi", $amount, $description, $date, $category_id, $id);
    $stmt->execute();
    $stmt->close();
}

// Delete expense
function deleteExpense($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM expenses WHERE id=?");
    $stmt->bind_param('s',$id);
    $stmt->execute();
    $stmt->close();
}

// Monthly Summary
function getMonthlySummary($conn) {
    $stmt = $conn->prepare('SELECT DATE_FORMAT(date, "%Y-%M") as month, SUM(amount) as total FROM expenses GROUP BY month');
    $stmt->execute();
    $result = $stmt->get_result();
    $summary = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $summary;
}

// Category Wise Expense
function getCategoryBreakdown($conn, $start_date, $end_date) {
    $stmt = $conn->prepare('SELECT c.name as category, SUM(e.amount) as total FROM expenses e JOIN categories c ON e.category_id = c.id WHERE e.date BETWEEN ? AND ? GROUP BY c.id');
    $stmt->bind_param('ss', $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    $breakdown = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $breakdown;
}

// Expense By Month
function getExpensesByMonth($conn, $month) {
    $stmt = $conn->prepare('SELECT date, category, description, amount FROM expenses WHERE MONTH(date) = ? ORDER BY date');
    $stmt->bind_param('i', $month);
    $stmt->execute();
    $result = $stmt->get_result();
    $expenses = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $expenses;
}

// Expense By Date
function getExpensesByDateRange($conn, $start_date, $end_date) {
    $stmt = $conn->prepare('SELECT date, category, description, amount FROM expenses WHERE date BETWEEN ? AND ? ORDER BY date');
    $stmt->bind_param('ss', $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    $expenses = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $expenses;
}


// Fetch monthly dashboard summary data
function getDashboardMonthlySummary($conn) {
    $stmt = $conn->prepare('SELECT MONTH(date) as month, SUM(amount) as total FROM expenses GROUP BY MONTH(date)');
    $stmt->execute();
    $result = $stmt->get_result();
    $summary = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $summary;
}

// Fetch category Dashboard data
function getDashboardCategoryBreakdown($conn) {
    $stmt = $conn->prepare('SELECT c.name as category, SUM(e.amount) as total FROM expenses e JOIN categories c ON e.category_id = c.id GROUP BY c.id');
    $stmt->execute();
    $result = $stmt->get_result();
    $breakdown = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $breakdown;
}

function getTrendsOverTime($conn) {
    $stmt = $conn->prepare('SELECT WEEK(date) as week, SUM(amount) as total FROM expenses GROUP BY WEEK(date)');
    $stmt->execute();
    $result = $stmt->get_result();
    $trends = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $trends;
}

// Fetch recent expenses
function getRecentExpenses($conn) {
    $stmt = $conn->prepare('SELECT * FROM expenses ORDER BY date DESC LIMIT 5');
    $stmt->execute();
    $result = $stmt->get_result();
    $recent_expenses = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $recent_expenses;
}


function formatExpensesForChart($expenses, $labelKey, $dataKey) {
    $labels = [];
    $data = [];
    foreach ($expenses as $expense) {
        $labels[] = $expense[$labelKey];
        $data[] = $expense[$dataKey];
    }
    return ['labels' => $labels, 'data' => $data];
}

?>
