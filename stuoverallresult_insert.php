<?php
	include('secure.php');
	include('connection.php');

	$studentID = ''; //Initialize the variable

	//Check if the 'stuid' session variable is set
	if (isset($_SESSION['userid'])) {
		// Retrieve the student ID from the session
		$studentID = $_SESSION['userid'];

		//Check if the form is submitted using the GET method
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			if (isset($_GET['idtopic'])) {
				// Retrieve the selected topic ID from the form
				$topicID = $_GET['idtopic'];

				//Insert the data into the database
				$insertSql = "INSERT INTO overall_result (StuID, TopicID) VALUES ('$studentID', '$topicID')";
				//Perform the database query
				if (mysqli_query($connection, $insertSql)) {
					// Get the auto-generated ID from the last query
					$ResultID = mysqli_insert_id($connection);
					echo "Record inserted successfully.";
				} else {
					echo "Error: " . $insertSql . "<br>" . mysqli_error($connection);
				}
			}
		}

		//Redirect the user to quiz_start.php with the selected topic ID
		header("Location: student_quizstart.php?idtopic=$topicID&ovResultID=$ResultID");
	} else {
		//Handle the case where 'stuid' is not set
		echo "Student ID not found in the session.";
	}
?>