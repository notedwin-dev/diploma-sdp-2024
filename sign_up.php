<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APHUB</title>
</head>
<body>
<?php
	include('connection.php');
	include('footer.php');
	
	//Function to check if the student ID exists in the database
	function isStudentIDTaken($connection, $studentID) {
		$query = "SELECT COUNT(*) as count FROM student WHERE StuID = '$studentID'";
		$result = mysqli_query($connection, $query);

		if ($result) {
			$row = mysqli_fetch_assoc($result);
			return $row['count'] > 0;
		}

		//Error occurred while checking the database
		return false;
	}

	if(isset($_GET['role'])){
		//Get the role from URL parameter
		$role = $_GET['role'];

		//modify the title based on the role
		if ($role == 'student') {
			$title = "Student Sign Up";
			$id_label = "Student ID";
			$id_name = "StuID";
			$user_name = "StuName";
			$user_email = "StuEmail";
			$user_gender = "StuGender";
			$user_dob = "StuDob";
			$user_password = "StuPw";
			$user_edu = "StuUni";
		} else if ($role == 'lecturer') {
			$title = "Lecturer Sign Up";
			$id_label = "Lecturer ID";
			$id_name = "LecID";
			$user_name = "LecName";
			$user_email = "LecEmail";
			$user_gender = "LecGender";
			$user_dob = "LecDob";
			$user_password = "LecPw";
			$user_edu = "LecEduQua";
		}
	}

	if(isset($_POST['signup'])){
		$ID = $_POST[$id_name];
		$Name = $_POST[$user_name];
		$Pw = $_POST[$user_password];
		$Email = $_POST[$user_email];
		$Gender = $_POST[$user_gender];
		$Dob = $_POST[$user_dob];
		$Uni = $_POST[$user_edu];
		

		//Check if the password and confirm password match
		$confirmPassword = $_POST["confirmPassword"];
		if ($Pw != $confirmPassword) {
			echo "<script>alert('Password and Confirm Password do not match. Please try again.')</script>";
		} else {
			if ($role == 'student') {
				//Check if the student ID is already taken
				if (isStudentIDTaken($connection, $ID)) {
					echo "<script>alert('Student ID is already taken. Please try again.')</script>";
					echo "<script>window.history.back();</script>";
				} else {
					$sql = "INSERT INTO $role VALUES('$ID','$Name','$Pw','$Email','$Dob','$Gender','$Uni')";

					if($result) {
						echo "<script>alert('Congratulations! Your Account Has Been Successfully Created!')</script>";
						echo "<script>window.location='sign_in.php'</script>";
					} else {
						echo mysqli_error($connection);
						echo "<script>window.history.back();</script>";
					}
				}
			} else if ($role == 'lecturer') {
				$sql = "INSERT INTO $role VALUES('$ID','$Name','$Pw','$Email','$Dob','$Gender','$Uni', 2)";
				$result = mysqli_query($connection, $sql);

				if($result) {
					echo "<script>alert('Congratulations! Your Account Has Been Successfully Created!')</script>";
					echo "<script>window.location='sign_in.php'</script>";
				} else {
					echo mysqli_error($connection);
					echo "<script>window.history.back();</script>";
				}
			}
			
		}
	}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<link rel="stylesheet" href="navbar.css">
<link rel="stylesheet" href="form2.css">
<link rel="stylesheet" href="button.css">
<center>
<div class="container">
	<img src='logo.png'>
    <h3 class="header">
		<?php echo $title; ?>
	</h3>
    <form class="form" method="post">
	<p>Create an account to learn more now!</p>
        <table>
            <tr>
                <td>
					<?php echo $id_label; ?>
				</td>
                <td><input type="text" 
				name=
				<?php echo 
					$id_name; 
				?> value=""></td>
            </tr>
            <tr>
                <td>Name</td>
                <td><input type="text" name=<?php echo 
				$user_name; ?> required></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="email" name=<?php echo 
				$user_email; ?> required></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>
                    <input type="radio" name=<?php
						echo $user_gender;
					?> value="F" id="femaleRadio" required>
					<label for="femaleRadio">Female</label>
					<input type="radio" name=<?php
						echo $user_gender;
					?> value="M" id="maleRadio">
					<label for="maleRadio">Male</label>
                </td>
            </tr>
            <tr>
                <td>Date of Birth</td>
                <td><input type="date" name=<?php
						echo $user_dob;
					?> id="dob" oninput="validateDOB();" required></td>
            </tr>
            <tr>
				<td>Password</td>
				<td>
					<input type="password" name=<?php
						echo $user_password;
					?> id="password" placeholder="Password must be 8-20 characters" minlength="8" maxlength="20" required>
					<i class="bi bi-eye-slash" id="togglePassword"></i>
				</td>
			</tr>
			<tr>
				<td>Confirm Password</td>
				<td>
					<input type="password" name="confirmPassword" id="confirmPassword" required>
					<i class="bi bi-eye-slash" id="toggleConfirmPassword"></i>
				</td>
			</tr>

			<?php 

			if ($role == 'student') {
				echo '<tr><td>Student University</td><td><input type="text" name="StuUni"></td></tr>';
			} else if ($role == 'lecturer') {
				echo "<tr>
				<td>
					Lecturer Education Qualification
				</td>
				<td>
					<input type='text' name='$user_edu'>
				</td>
				</tr>";
			}

			?>
        </table>
		<div class="buttons-row">
			<button class="submit" type="submit" name="signup">Sign up</button>
			<button class="back" onclick = "window.history.go(-1); return false;">Back</button>
		</div>
    </form>
</div>
</center>
<script src="dateValidation.js"></script>
<script src="togglePassword.js"></script>
</body>
</html>