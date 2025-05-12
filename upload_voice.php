<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access");
}

$user_id = $_SESSION['user_id'];
$blob = null;
$mime_type = null;

// Handle audio file input
if (isset($_FILES['audioFile']) && $_FILES['audioFile']['size'] > 0) {
    if ($_FILES['audioFile']['size'] > 5 * 1024 * 1024) {
        die("File too large. Max 5MB.");
    }
    $blob = file_get_contents($_FILES['audioFile']['tmp_name']);
    $mime_type = $_FILES['audioFile']['type'];
}

// Handle recorded blob
if (isset($_POST['recordedAudio']) && !empty($_POST['recordedAudio'])) {
    $data = $_POST['recordedAudio'];
    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);
    $blob = base64_decode($data);
    $mime_type = explode(':', $type)[1];
}

if ($blob && $mime_type) {
    $stmt = $conn->prepare("INSERT INTO voices (user_id, filename, created_at) VALUES (?, ?)");
    $stmt->bind_param("iss", $user_id, $blob, $mime_type);
    $stmt->send_long_data(1, $blob);
    $stmt->execute();
    header("Location: voice.php");
    $stmt = $conn->prepare("INSERT INTO voices (user_id, filename) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $filename);
$stmt = $conn->prepare("INSERT INTO voices VALUES (?, ?, ?, ?)");

} else {
    echo "No audio received";
}



// session_start();
if (!isset($_SESSION['id'])) {
    echo "Not logged in.";
    exit();
}

$title = $_POST['title'];
$description = $_POST['description'] ?? '';
$userId = $_SESSION['id'];

if (isset($_FILES['recordedAudio'])) {
    $file = $_FILES['recordedAudio'];
} elseif (isset($_FILES['audioFile'])) {
    $file = $_FILES['audioFile'];
} else {
    echo "No audio received";
    exit();
}

// Now validate and move uploaded file...




?>
