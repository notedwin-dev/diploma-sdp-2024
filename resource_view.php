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
	//Check the previous page URL
	var previousPage = document.referrer;
	var lecType = <?php echo $LecType; ?>;

	//Define a function to handle back button click
	function handleBackClick() {
		if (previousPage.includes('resource_lecview_selecttopic.php')) {
			window.location.href = 'resource_lecview_selecttopic.php';
		} else if (previousPage.includes('topic_view.php')){
			window.location.href = 'topic_view.php';
		} else{
			if (lecType == 1) {
				window.location.href = 'home_hom.php';
			} else if (lecType == 2) {
				window.location.href = 'home_lecturer.php';
			}
		}
	}
</script>
<?php
	$topicID = $_GET['topicID'];
	
	$topicSql = "SELECT * FROM topic WHERE TopicID = '$topicID'";
	$topicResult = mysqli_query($connection, $topicSql);
	//Get the topic name from the result
    $topicRow = mysqli_fetch_assoc($topicResult);
    if ($topicRow) {
		$topicname = $topicRow['TopicName'];
	}
	
	//Check if the form is submitted for the delete function
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_resource'])) {
		$ResID = $_POST['delete_resource'];
		$topicID = $_POST['topicID'];
		echo '<script>
				var confirmDelete = confirm("Are you sure you want to delete this resource?");
				if (confirmDelete) {
					window.location.href = "resource_delete.php?ResID='.$ResID.'&topicID='.$topicID.'";
				} else {
					// User clicked cancel, stay on the current page
					window.location.href = "resource_view.php?topicID=' . $topicID . '";
				}
			  </script>';
	}
	
	//Get the Resource ID, Resource Name, and Resource Type based on the topic selected
	$sql = "SELECT ResID, ResName FROM resources WHERE TopicID = '$topicID'";
	$result = mysqli_query($connection, $sql);
	if ($result && mysqli_num_rows($result) > 0) {
        $num = 1;
?>
<link rel="stylesheet" href="button.css">
<link rel="stylesheet" href="table2.css">
<div class="content">
	<table>
		<caption><?php echo $topicname."'s"; ?> Notes</caption>
		<tr>
			<th>No.</th>
			<th>Resource Name</th>
			<th>Download</th>
			<th>Delete</th>
			<th>Update</th>
		</tr>

	<?php
			while ($row = mysqli_fetch_array($result)) {
				echo 
					'<tr>
						<td class="num">' . $num . '</td>
						<td>' . $row["ResName"] . '</td>
						<td>
							<form action="download.php" method="get">
								<input type="hidden" name="ResID" value="'.$row["ResID"].'">
								<button type="submit">Download</button>
							</form>
						</td>
						<td>
							<form action="resource_view.php" method="post" onsubmit="return confirmDelete()">
								<input type="hidden" name="delete_resource" value="' . $row["ResID"] . '">
								<input type="hidden" name="topicID" value="' . $topicID . '">
								<button type="submit">Delete</button>
							</form>
						</td>
						<td>
							<form action="resource_updateform.php" method="post">
								<input type="hidden" name="update_resource" value="' . $row["ResID"] . '">
								<input type="hidden" name="topicID" value="' . $topicID . '">
								<button type="submit">Update</button>
							</form>
						</td>
					</tr>';
				$num = $num + 1;
			}
	}else {
		echo '<script>alert("No resources available for this topic."); handleBackClick();</script>'; 
		exit(); // Ensure that the script stops execution after the redirect
	}
	?>
	</table>
	<button class="back" onclick = "handleBackClick()">Back</button>
</div>