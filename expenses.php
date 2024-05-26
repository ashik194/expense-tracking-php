<?php
require 'db_config.php';

// Function to add a new expense
function addExpense($conn, $amount, $category, $description, $date) {
    $stmt = $conn->prepare("INSERT INTO expenses (amount, category, description, date) VALUES (:amount, :category, :description, :date)");
    $stmt->execute([':amount' => $amount, ':category' => $category, ':description' => $description, ':date' => $date]);
    return $conn->lastInsertId();
}

// Function to get all expenses
function getExpenses($conn) {
    $stmt = $conn->query("SELECT * FROM expenses ORDER BY date DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to update an expense
function updateExpense($conn, $id, $amount, $category, $description, $date) {
    $stmt = $conn->prepare("UPDATE expenses SET amount = :amount, category = :category, description = :description, date = :date WHERE id = :id");
    $stmt->execute([':amount' => $amount, ':category' => $category, ':description' => $description, ':date' => $date, ':id' => $id]);
    return $stmt->rowCount();
}

// Function to delete an expense
function deleteExpense($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM expenses WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->rowCount();
}

// Handle incoming requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        $amount = $_POST['amount'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        $id = addExpense($conn, $amount, $category, $description, $date);
        echo json_encode(['id' => $id]);
    } elseif ($action === 'update') {
        $id = $_POST['id'];
        $amount = $_POST['amount'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        $count = updateExpense($conn, $id, $amount, $category, $description, $date);
        echo json_encode(['updated' => $count > 0]);
    } elseif ($action === 'delete') {
        $id = $_POST['id'];
        $count = deleteExpense($conn, $id);
        echo json_encode(['deleted' => $count > 0]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $expenses = getExpenses($conn);
    echo json_encode($expenses);
}
?>
