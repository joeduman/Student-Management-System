// Function to fetch student records from the server and update the student table
function fetchStudents() {
    // Make an AJAX request to fetch student records from the server
    $.ajax({
        url: 'fetch_students.php',
        method: 'GET',
        success: function(data) {
            // Parse the JSON response
            var students = JSON.parse(data);
            
            // Clear existing table content
            $('#student-table').find('tbody').empty();

            // Populate the student table with fetched data
            students.forEach(function(student) {
                var row = '<tr>' +
                          '<td>' + student['student_id'] + '</td>' +
                          '<td>' + student['name'] + '</td>' +
                          '<td>' + student['credits_earned'] + '</td>' +
						  '<td><button class="delete-student" data-id="' + student['student_id'] + '">Remove Student</button></td>' +
                          '</tr>';
                $('#student-table').append(row);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching student records:', error);
        }
    });
}

// Function to fetch instructor records from the server and update the instructor table
function fetchInstructors() {
    // Make an AJAX request to fetch instructor records from the server
    $.ajax({
        url: 'fetch_instructors.php',
        method: 'GET',
        success: function(data) {
            // Parse the JSON response
            var instructors = JSON.parse(data);
            
            // Clear existing table content
            $('#instructor-table').find('tbody').empty();

            // Populate the instructor table with fetched data
            instructors.forEach(function(instructor) {
                var row = '<tr>' +
                          '<td>' + instructor['instructor_id'] + '</td>' +
                          '<td>' + instructor['name'] + '</td>' +
                          '<td>' + instructor['department'] + '</td>' +
						  '<td><button class="delete-instructor" data-id="' + instructor['instructor_id'] + '">Remove Instructor</button></td>' +
                          '</tr>';
                $('#instructor-table').append(row);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching instructor records:', error);
        }
    });
}

// Function to fetch course records from the server and update the course table
function fetchCourses() {
    // Make an AJAX request to fetch course records from the server
    $.ajax({
        url: 'fetch_courses.php',
        method: 'GET',
        success: function(data) {
            // Parse the JSON response
            var courses = JSON.parse(data);
            
            // Clear existing table content
            $('#course-table').find('tbody').empty();

            // Populate the course table with fetched data
            courses.forEach(function(course) {
                var row = '<tr>' +
                          '<td>' + course['course_id'] + '</td>' +
                          '<td>' + course['course_title'] + '</td>' +
                          '<td>' + course['instructor_id'] + '</td>' +
						  '<td><button class="delete-course" data-id="' + course['course_title'] + '">Remove Course</button></td>' +
                          '</tr>';
                $('#course-table').append(row);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching course records:', error);
        }
    });
}

// Function to fetch enrolled student records from the server and update the grades table
function fetchEnrolledStudents() {
    // Make an AJAX request to fetch student course records from the server
    $.ajax({
        url: 'fetch_student_course.php',
        method: 'GET',
        success: function(data) {
            // Parse the JSON response
            var studentCourses = JSON.parse(data);
            
            // Clear existing table content
            $('#grades-table').find('tbody').empty();

            // Populate the grades table with fetched data
            studentCourses.forEach(function(studentCourse) {
                var row = '<tr>' +
                          '<td>' + studentCourse['name'] + '</td>' +
                          '<td>' + studentCourse['course_title'] + '</td>' +
                          '<td>' + studentCourse['grade'] + '</td>' +
						  '<td><button class="delete-enrolled-student" data-id="' + studentCourse['name'] + '">Drop Course</button></td>' +
                          '</tr>';
                $('#grades-table').append(row);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching student course records:', error);
        }
    });
}

// Function to handle the deletion of a student
function deleteStudent(studentID) {
    // Make an AJAX request to delete the student record from the server
    $.ajax({
        url: 'delete_data.php',
        method: 'POST',
        data: { student_id: studentID },
        success: function(response) {
            // Refresh the student table after successful deletion
            fetchStudents();
        },
        error: function(xhr, status, error) {
            console.error('Error deleting student record:', error);
        }
    });
}

// Function to handle the deletion of an instructor
function deleteInstructor(instructorID) {
    // Make an AJAX request to delete the instructor record from the server
    $.ajax({
        url: 'delete_data.php',
        method: 'POST',
        data: { instructor_id: instructorID },
        success: function(response) {
            // Refresh the instructor table after successful deletion
            fetchInstructors();
        },
        error: function(xhr, status, error) {
            console.error('Error deleting instructor record:', error);
        }
    });
}

// Function to handle the deletion of a course
function deleteCourse(courseID) {
    // Make an AJAX request to delete the course record from the server
    $.ajax({
        url: 'delete_data.php',
        method: 'POST',
        data: { course_id: courseID },
        success: function(response) {
            // Refresh the course table after successful deletion
            fetchCourses();
        },
        error: function(xhr, status, error) {
            console.error('Error deleting instructor record:', error);
        }
    });
}

// Function to handle dropping a course
function dropCourse(studentName, courseTitle) {
    // AJAX request to delete record from student_course table
    $.ajax({
        url: 'delete_data.php',
        method: 'POST',
        data: { action: 'dropCourse', studentName: studentName, courseTitle: courseTitle },
        success: function(response) {
            // Refresh the page or update the UI as needed
            fetchEnrolledStudents();
        },
        error: function(xhr, status, error) {
            console.error('Error dropping course:', error);
        }
    });
}


// Event listener for the "Delete" button for student records
$('#student-table').on('click', '.delete-student', function() {
    var studentID = $(this).closest('tr').find('td:first').text(); // Get the student ID from the first column of the row
    deleteStudent(studentID);
	location.reload()
});

// Event listener for the "Delete" button for instructor records
$('#instructor-table').on('click', '.delete-instructor', function() {
    var instructorID = $(this).closest('tr').find('td:first').text(); // Get the instructor ID from the first column of the row
    deleteInstructor(instructorID);
	location.reload()
});

// Event listener for the "Delete" button for course records
$('#course-table').on('click', '.delete-course', function() {
    var courseID = $(this).closest('tr').find('td:first').text(); // Get the course ID from the first column of the row
    deleteCourse(courseID);
	location.reload()
});

// Event listener for the "Delete" button for enrolled-students records
$('#grades-table').on('click', '.delete-enrolled-student', function() {
    var studentName = $(this).closest('tr').find('td:first').text(); // Get the student name from the first column of the row
	var courseTitle = $(this).closest('tr').find('td:nth-child(2)').text(); // Get the course title from the second column of the row
    dropCourse(studentName, courseTitle);
});


// Call all the functions when the page is loaded
$(document).ready(function() {
    fetchStudents();
	fetchInstructors();
	fetchCourses();
	fetchEnrolledStudents();
});
