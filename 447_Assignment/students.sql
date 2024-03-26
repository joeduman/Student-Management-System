-- Create tables for students, courses, instructors, and student_course relationship
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    credits_earned INT
);

CREATE TABLE instructors (
    instructor_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    department VARCHAR(255)
);

CREATE TABLE courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    course_title VARCHAR(255) NOT NULL,
    instructor_id INT,
    FOREIGN KEY (instructor_id) REFERENCES instructors(instructor_id)
);

CREATE TABLE student_course (
    student_id INT,
    course_id INT,
    grade INT,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
    PRIMARY KEY (student_id, course_id)
);

-- Insert sample data into students table
INSERT INTO students (student_id, name, credits_earned) VALUES
    (387, 'John Walker', 93),
    (209, 'David Jameson', 87),
    (101, 'Emma Wells', 57),
    (190, 'Nisha Singh', 92),
    (978, 'Jack Thompson', 100),
    (350, 'Ben Joseph', 79),
    (270, 'Kate Jimpson', 68);

-- Insert sample data into instructors table
INSERT INTO instructors (instructor_id, name, department) VALUES
    (456, 'Jim George', 'Statistics'),
    (589, 'Kevin Mathews', 'Information Systems'),
    (821, 'John Sullins', 'Health Sciences'),
    (954, 'William Robertson', 'Physics'),
    (673, 'Sandra Wilson', 'Biology'),
    (535, 'Donna Joseph', 'Computer Science'),
    (990, 'Natalia Smith', 'Chemistry');

-- Insert sample data into courses table
INSERT INTO courses (course_id, course_title, instructor_id) VALUES
    (9076, 'Software Engineering', 535),
    (1028, 'Organic Chemistry I', 990),
    (7654, 'Health Informatics', 821),
    (8721, 'Database Systems', 589);

-- Insert sample data into student_course table
INSERT INTO student_course (student_id, course_id, grade) VALUES
    (387, 9076, 85),
    (209, 1028, 90),
    (101, 7654, 75),
    (190, 8721, 88);
