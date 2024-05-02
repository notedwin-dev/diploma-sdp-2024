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
	
	//Function to generate random lecturer ID
	function generateRandomLecturerID($connection) {
        //Fixed prefix "L"
        $prefix = "L";

        do {
            //Generate random 6-digit number
            $randomNumber = str_pad(mt_rand(1, 999999), 7, '0', STR_PAD_LEFT);

            //Concatenate prefix and random number
            $lecturerID = $prefix . $randomNumber;
        } while (isLecturerIDTaken($connection, $lecturerID));

        return $lecturerID;
    }
	
	//Function to check if the generated lecturer ID exists in the database
    function isLecturerIDTaken($connection, $lecturerID) {
        $query = "SELECT COUNT(*) as count FROM lecturer WHERE LecID = '$lecturerID'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['count'] > 0;
        }

        //Error occurred while checking the database
        return false;
    }
	
	function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); 
		$alphaLength = strlen($alphabet) - 1; 
		
		//Set the password length between 6 and 8 characters
		$passwordLength = rand(6, 8);

		for ($i = 0; $i < $passwordLength; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		
		//Turn the array into a string
		return implode($pass); 
	}
?>
<link rel="stylesheet" href="form2.css">
<link rel="stylesheet" href="button.css">
<script src="dateValidation.js"></script>
<div class="content">
	<h3 class="header">ENROLL NEW LECTURER</h3>
	<form class="form" action="lecturer_insert.php" method="post">
		<table>
			<tr>
				<td>Lecturer ID</td>
				<td><input type="text" name="LecID" value="<?php echo generateRandomLecturerID($connection); ?>" readonly></td>
			</tr>
			<tr>
				<td>Lecturer Name</td>
				<td><input type="text"name="LecName" required></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="text" name="LecPw" value="<?php echo randomPassword(); ?>" readonly></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="email"name="LecEmail" required></td>
			</tr>
			<tr>
				<td>DOB</td>
				<td><input type="date" id="dob" name="LecDob" oninput="validateDOB();" required></td>
			</tr>
			<tr>
				<td>Gender</td>
				<td>
					<input type="radio" name="LecGender" value="F" id="femaleRadio" required>
					<label for="femaleRadio">Female</label>
					<input type="radio" name="LecGender" value="M" id="maleRadio">
					<label for="maleRadio">Male</label>
				</td>
			</tr>
			<tr>
				<td>Educational Qualification</td>
				<td><input type="text" name="LecEduQua" required></td>
			</tr>
		</table>
		<div class="buttons-row">
			<button class="submit" type="submit">Add</button>
			<button class="back" onclick="window.location.href='home_hom.php'">Back</button>
		</div>
	</form>
</div>