<?php
	include('secure.php');
	include('connection.php');

	if (isset($_GET['id'])) {
		$resID = $_GET['id'];

		//Retrieve file data from the database based on the resource id that have got above
		$sql = "SELECT ResName, ResFileName FROM resources WHERE ResID = '$resID'";
		$result = mysqli_query($connection, $sql);

		//Check if a record is found
		if ($row = mysqli_fetch_assoc($result)) {
			$fileName = $row['ResName'];
			$fileData = $row['ResFileName'];
		
			//Set headers for file download
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment; filename="' . $fileName . '.pdf"');
		
			//Output file data directly
			echo $fileData;
			exit(); // Ensure that no further code is executed after file download
		}
	}
?>
