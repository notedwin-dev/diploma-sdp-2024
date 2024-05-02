<?php
	include('secure.php');
	include('nav_stu.php');
	include('connection.php');
	
	$StuID = $_GET['StuID'];
	$sql = "SELECT * FROM student WHERE StuID = '$StuID'";
	$result = mysqli_query($connection, $sql);
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		$StuName = $row["StuName"];
		$StuPw = $row["StuPw"];
		$StuEmail = $row["StuEmail"];
		$StuDob = $row["StuDob"];
		$StuGender = $row["StuGender"];
		$StuUni = $row["StuUni"];
	}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<link rel="stylesheet" href="button.css">
<link rel="stylesheet" href="form2.css">
<div class="content">
	<h3 class="header">UPDATE PROFILE</h3>
	<form class="form" action="studentprofile_update.php" method="post">
		<table>
			<tr>
				<td>User Name</td>
				<td><input type="text" name="StuName" value="<?php echo $StuName; ?>" required></td>
			</tr>
			<tr>
				<td>User ID</td>
				<td><input type="text" name="StuID" value="<?php echo $StuID; ?>" readonly></td>
			</tr>
			<tr>
				<td>User Email</td>
				<td><input type="email" name="StuEmail" value="<?php echo $StuEmail; ?>" required></td>
			</tr>
			<tr>
				<td>Gender</td>
				<td>
					<input type="radio" name="StuGender" value="F" id="femaleRadio" <?php echo ($StuGender === 'F') ? 'checked' : ''; ?> required>
					<label for="femaleRadio">Female</label>
					<input type="radio" name="StuGender" value="M" id="maleRadio" <?php echo ($StuGender === 'M') ? 'checked' : ''; ?>>
					<label for="maleRadio">Male</label>
				</td>
			</tr>
			<tr>
				
				<td>Date of Birth</td>
				<td><input type="date" name="StuDob" id="dob" value="<?php echo $StuDob; ?>" oninput="validateDOB();" required></td>
			</tr>
			<tr>
				<td>User University</td>
				<td><input type="text" name="StuUni" value="<?php echo $StuUni; ?>"required></td>
			</tr>
			
			<tr>
				<td>Password</td>
				<td>
					<input type="password" name="StuPw" autocomplete="current-password" placeholder="Password must be 6-8 characters" minlength="6" maxlength="8" required id="password">
					<i class="bi bi-eye-slash" id="togglePassword"></i>
				</td>
			</tr>
			
				
			<tr>
				<td>Confirm Password</td>
				<td>
					<input type="password" name="confirmPassword" autocomplete="current-password" required id="confirmPassword">
					<i class="bi bi-eye-slash" id="toggleConfirmPassword"></i>
				</td>
			</tr>
		</table>
		<div class="buttons-row">
			<button class="submit" type="submit">Confirm</button>
			<button class="back" onclick = "window.history.go(-1); return false;">Back</button>
		</div>
	</form>
</div>
<script src="dateValidation.js"></script>
<script src="togglePassword.js"></script>