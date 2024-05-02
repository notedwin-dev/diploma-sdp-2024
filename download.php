<?php
	include('secure.php');
	include('connection.php');

	if (isset($_GET['ResID'])) {
		$resID = $_GET['ResID'];

		//Get the file data from database
		$sql = "SELECT ResName, ResFileName FROM resources WHERE ResID = '$resID'";
		$result = mysqli_query($connection, $sql);

		if ($row = mysqli_fetch_assoc($result)) {
			$fileName = $row['ResName'];
			$fileData = $row['ResFileName'];
		
			//Set headers for file download
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment; filename="' . $fileName . '.pdf"');
		
			//Display file data directly
			echo $fileData;
			exit();
		}
	}
?>
