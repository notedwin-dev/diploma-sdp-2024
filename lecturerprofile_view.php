<?php
	include('secure.php');
	include('connection.php');
	
	$LecID = $_SESSION['userid'];
	$sql = "SELECT * FROM lecturer WHERE LecID = '$LecID'";
	$result = mysqli_query($connection, $sql);
	
	if ($result) {
		$row = mysqli_fetch_assoc($result);

		$LecID = $row["LecID"];
		$LecName = $row["LecName"];
		$LecEmail = $row["LecEmail"];
		$LecDob = $row["LecDob"];
		$LecGender = $row["LecGender"];
		$LecEduQua = $row["LecEduQua"];
		$LecType = $row['LecType'];
		if ($LecType == 1) {
			include('nav_hom.php');
		} elseif ($LecType == 2) {
			include('nav_lec.php');
		}
	} else {
		die("Error in SQL query: " . mysqli_error($connection));
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
<link rel="stylesheet" href="button.css">
<link rel="stylesheet" href="table2.css">
<body>
	<div class = "content">  
		<h1>My Profile</h1>
		<table class="profile">
			<tr>
				<td>Lecturer Name</td>
				<td><?php echo $LecName; ?></td>
			</tr>
			<tr>

				<td>Lecturer ID</td>
				<td><?php echo $LecID; ?></td>
			</tr>
			<tr>
				<td>Lecturer Email</td>
				<td><?php echo $LecEmail; ?></td>
			</tr>
			<tr>
				<td>Lecturer DOB</td>
				<td><?php echo $LecDob; ?></td>
			</tr>
			
			<tr>
				<td>Gender</td>
				<td><?php echo $LecGender; ?></td>
		
			</tr>
			<tr class="link">
				<td colspan="2">Want to update your profile? <a href="lecturerprofile_updateform.php?LecID=<?php echo $LecID; ?>">Update Profile</a></td>
			</tr>
		</table>
		<button class="back" onclick="goBack();">Back</button>
	</div>
</body>