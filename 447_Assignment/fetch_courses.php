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

// Fetch course records from the database
$sql = "SELECT courses.course_id, courses.course_title, instructors.name AS instructor_id 
        FROM courses 
        INNER JOIN instructors ON courses.instructor_id = instructors.instructor_id";
$result = $conn->query($sql);
$courses = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

// Close database connection
$conn->close();

// Return student records as JSON
echo json_encode($courses);
?>
