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
	function goBack() {
		var lecType = <?php echo $LecType; ?>;

		if (lecType == 1) {
			window.location.href = 'home_hom.php';
		} else if (lecType == 2) {
			window.location.href = 'home_lecturer.php';
		}
	}
</script>
<link rel="stylesheet" href="form2.css">
<link rel="stylesheet" href="button.css">
<div class="content">
    <h3 class="header">Add New Resources</h3>
    <form class="form" action="resource_insert.php" enctype="multipart/form-data" method="post">
        <table>
            <tr>
                <td>Resource Name</td>
                <td><input type="text" name="resname" required></td>
            </tr>
			
			<tr>
				<td>Topic Name</td>
				<td>
					<select name="topicid">
					<option value="" disabled selected>Select topic</option>
					<?php
						$sql="SELECT * FROM topic WHERE TopicDeleteStatus = 'N'";
						$data = mysqli_query($connection,$sql);
						while($topic = mysqli_fetch_array($data)){
							echo "<option value='$topic[TopicID]'>$topic[TopicName]</option>";
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Upload File</td>
				<td>
					<input type = "file" name="resfile" accept=".pdf" required>
				</td>
			</tr>
			<tr><td colspan="2">Note: Please upload PDF files.</td></tr>
        </table>
		<div class="buttons-row">
			<button class="submit" type="submit" name="insert">Upload</button>
			<button class="back" onclick="goBack();">Back</button>
		</div>
    </form>
</div>