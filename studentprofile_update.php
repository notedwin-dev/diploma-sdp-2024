<?php
	include('secure.php');
	include('connection.php');
	
	$StuID = $_POST["StuID"];
	$StuName = $_POST["StuName"];
    $studentname = $_POST["StuName"];
    $StuPw = $_POST["StuPw"];
    $StuEmail = $_POST["StuEmail"];
    $StuGender = $_POST["StuGender"];
    $StuDob = $_POST["StuDob"];
    $StuUni = $_POST["StuUni"];
	
	//Check if the value of password and confirm password is the same
	$confirmPassword = $_POST["confirmPassword"];
    if ($StuPw != $confirmPassword) {
        echo "<script>alert('Password and Confirm Password do not match. Please try again.')</script>";
		echo "<script>window.location.href='studentprofile_updateform.php?StuID=".$StuID."'</script>";
    } else {
		//Update modified student details
        $sql = "UPDATE student SET StuName='$StuName', StuPw='$StuPw', StuEmail='$StuEmail', 
        StuGender='$StuGender', StuDob='$StuDob', StuUni='$StuUni' WHERE StuID='$StuID'";
		$result = mysqli_query($connection,$sql);
		if (mysqli_affected_rows($connection) > 0) {
			//Get the updated student name from the database
			$updatedUsernameQuery = "SELECT StuName FROM student WHERE StuID='$StuID'";
			$updatedUsernameResult = mysqli_query($connection, $updatedUsernameQuery);
			
			if ($updatedUsernameRow = mysqli_fetch_assoc($updatedUsernameResult)) {
				$updatedUsername = $updatedUsernameRow['StuName'];
				
				//Update student's session username
				$_SESSION['username'] = $updatedUsername;
			}
			echo "<script>alert('Profile Updated Successfully');</script>";
			echo "<script>window.location.href = 'studentprofile_view.php';</script>"; // Redirect to topic_view.php on success
		} else {
			echo "<script>alert('Profile Update Failed');</script>";
			echo "<script>window.history.back();</script>"; // Go back to the previous page on failure
		}
    }
?>