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

// Fetch data from the student_course table
$sql = "SELECT * FROM student_course";
$result = $conn->query($sql);
$studentCourses = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Fetch student name based on student ID
        $studentID = $row['student_id'];
        $studentNameSql = "SELECT name FROM students WHERE student_id = $studentID";
        $studentNameResult = $conn->query($studentNameSql);
        if ($studentNameResult && $studentNameResult->num_rows > 0) {
            $studentNameRow = $studentNameResult->fetch_assoc();
            $studentName = $studentNameRow['name'];
        } else {
            $studentName = "Unknown"; // Default value if student name not found
        }

        // Fetch course title based on course ID
        $courseID = $row['course_id'];
        $courseTitleSql = "SELECT course_title FROM courses WHERE course_id = $courseID";
        $courseTitleResult = $conn->query($courseTitleSql);
        if ($courseTitleResult && $courseTitleResult->num_rows > 0) {
            $courseTitleRow = $courseTitleResult->fetch_assoc();
            $courseTitle = $courseTitleRow['course_title'];
        } else {
            $courseTitle = "Unknown"; // Default value if course title not found
        }

        // Add student name, course title, and grade to the array
        $studentCourses[] = array(
            'name' => $studentName,
            'course_title' => $courseTitle,
            'grade' => $row['grade']
        );
    }
}

// Close database connection
$conn->close();

// Return student course records as JSON
echo json_encode($studentCourses);
?>
