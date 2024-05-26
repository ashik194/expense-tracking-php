<?php
session_start();
require 'db_config.php';

if (isset($_POST['export_csv'])) {
    exportToCSV($conn);
}

function exportToCSV($conn) {
    $filename = "expenses_" . date('Ymd') . ".csv";
    $output = fopen('php://output', 'w');

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="' . $filename . '"');

    $fields = array('Date', 'Category', 'Description', 'Amount');
    fputcsv($output, $fields);

    $query = "SELECT date, category, description, amount FROM expenses ORDER BY date DESC";
    $result = $conn->query($query);
    
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit();
}
?>
