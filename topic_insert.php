<?php
	include('secure.php');
	include('connection.php');
	
	$topicname = $_POST["topicname"];
	$anstimelimit = $_POST["anstimelimit"];
	//Insert new topic details into database
	$sql = "INSERT INTO topic (TopicName, AnsTimeLimit) VALUES('$topicname','$anstimelimit')";
	$result = mysqli_query($connection,$sql);
?>

<script>
	<?php
	if ($result == true) {
		echo "alert('New Topic Added Successfully');";
		echo "window.location.href = 'topic_view.php';"; 
	} else {
		echo "alert('Fail to add new topic');";
		echo "window.history.back();"; 
	}
	?>
</script>