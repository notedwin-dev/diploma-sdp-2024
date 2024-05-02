<?php
	include('secure.php');
	include('connection.php');
	$ResID = $_POST["update_resource"];
	$TopicID = $_POST["topicID"];
	$LecID = $_SESSION['userid'];
	$lecSql = "SELECT LecType FROM lecturer WHERE LecID = '$LecID'";
	$lecResult = mysqli_query($connection, $lecSql);
	if ($lecResult) {
		$row = mysqli_fetch_assoc($lecResult);
		$LecType = $row['LecType'];
		if ($LecType == 1) {
			include('nav_hom.php');
		} elseif ($LecType == 2) {
			include('nav_lec.php');
		}
	}
	$resSql = "SELECT * FROM resources WHERE ResID='$ResID'";
	$resResult = mysqli_query($connection, $resSql);
	$resRow = mysqli_fetch_assoc($resResult);
	$ResName = $resRow['ResName'];
?>
<script>
	function validateForm() {
		var topicSelect = document.getElementById("idtopic");
		var selectedValue = topicSelect.value;

		if (selectedValue === "") {
			alert("Please select a topic before starting.");
			return false; // Prevent form submission
		}

		// Allow form submission if a topic is selected
		return true;
	}
</script>
<link rel="stylesheet" href="form2.css">
<link rel="stylesheet" href="button.css">
<div class="content">
    <h3 class="header">Update Resource</h3>
    <form class="form" action="resource_update.php" method="post" onsubmit="return validateForm()">
        <table>
            <tr>
                <td>Resource ID</td>
                <td><input type="hidden" name="ResID" value="<?php echo $ResID; ?>" readonly><?php echo $ResID; ?></td>
            </tr>

            <tr>
                <td>Resource's Name</td>
                <td><input type="text" name="ResName" value = "<?php echo $ResName; ?>" required></td>
            </tr>
			<tr>
				<td>Topic</td>
				<td>
					<select class="topic" name="topicID" id="idtopic">
					<option value="" disabled selected>Select topic</option>
					<?php
						$sql = "SELECT * FROM topic WHERE TopicDeleteStatus = 'N'";
						$data = mysqli_query($connection, $sql);
						while ($topic = mysqli_fetch_array($data)) {
							$selected = ($topic['TopicID'] == $TopicID) ? 'selected' : '';
							echo "<option value='$topic[TopicID]' $selected>$topic[TopicName]</option>";
						}
					?>
					</select>
				</td>
			</tr>
        </table>
		<div class="buttons-row">
			<button class="submit" type="submit">Update</button>
			<button class="back" onclick = "window.history.go(-1); return false;">Back</button>
		</div>
    </form>
</div>