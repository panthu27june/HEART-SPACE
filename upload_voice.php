<?php
session_start();
include 'db.php';

if (!isset($_SESSION['uploader_id'])) {
    die("Unauthorized");
}
$uploader_id = $_SESSION['uploader_id'];

if (isset($_FILES['audioFile']) && $_FILES['audioFile']['error'] === 0) {
    $file = $_FILES['audioFile'];
    if ($file['size'] > 5 * 1024 * 1024) {
        die("File too large.");
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_name = uniqid() . '.' . $ext;
    move_uploaded_file($file['tmp_name'], "uploads/" . $new_name);

    $stmt = $conn->prepare("INSERT INTO voices (filename, uploader_id) VALUES (?, ?)");
    $stmt->bind_param("ss", $new_name, $uploader_id);
    $stmt->execute();
    $stmt->close();
}

if (!empty($_POST['recordedFile'])) {
    $data = $_POST['recordedFile'];
    $data = str_replace('data:audio/webm;codecs=opus;base64,', '', $data);
    $data = base64_decode($data);
    $new_name = uniqid() . '.webm';
    file_put_contents("uploads/" . $new_name, $data);

    $stmt = $conn->prepare("INSERT INTO voices (filename, uploader_id) VALUES (?, ?)");
    $stmt->bind_param("ss", $new_name, $uploader_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: voice.php");
exit;
