<?php
	include('secure.php');
	include('connection.php');
	
	$LecID = $_POST["LecID"];
	$LecName = $_POST["LecName"];
	$LecPw = $_POST["LecPw"];
	$LecDob = $_POST["LecDob"];
	$LecEmail = $_POST["LecEmail"];
	$LecGender = $_POST["LecGender"];
	$LecEduQua = $_POST["LecEduQua"];
	$confirmPassword = $_POST["confirmPassword"];
	
	//Check if the value of password and confirm password is the same
    if ($LecPw != $confirmPassword) {
        echo "<script>alert('Password and Confirm Password do not match. Please try again.')</script>";
		echo "<script>window.location.href='lecturerprofile_updateform.php?LecID=".$LecID."'</script>";
    } else {
		//Update modified lecturer details
        $sql = "UPDATE lecturer SET LecName='$LecName', LecPw='$LecPw', LecEmail='$LecEmail', LecDob='$LecDob',
        LecGender='$LecGender', LecEduQua='$LecEduQua' WHERE LecID='$LecID'";
		$result = mysqli_query($connection,$sql);
		
        if (mysqli_affected_rows($connection) > 0) {
			//Get the updated lecturer name from the database
			$updatedUsernameQuery = "SELECT LecName FROM lecturer WHERE LecID='$LecID'";
			$updatedUsernameResult = mysqli_query($connection, $updatedUsernameQuery);
			
			if ($updatedUsernameRow = mysqli_fetch_assoc($updatedUsernameResult)) {
				$updatedUsername = $updatedUsernameRow['LecName'];
				
				//Update lecturer's session username
				$_SESSION['username'] = $updatedUsername;
			}
			echo "<script>alert('Profile Updated Successfully');</script>";
			echo "<script>window.location.href = 'lecturerprofile_view.php';</script>"; // Redirect to topic_view.php on success
		} else {
			echo "<script>alert('Profile Update Failed');</script>";
			echo "<script>window.history.back();</script>"; // Go back to the previous page on failure
		}
    }
?>