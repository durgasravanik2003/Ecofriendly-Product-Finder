<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $friend_id = $_POST['friend_id'];

    // Check if connection already exists
    $stmt = $pdo->prepare("SELECT * FROM connections WHERE user_id = ? AND friend_id = ?");
    $stmt->execute([$user_id, $friend_id]);
    if ($stmt->rowCount() == 0) {
        $stmt = $pdo->prepare("INSERT INTO connections (user_id, friend_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $friend_id]);
    }
    
    header("Location: profile.php");
    exit();
}
