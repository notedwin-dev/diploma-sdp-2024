<?php
	include('connection.php');
	include('secure.php');

	$LecID = $_SESSION['userid'];

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//Get the data sent via POST
		$idovresult = $_POST['idovresult'];
		$comment = $_POST['comment'];
		$LecID = $_SESSION['userid'];

		//Update the overall_result table with the comment
		$updateSql = "UPDATE overall_result SET Comment = '$comment', LecID = '$LecID' WHERE OvResultID = '$idovresult'";
		
		if (mysqli_query($connection, $updateSql)) {
			//Display an alert and redirect after OK is clicked
			echo '<script>';
			echo 'alert("Comment updated successfully");';
			echo 'window.location.href = "lecturer_resultview.php?option=' . $_GET['option'] . '&grade=' . $_GET['grade'] . '&startdate=' . $_GET['startdate'] . '&enddate=' . $_GET['enddate'] . '";';
			echo '</script>';
		} else {
			echo 'Error updating comment: ' . mysqli_error($connection);
		}
	} else {
		echo 'Invalid request';
	}
?>