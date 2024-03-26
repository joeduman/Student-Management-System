<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_info";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch instructor records from the database
$sql = "SELECT * FROM instructors";
$result = $conn->query($sql);
$instructors = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $instructors[] = $row;
    }
}

// Close database connection
$conn->close();

// Return student records as JSON
echo json_encode($instructors);
?>
