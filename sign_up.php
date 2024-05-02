<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NETWORK INSIGHT</title>
</head>
<body>
<?php
	include('connection.php');
	include('footer.php');
	
	//Function to generate random student ID
	function generateRandomStudentID($connection) {
		//Fixed prefix "TP"
		$prefix = "TP";

		do {
			//Generate random 6-digit number
			$randomNumber = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

			//Concatenate prefix and random number
			$studentID = $prefix . $randomNumber;
		} while (isStudentIDTaken($connection, $studentID));

		return $studentID;
	}
	
	//Function to check if the generated student ID exists in the database
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

	if(isset($_POST['signup'])){
		$StuID = $_POST["StuID"];
		$StuName = $_POST["StuName"];
		$StuPw = $_POST["StuPw"];
		$StuEmail = $_POST["StuEmail"];
		$StuGender = $_POST["StuGender"];
		$StuDob = $_POST["StuDob"];
		$StuUni = $_POST["StuUni"];
		//Check if the password and confirm password match
		$confirmPassword = $_POST["confirmPassword"];
		if ($StuPw != $confirmPassword) {
			echo "<script>alert('Password and Confirm Password do not match. Please try again.')</script>";
		} else {
			$sql = "INSERT INTO student VALUES('$StuID','$StuName','$StuPw','$StuEmail','$StuDob','$StuGender','$StuUni')";
			$result = mysqli_query($connection, $sql);
			if($result) {
				echo "<script>alert('Congratulations! Your Account Has Been Successfully Created!')</script>";
				echo "<script>window.location='sign_in.php'</script>";
			} else {
				echo "<script>alert('Failed To Sign Up')</script>";
				echo "<script>window.history.back();</script>";
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
	<img src='networkinsight.png'>
    <h3 class="header">Sign up</h3>
    <form class="form" method="post">
	<p>Create an account to learn more now!</p>
        <table>
            <tr>
                <td>Student ID</td>
                <td><input type="text" name="StuID" value="<?php echo generateRandomStudentID($connection); ?>" readonly></td>
            </tr>
            <tr>
                <td>Name</td>
                <td><input type="text" name="StuName" required></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="email" name="StuEmail" required></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>
                    <input type="radio" name="StuGender" value="F" id="femaleRadio" required>
					<label for="femaleRadio">Female</label>
					<input type="radio" name="StuGender" value="M" id="maleRadio">
					<label for="maleRadio">Male</label>
                </td>
            </tr>
            <tr>
                <td>Date of Birth</td>
                <td><input type="date" name="StuDob" id="dob" oninput="validateDOB();" required></td>
            </tr>
            <tr>
				<td>Password</td>
				<td>
					<input type="password" name="StuPw" id="password" placeholder="Password must be 6-8 characters" minlength="6" maxlength="8" required>
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
            <tr>
                <td>Student University</td>
                <td><input type="text" name="StuUni"></td>
            </tr>
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