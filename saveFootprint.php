<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data from the request
$data = json_decode(file_get_contents('php://input'), true);

$householdSize = $data['householdSize'];
$dailyActivities = $data['dailyActivities'];
$diet = $data['diet'];
$wasteManagement = $data['wasteManagement'];
$carbonFootprint = $data['carbonFootprint'];
$date = date('Y-m-d H:i:s');

$sql = "INSERT INTO footprints (householdSize, dailyActivities, diet, wasteManagement, carbonFootprint, date)
        VALUES ('$householdSize', '$dailyActivities', '$diet', '$wasteManagement', '$carbonFootprint', '$date')";

if ($conn->query($sql) === TRUE) {
    $response = ['id' => $conn->insert_id];
} else {
    $response = ['error' => $conn->error];
}

$conn->close();

echo json_encode($response);
?>
