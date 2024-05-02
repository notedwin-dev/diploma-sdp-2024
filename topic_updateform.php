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
	$TopicID = $_POST["update_topic"];
	$topicSql = "SELECT * FROM topic WHERE TopicID = '$TopicID'";
	$topicResult = mysqli_query($connection,$topicSql);
	$topicRow = mysqli_fetch_assoc($topicResult);
	$TopicName = $topicRow['TopicName'];
	$AnsTimeLimit = $topicRow['AnsTimeLimit'];
?>
<script>
	function validateTime() {
		var timeLimitInput = document.getElementsByName("anstimelimit")[0];
		var enteredValue = timeLimitInput.value;

		if (enteredValue <= 0 || isNaN(enteredValue)) {
			alert("Please enter a positive value for the time limit.");
			timeLimitInput.value = "";  // Reset the input field
		}
	}
</script>
<link rel="stylesheet" href="form2.css">
<link rel="stylesheet" href="button.css">
<div class ="content">
	<h3 class="header">Update Topic</h3>
	<form class="form" action="topic_update.php" method="post">
		<table>
			<tr>
				<td>Topic ID</td>
				<td><input type="hidden" name="topicid" value="<?php echo $TopicID; ?>"><?php echo $TopicID;?></td>
			</tr>
		
			<tr>
				<td>Topic's Name</td>
				<td><input type="text" name="topicname" value="<?php echo $TopicName;?>" required></td>
			</tr>
			
			<tr>
				<td>Topic's Answer Time Limit</td>
				<td><input type="number" name="anstimelimit" oninput="validateTime();" value="<?php echo $AnsTimeLimit;?>" required></td>
			</tr>
		</table>
		<div class="buttons-row">
			<button class="submit" type="submit">Update</button>
			<button class="back" onclick = "window.history.go(-1); return false;">Back</button>
		</div>
	</form>
</div>