<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="form2.css">
    <link rel="stylesheet" href="button.css">
    <title>Select Role</title>

    <?php
    include('connection.php');
	include('footer.php');
    session_start();


    if(isset($_POST['role'])) {
        $role = $_POST['role'];
        if ($role == 'lecturer') {
            header('location:sign_up.php?role=lecturer');
        } else if ($role == 'student') {
            header('location:sign_up.php?role=student');
        }
    }
    ?>
</head>
<body>
    <div class="container">
        <h3 class="header">
            Select Role
        </h3>
        <form method="post" class="form">
            <div class="buttons-row">
                <select name="role" id="role">
                    <option value="" disabled selected>-- Please Select --</option>
                    <option value="lecturer">Lecturer</option>
                    <option value="student">Student</option>
                </select>
                <button class="submit" type="submit">Submit</button>
            </div>
        </form>
    </div>

</body>
</html>