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

// Function to generate unique IDs
function generateUniqueID($conn, $table, $column) {
    // Generate a random 3-digit or 4-digit number (based on what item)
	if ($table === "courses") {
		$randomID = rand(1000, 9999);
	}
	else {
		$randomID = rand(100, 999);
	}
    // Check if the generated ID already exists in the database
    $sql = "SELECT COUNT(*) AS count FROM $table WHERE $column = $randomID";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row["count"] > 0) {
            // If the ID already exists, generate a new one recursively
            return generateUniqueID($conn, $table, $column);
        }
    }
    // If the ID is unique, return it
    return $randomID;
}

// Function to add new student
function addStudent($name, $creditsEarned, $conn) {
    $studentID = generateUniqueID($conn, "students", "student_id"); // Generate unique student ID
    $sql = "INSERT INTO students (student_id, name, credits_earned) VALUES ('$studentID', '$name', $creditsEarned)";
    if ($conn->query($sql) === TRUE) {
        echo "New student added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Function to add new instructor
function addInstructor($name, $department, $conn) {
    $instructorID = generateUniqueID($conn, "instructors", "instructor_id"); // Generate unique instructor ID
    $sql = "INSERT INTO instructors (instructor_id, name, department) VALUES ('$instructorID', '$name', '$department')";
    if ($conn->query($sql) === TRUE) {
        echo "New instructor added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Function to add new course
function addCourse($courseTitle, $instructorID, $conn) {
	$courseID = generateUniqueID($conn, "courses", "course_id"); // Generate unique course ID
	$sql = "INSERT INTO courses (course_id, course_title, instructor_id) VALUES ('$courseID', '$courseTitle', '$instructorID')";
    if ($conn->query($sql) === TRUE) {
        echo "New course added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if adding a new student
    if (isset($_POST["add-student"])) {
        $studentName = $_POST["student-name"];
        $creditsEarned = $_POST["credits-earned"];
        addStudent($studentName, $creditsEarned, $conn);
    }
    // Check if adding a new instructor
    elseif (isset($_POST["add-instructor"])) {
        $instructorName = $_POST["instructor-name"];
        $courseDepartment = $_POST["course-department"];
        addInstructor($instructorName, $courseDepartment, $conn);
    }
	// Check if adding a new course
	elseif (isset($_POST["add-course"])) {
		$courseTitle = $_POST["course-title"];
		$teachingInstructor = $_POST["teaching-instructor"];
		
		// Function to retrieve instructor ID based on instructor name
		function getInstructorID($conn, $instructorName) {
			$sql = "SELECT instructor_id FROM instructors WHERE name = '$instructorName'";
			$result = $conn->query($sql);
			if ($result && $result->num_rows > 0) {
				$row = $result->fetch_assoc();
				return $row['instructor_id'];
			}
			return null; // Return null if instructor not found (Extra validation)
		}

		// Get instructor ID
		$instructorID = getInstructorID($conn, $teachingInstructor);
		if ($instructorID !== null) {
			addCourse($courseTitle, $instructorID, $conn);
		} else {
			echo "Error: Instructor not found.";
		}
	}
	$conn->close();
	header("Location: main.html"); // Return back to main menu and refresh tables
	exit();
}
else {
	echo "Error somewhere";
}
// Close connection
?>
