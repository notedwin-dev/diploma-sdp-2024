<?php
	include('secure.php');
	include('connection.php');

	if ($_SERVER['REQUEST_METHOD'] ==='GET' && isset($_GET['ResID'])) {
		$resid = $_GET['ResID'];
		$topicID = $_GET['topicID'];

		//Delete the resource
		$sql = "DELETE FROM resources WHERE ResID='$resid'";
		$result = mysqli_query($connection, $sql);

		if (mysqli_affected_rows($connection) > 0) {
			echo '<script>alert("Resource deleted successfully!");</script>';
		} else {
			echo '<script>alert("Failed to delete resource: ' . mysqli_error($connection) . '");</script>';
		}
		
		echo '<script>window.location.href = "resource_view.php?topicID=' . $topicID . '";</script>';
		exit(); 
	}
?>