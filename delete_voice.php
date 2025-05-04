<?php
session_start();
include 'db.php';

if (!isset($_SESSION['uploader_id'])) {
    die("Unauthorized");
}
$uploader_id = $_SESSION['uploader_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $res = $conn->query("SELECT filename FROM voices WHERE id = $id AND uploader_id = '$uploader_id'");
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        unlink("uploads/" . $row['filename']);
        $conn->query("DELETE FROM voices WHERE id = $id");
    }
}
header("Location: voice.php");
exit;
