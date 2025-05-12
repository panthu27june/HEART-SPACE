<?php
session_start();
include 'db.php';

$result = $conn->query("SELECT v.*, u.username FROM voices v JOIN users u ON v.user_id = u.id ORDER BY v.id DESC");

$voices = [];
while ($row = $result->fetch_assoc()) {
    $voices[] = $row;
}

echo json_encode($voices);
?>
