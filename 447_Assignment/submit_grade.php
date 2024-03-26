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

// Function to retrieve student ID based on student name
function getStudentID($conn, $studentName) {
    $sql = "SELECT student_id FROM students WHERE name = '$studentName'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['student_id'];
    }
    return null; // Return null if student not found (Extra validation)
}

// Function to retrieve course ID based on course title
function getCourseID($conn, $courseTitle) {
    $sql = "SELECT course_id FROM courses WHERE course_title = '$courseTitle'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['course_id'];
    }
    return null; // Return null if course not found (Extra validation)
}

// Function to check if the student is already enrolled in the course
function isEnrolled($conn, $studentID, $courseID) {
    $sql = "SELECT * FROM student_course WHERE student_id = $studentID AND course_id = $courseID";
    $result = $conn->query($sql);
    return ($result && $result->num_rows > 0);
}

// Get data from POST request
$studentName = $_POST['search-student'];
$courseTitle = $_POST['search-course'];
$grade = $_POST['grade']; // Convert grade to integer

// Get student ID and course ID
$studentID = getStudentID($conn, $studentName);
$courseID = getCourseID($conn, $courseTitle);

// Check if the student is already enrolled in the course
if ($studentID !== null && $courseID !== null) {
    if (isEnrolled($conn, $studentID, $courseID)) {
        // Redirect back to main.html with error message
        header("Location: main.html?error=Student%20is%20already%20enrolled%20in%20the%20course");
        exit();
    } else {
        // Insert record into student_course table
        $sql = "INSERT INTO student_course (student_id, course_id, grade) VALUES ($studentID, $courseID, $grade)";
        if ($conn->query($sql) === TRUE) {
            // Redirect back to main.html with success message
            header("Location: main.html?success=Grade%20submitted%20successfully");
            exit();
        } else {
            // Redirect back to main.html with error message
            header("Location: main.html?error=" . urlencode("Error: " . $sql . "<br>" . $conn->error));
            exit();
        }
    }
} else {
    // Redirect back to main.html with error message
    header("Location: main.html?error=Student%20or%20course%20not%20found");
    exit();
}

// Close database connection
$conn->close();
?>
