<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Network Insight</title>
    <?php
        include('connection.php');
        include('footer.php');
        session_start();

        if (isset($_POST['userid'])) {
            $userid = $_POST['userid'];
            $password = $_POST['password'];
            $sql = "SELECT * FROM student";
            $result = mysqli_query($connection, $sql);
            $try = FALSE;

            while ($student = mysqli_fetch_array($result)) {
                // Check if the user is a student
                if ($student['StuID'] == $userid && $student["StuPw"] == $password) {
                    $try = TRUE;
                    $_SESSION['userid'] = $student['StuID'];
                    $_SESSION['username'] = $student['StuName'];
                    $_SESSION['status'] = 'student';
                    break;
                }
            }

            // Check if the user is a lecturer / head of module
            if ($try == FALSE) {
                $sql = "SELECT * FROM lecturer";
                $result = mysqli_query($connection, $sql);

                while ($lecturer = mysqli_fetch_array($result)) {
                    if ($lecturer['LecID'] == $userid && $lecturer["LecPw"] == $password) {
                        $try = TRUE;
                        $_SESSION['userid'] = $lecturer['LecID'];
                        $_SESSION['username'] = $lecturer['LecName'];

                        // Set the user status based on the lecturer type
                        if ($lecturer['LecType'] == "1") {
                            $_SESSION['status'] = 'hom';
                        } else {
                            $_SESSION['status'] = 'lecturer';
                        }
                        break;
                    }
                }
            }

            // Direct the user to their corresponding home page based on the user status
            if ($try == TRUE) {
                if ($_SESSION['status'] == 'student') {
                    header('Location: home_student.php');
                } elseif ($_SESSION['status'] == 'lecturer') {
                    header('Location: home_lecturer.php');
                } else {
                    header('Location: home_hom.php');
                }
            } else {
                echo "<script>
                        alert('Wrong User ID / Password. Please Try Again.');
                        window.location='sign_in.php'
                    </script>";
            }
        }
    ?>
</head>
<body>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<link rel="stylesheet" href="navbar.css">
<link rel="stylesheet" href="button.css">
<link rel="stylesheet" href="form2.css">
<center>
	<img src='networkinsight.png'>
    <h3 class="header">Sign In</h3>
    <form action="sign_in.php" method="post" class="form">
		<table>
			<tr>
				<td><img src="user.png"></td>
				<td><input type="text" name="userid" placeholder="User ID" required></td>
			</tr>
			<tr>
				<td><img src="lock.png"></td>
				<td>
					<input type="password" name="password" id="password" placeholder="Password" maxlength="8" required>
					<i class="bi bi-eye-slash" id="togglePassword"></i>
				</td>
			</tr>
		</table>
		<p class="signup-text">Don't have an account? <a href="sign_up.php" class="link">Sign up</a></p>
		<div class="buttons-row">
			<button class="submit" type="submit">Login</button>
			<button class="back" type="button" onclick="window.location='index.php'">Back</button>
		</div>
    </form>
</center>
<script src="togglePassword.js"></script>
</body>
</html>
