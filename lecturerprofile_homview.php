<?php
	include('secure.php');
	include('connection.php');
	include('nav_hom.php');
	
	$LecID = $_POST['lecid'];
	$sql = "SELECT * FROM lecturer WHERE LecID = '$LecID'";
	$result = mysqli_query($connection, $sql);
	
	if ($result) {
		$row = mysqli_fetch_assoc($result);

		//Get the profile details of the selected lecturer
		$LecID = $row["LecID"];
		$LecName = $row["LecName"];
		$LecEmail = $row["LecEmail"];
		$LecDob = $row["LecDob"];
		$LecGender = $row["LecGender"];
		$LecEduQua = $row["LecEduQua"];
		$LecType = $row['LecType'];
	} else {
		die("Error in SQL query: " . mysqli_error($connection));
	}
?>
<link rel="stylesheet" href="button.css">
<link rel="stylesheet" href="table2.css">
<body>
	<div class = 'content'>
		<h1><?php echo $LecName;?>'s Profile</h1>
		<table class="profile">
			<tr>
				<td>Lecturer ID</td>
				<td><?php echo $LecID; ?></td>
			</tr>
			<tr>
				<td>Lecturer Name</td>
				<td><?php echo $LecName; ?></td>
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
			<tr>
				<td>Lecturer Educational Qualification</td>
				<td><?php echo $LecEduQua; ?></td>
			</tr>
		</table>
		<button class="back" onclick = "window.location.href = 'lecturer_view.php';">Back</button>
	</div>
</body>