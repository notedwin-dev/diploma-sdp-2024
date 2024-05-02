<?php
	//Delete the record when student click on the back button during the quiz:
	
	include('connection.php');

	$ovResultID = isset($_GET['ovResultID']) ? $_GET['ovResultID'] : null;
	$stuID = isset($_GET['stuID']) ? $_GET['stuID'] : null;
	$topicID = isset($_GET['topicID']) ? $_GET['topicID'] : null;

	//Prepare the deletion query with prepared statements
	$deleteSql = "DELETE FROM overall_result WHERE OvResultID = ? AND StuID = ? AND TopicID = ?";
	$stmt = mysqli_prepare($connection, $deleteSql);
	
	//Bind parameters to the prepared statement
	mysqli_stmt_bind_param($stmt, "iss", $ovResultID, $stuID, $topicID);
	
	//Execute the prepared statement
	if (mysqli_stmt_execute($stmt)) {
		// Redirect to the topic filter file after successful deletion
		header("Location: student_quiztopicfilter.php");
		exit(); // Ensure that no further code is executed after the redirection
	} else {
		//Display an error message if the deletion fails
		echo "Error: " . $deleteSql . "<br>" . mysqli_error($connection);
	}

	//Close the prepared statement
	mysqli_stmt_close($stmt);
?>
