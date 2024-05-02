<?php
	include('secure.php');
	include('connection.php');
	
	$ResID = $_POST["ResID"];
	$ResName = $_POST["ResName"];
	$topicID = $_POST["topicID"];
	//Update the details of the resource
	$sql = "UPDATE resources SET ResName='$ResName', TopicID = '$topicID' WHERE ResID='$ResID'";
	$result = mysqli_query($connection,$sql);
?>

<script>
	<?php
	if (mysqli_affected_rows($connection) > 0) {
		echo "alert('Resource Updated Successfully');";
		echo "window.location.href = 'resource_view.php?topicID=".$topicID."';";
	} else {
		echo "alert('Resource Update Failed');";
		echo "window.history.back();"; 
	}
	?>
</script>