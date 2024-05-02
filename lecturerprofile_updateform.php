<?php
	include('secure.php');
	include('connection.php');
	$LecID = $_SESSION['userid'];
	$sql = "SELECT * FROM lecturer WHERE LecID = '$LecID'";
	$result = mysqli_query($connection, $sql);
	// Check if the query was successful
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		$LecName = $row["LecName"];
		$LecPw = $row["LecPw"];
		$LecEmail = $row["LecEmail"];
		$LecDob = $row["LecDob"];
		$LecGender = $row["LecGender"];
		$LecEduQua = $row["LecEduQua"];
		$LecType = $row['LecType'];
		 // Include navigation based on the lecturer type
		if ($LecType == 1) {
			include('nav_hom.php');
		} elseif ($LecType == 2) {
			include('nav_lec.php');
		}
	}
?>
<body>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
	<link rel="stylesheet" href="form2.css">
	<link rel="stylesheet" href="button.css">
	
	<div class="content">
		<h3 class="header">UPDATE PROFILE</h3>
		<form class="form" action="lecturerprofile_update.php" method="post">
			<table>
				<tr>
					<td>Lecturer Name</td>
					<td><input type="text"name="LecName" value="<?php echo $LecName;?>" required></td>

				</tr>
				<tr>
					<td>Lecturer ID</td>
					<td><input type="text" name="LecID" value="<?php echo $LecID; ?>" readonly></td>

				</tr>
				<tr>
					<td>Email</td>
					<td><input type="email"name="LecEmail" value="<?php echo $LecEmail;?>" required></td>

				</tr>
				<tr>
					<td>Gender</td>
						<td>
							<input type="radio" name="LecGender" value="F" id="femaleRadio" <?php echo ($LecGender === 'F') ? 'checked' : ''; ?> required>
							<label for="femaleRadio">Female</label>
							<input type="radio" name="LecGender" value="M" id="maleRadio" <?php echo ($LecGender === 'M') ? 'checked' : ''; ?>>
							<label for="maleRadio">Male</label>
						</td>
				</tr>
				<tr>
					<td>Date of Birth</td>
					<td><input type="date" name="LecDob" id="dob" value="<?php echo $LecDob;?>" oninput="validateDOB();" required></td>
				</tr>
				<tr>
					<td>Lecturer Educational Qualification</td>
					<td><input type="text"name="LecEduQua" value="<?php echo $LecEduQua;?>" required></td>
				</tr>
				<tr>
					<td>Password</td>
					<td>
						<input type="password" name="LecPw" autocomplete="current-password" placeholder="Password must be 6-8 characters" minlength="6" maxlength="8" required id="password">
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
</body>