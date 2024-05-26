<?php
$host = 'localhost';
$db = 'gub_expense_tracking';
$user = 'root';
$pass = "";

$conn = new mysqli($host,  $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
