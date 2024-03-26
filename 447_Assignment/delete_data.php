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

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if deleting a student record
    if (isset($_POST["student_id"])) {
        $studentID = $_POST["student_id"];
        
        // Perform deletion query for student's course records
        $deleteCourseRecordsSQL = "DELETE FROM student_course WHERE student_id = $studentID";
        if ($conn->query($deleteCourseRecordsSQL) === TRUE) {
            // Proceed with deleting the student record
            $deleteStudentSQL = "DELETE FROM students WHERE student_id = $studentID";
            if ($conn->query($deleteStudentSQL) === TRUE) {
                echo "Student record and related course records deleted successfully";
            } else {
                echo "Error deleting student record: " . $conn->error;
            }
        } else {
            echo "Error deleting related course records: " . $conn->error;
        }
    }
	// Check if deleting an instructor record
	elseif (isset($_POST["instructor_id"])) {
		$instructorID = $_POST["instructor_id"];
		
		// Step 1: Remove rows from student_course table
		$deleteStudentCourseSQL = "DELETE FROM student_course WHERE course_id IN (SELECT course_id FROM courses WHERE instructor_id = $instructorID)";
		$conn->query($deleteStudentCourseSQL); // Perform deletion query
		
		// Check if rows were affected
		if ($conn->affected_rows > 0 || $conn->error == "") {
			// Step 2: Remove rows from courses table
			$deleteCoursesSQL = "DELETE FROM courses WHERE instructor_id = $instructorID";
			$conn->query($deleteCoursesSQL); // Perform deletion query
			
			// Check if rows were affected
			if ($conn->affected_rows > 0 || $conn->error == "") {
				// Step 3: Remove rows from instructors table
				$deleteInstructorSQL = "DELETE FROM instructors WHERE instructor_id = $instructorID";
				if ($conn->query($deleteInstructorSQL) === TRUE) {
					echo "Instructor record and related course records deleted successfully";
				} else {
					echo "Error deleting instructor record: " . $conn->error;
				}
			} else {
				echo "No courses found for this instructor.";
			}
		} else {
			echo "No student enrollments found for courses taught by this instructor.";
		}
	}
	
	// Check if deleting a course record
	elseif (isset($_POST["course_id"])) {
		$courseID = $_POST["course_id"];
		
		// Step 1: Remove rows containing course_id in student_course database table
		$deleteEnrollmentsSQL = "DELETE FROM student_course WHERE course_id = $courseID";
		if ($conn->query($deleteEnrollmentsSQL) === TRUE) {
			// Step 2: Remove row containing course_id in courses database table
			$deleteCourseSQL = "DELETE FROM courses WHERE course_id = $courseID";
			if ($conn->query($deleteCourseSQL) === TRUE) {
				echo "Course record deleted successfully";
			} else {
				echo "Error deleting course record: " . $conn->error;
			}
		} else {
			echo "Error deleting associated enrollments: " . $conn->error;
		}
	}

	
	// Check if deleting an enrolled course record
	elseif (isset($_POST["studentName"]) && isset($_POST["courseTitle"])) {
		$studentName = $_POST["studentName"];
		$courseTitle = $_POST["courseTitle"];
		
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

		// Get student ID and course ID
		$studentID = getStudentID($conn, $studentName);
		$courseID = getCourseID($conn, $courseTitle);

		// Perform deletion query for enrolled course record
		if ($studentID !== null && $courseID !== null) {
			$deleteEnrolledCourseSQL = "DELETE FROM student_course WHERE student_id = $studentID AND course_id = $courseID";
			if ($conn->query($deleteEnrolledCourseSQL) === TRUE) {
				echo "Enrolled course record deleted successfully";
			} else {
				echo "Error deleting enrolled course record: " . $conn->error;
			}
		} else {
			echo "Error: Student or course not found.";
		}
	}
} else {
    echo "Invalid request method";
}

// Close connection
$conn->close();
?>
