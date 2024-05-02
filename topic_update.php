<?php
	include('secure.php');
	include('connection.php');
	
	$topicid = $_POST["topicid"];
	$topicname = $_POST["topicname"];
	$anstimelimit = $_POST["anstimelimit"];
	//Update the details of the topic
	$sql = "UPDATE topic SET TopicName='$topicname', AnsTimeLimit = '$anstimelimit' WHERE TopicID='$topicid'";
	$result = mysqli_query($connection,$sql);
?>

<script>
	<?php
		if (mysqli_affected_rows($connection) > 0) {
			echo "alert('Topic Updated Successfully');";
			echo "window.location.href = 'topic_view.php';"; 
		} else {
			echo "alert('Topic Update Failed');";
			echo "window.history.back();";
		}
	?>
</script>