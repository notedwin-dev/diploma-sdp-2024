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
<div class="content">
    <h3 class="header">Add New Topic</h3>
    <form class="form" action="topic_insert.php" method="post">
        <table>
            <tr>
                <td>Name</td>
                <td><input type="text" name="topicname"required></td>
            </tr>
			
			<tr>
                <td>Answer Time Limit</td>
                <td><input type="number" name="anstimelimit" oninput="validateTime();" required></td>
            </tr>
        </table>
		<div class="buttons-row">
			<button class="submit" type="submit">Insert</button>
			<button class="back" onclick="goBack();">Back</button>
		</div>
    </form>
</div>
