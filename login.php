<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'signup');
    if ($conn->connect_error) {
        echo "Connection Failed: " . $conn->connect_error;
        exit;
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM registration WHERE username = ? AND password = ?");
    if (!$stmt) {
        echo "Error: " . $conn->error;
        $conn->close();
        exit;
    }

    // Bind parameters and execute statement
    $stmt->bind_param("ss", $userName, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful
        $_SESSION['username'] = $userName;
        header("Location: nav.html");
        exit;
    } else {
        // Login failed
        echo "Invalid username or password.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
