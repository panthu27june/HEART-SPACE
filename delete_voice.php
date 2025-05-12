<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$voice_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Only allow delete if this user owns the voice
$stmt = $conn->prepare("DELETE FROM voices WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $voice_id, $user_id);
$stmt->execute();

header("Location: voice.php");
?>
