<?php
//Check if all required fields are present in the POST request
if (!isset($_POST['username'], $_POST['email'], $_POST['mobile'], $_POST['password'], $_POST['confirm-password'])) {
    // Handle missing fields
    echo "Error: Required field.s are missing.";
    exit;
}

$userName = $_POST['username'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$password = $_POST['password'];
$cpassword = $_POST['confirmPassword'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'signup');
if ($conn->connect_error) {
    echo "Connection Failed: " . $conn->connect_error;
    exit;
}

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO registration (username, email, mobile, password, `confirmPassword`) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    echo "Error: " . $conn->error;
    $conn->close();
    exit;
}

// Bind parameters and execute statement
$stmt->bind_param("ssiss", $userName, $email, $mobile, $password, $cpassword);
if (!$stmt->execute()) {
    echo "Error: " . $stmt->error;
} else {
    header("location:nav.html");
    
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
