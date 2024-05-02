<?php
	include('secure.php');
	include('nav_stu.php');
	include('connection.php');
	
	$StuID = $_SESSION['userid'];
	$sql = "SELECT * FROM student WHERE StuID = '$StuID'";
	$result = mysqli_query($connection, $sql);
	
	if ($result) {
		$row = mysqli_fetch_assoc($result);

		$StuName = $row['StuName'];
		$StuID = $row['StuID'];
		$StuEmail = $row['StuEmail'];
		$StuGender = $row['StuGender'];
		$StuDob = $row['StuDob'];
		$StuUni = $row['StuUni'];
	} else {
		die("Error in SQL query: " . mysqli_error($connection));
	}
?>
<link rel="stylesheet" href="button.css">
<link rel="stylesheet" href="table2.css">
<div class = "content">
	<h1>My Profile</h1>
	<table class="profile">
		<tr>
			<td>User Name</td>
			<td><?php echo $StuName; ?></td>
		</tr>
		<tr>
			<td>User ID</td>
			<td><?php echo $StuID; ?></td>
		</tr>
		<tr>
			<td>User Email</td>
			<td><?php echo $StuEmail; ?></td>
		</tr>
		<tr>
			<td>Gender</td>
			<td><?php echo $StuGender; ?></td>

		</tr>
		<tr>
			<td>Date of Birth</td>
			<td><?php echo $StuDob; ?></td>
		</tr>
		<tr>
			<td>User University</td>
			<td><?php echo $StuUni; ?></td>
		</tr>
		<tr class="link">
			<td colspan="2">Want to update your profile? <a href="studentprofile_updateform.php?StuID=<?php echo $StuID; ?>">Update Profile</a></td>
		</tr>
	</table>
	<button class="back" onclick = "window.location.href = 'home_student.php'">Back</button>
</div>