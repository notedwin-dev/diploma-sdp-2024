<?php
	include('secure.php');
	include('connection.php');
	
	$LecID = $_SESSION['userid'];
	$sql = "SELECT LecType FROM lecturer WHERE LecID = '$LecID'";
	$result = mysqli_query($connection, $sql);
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		$LecType = $row['LecType'];
		if ($LecType == 1) {
			include('nav_hom.php');
		} elseif ($LecType == 2) {
			include('nav_lec.php');
		}
	}
?>	
<script>
	function confirmDelete() {
		return confirm("Are you sure you want to delete this topic?");
	}
	
	function goBack() {
		var lecType = <?php echo $LecType; ?>;

		if (lecType == 1) {
			window.location.href = 'home_hom.php';
		} else if (lecType == 2) {
			window.location.href = 'home_lecturer.php';
		}
	}
</script>
<link rel="stylesheet" href="button.css">
<link rel="stylesheet" href="table2.css">
<div class="content">
	<table>
	<caption>LIST OF TOPIC</caption>
		<tr>
			<th>No.</th>
			<th>TOPIC</th>
			<th>ANSWER TIME LIMIT</th>
			<th>QUESTION</th>
			<th>RESOURCE</th>
			<th>DELETE</th>
			<th>UPDATE</th>
		</tr>
		
	<?php
		//Check if the form is submitted for delete function
		//The topic and relevant questions will not actually be deleted for view history/result purpose
		//The system will perform updating the delete status of topic and question instead of delete
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_topic'])) {
			$topicid = $_POST['delete_topic'];

			//Delete the topic
			$deletetopicSql = "UPDATE topic SET TopicDeleteStatus = 'D' WHERE TopicID = '$topicid'";
			$deletetopicResult = mysqli_query($connection, $deletetopicSql);
			
			//Delete the topic's question
			$deletequestSql = "UPDATE question SET QuestDeleteStatus = 'D' WHERE TopicID='$topicid'";
			$deletequestResult = mysqli_query($connection, $deletequestSql);
			
			//Delete the topic's resource
			$deleteresSql = "DELETE FROM resources WHERE TopicID = '$topicid'";
			$deleteresResult = mysqli_query($connection, $deletequestSql);

			if ($deletetopicResult && $deletequestResult && $deleteresResult) {
				echo '<script>alert("Topic and its relavant questions and resources deleted successfully!")</script>';
				echo "window.history.pushState({}, '', 'topic_view.php');";
			} else {
				echo '<script>alert("Failed to delete topic and its relevant questions and resources")</script>'.mysqli_error($connection);
			}
		}

		
        //To get the Topic ID and Topic Name
		$sql="SELECT TopicID, TopicName, AnsTimeLimit FROM topic WHERE TopicDeleteStatus = 'N'";
		$result = mysqli_query($connection,$sql);
		$num = 1;
		while($row = mysqli_fetch_array($result)){
			$topicid = $row["TopicID"];
			echo 
				'<tr>
					<td>'.$num.'</td>
					<td>'.$row["TopicName"].'</td>
					<td>'.$row["AnsTimeLimit"].'</td>
					<td>
						<form action = "question_view.php" method="get">
							<input type="hidden" name="topicID" value="'. $topicid .'">
							<button type="submit">Question</button>
						</form>
					</td>
                    <td>
						<form action = "resource_view.php" method="get">
							<input type="hidden" name="topicID" value="'. $topicid .'">
							<button type="submit">Resource</button>
						</form>
					</td>
                    <td>
						<form action="topic_view.php" method="post" onsubmit="return confirmDelete()">
							<input type="hidden" name="delete_topic" value="'.$topicid.'">
							<button type="submit">Delete</button>
						</form>
					</td>
					<td>
						<form action = "topic_updateform.php" method="post">
							<input type="hidden" name="update_topic" value="'. $topicid .'">
							<button type="submit">Update</button>
						</form>
					</td>
				</tr>';
			$num = $num +1;
		}
	?>
	</table>
	<div class="buttons-row">
		<button class="print" onclick="window.print()">Print</button>
		<button class="back" onclick="goBack();">Back</button>
	</div>

</div>