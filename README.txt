********************
* BEFORE BEGINNING *
********************

---------------------------------------------------------------
- PLEASE WATCH | VIDEO TUTORIAL: https://youtu.be/CaGl1iVXtl4 -
---------------------------------------------------------------

-------------------------------------------------------------------------------------------------
- Please Download and Install XAMPP Control Pannel: https://www.apachefriends.org/download.html -
- Please place this folder inside the htdocs folder inside of the xampp file explorer		-
- 	-> Open "htdocs" folder (in File Explorer)						-
- 	-> Import folder with necessary code ("447_Assignment" Folder) into 'xampp/htdocs'	-
-------------------------------------------------------------------------------------------------

******************
* DATABASE SETUP *
******************
---------------------------------------------------------------------------------------------------------------------
- After Installing XAMPP, Open it and:								 		    -
- 1) Start Apache and MySQL in XAMPP Control Panel						 		    -
- 2) In a browser tab (preferrably Google Chrome), type into the URL: http://localhost/phpmyadmin 		    -
- 3) Create a new database via "New" in the top left						  		    -	
- 4) Name the database "student_info" and make sure you are selected on it			 		    -
- 5) Enter the SQL section (near the top) and paste in the 'students.sql' (found in the 447_Assignment folder) file -
- 6) Click 'Go'											 		    -
- 7) You are done with setting up the database							  		    -
---------------------------------------------------------------------------------------------------------------------

***************************
* RUNNING THE APPLICATION *
***************************
-----------------------------------------------------------------------------------------------------------------
- After setting up the database (and XAMPP still running Apache and MySQL):					-
- 1) In a browser tab (prefferably Google Chrome), type into the URL: http://localhost/447_Assignment/main.html -
- 2) You can use the application as desired									-
-----------------------------------------------------------------------------------------------------------------

**************
* QUICK NOTE *
**************
-------------------------------------------------------------------------------------------------------------
- When adding anything to the tables (student, instructor, etc.), input them and click submit one at a time -			 
-------------------------------------------------------------------------------------------------------------

*********
* FILES *
*********
-----------------------------------------------------------------------------------------------------------------------------------------
- students.sql : sql file to import the database tables and fill them with sample data							-
- main.html : main screen file, holds all the necessary code to interact with the rest of the files controlling the front-end interface -
- style.css : css file to format the webpage with certain styles									-
- main_script.js : main javascript file that holds the functions to display and delete data from the tables (shown on the webpage)	-
- add_data.php : php file that interacts with the database to add data to their respective table(s)					-
- delete_data.php : php file that interacts with the database to delete data form their respective table(s)				-
- fetch_students.php : php file that fetches the student data from the students database table						-
- fetch_instructors.php : php file that fetches the instructor data from the instructors database table					-
- fetch_courses.php : php file that fetches the course data from the courses database table						-
- fetch_student_course.php : php file that fetches the enrolled student data from the student_course database table			-
- submit_grade.php : php file that manages the enrolled student function, and adds the data to the student_course database table	-
-----------------------------------------------------------------------------------------------------------------------------------------
