<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $connection_id = $_POST['connection_id'];
    
    $stmt = $pdo->prepare("UPDATE connections SET status = 'accepted' WHERE id = ?");
    $stmt->execute([$connection_id]);

    header("Location: profile.php");
    exit();
}
