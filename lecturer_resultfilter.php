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
?>

<link rel="stylesheet" href="button.css">
<link rel="stylesheet" href="form2.css">

<!-- Display the filter for result-->
<div class="content">
	<center>
	<h3 class="header">REPORT TYPE SELECTION</h3>
	<form class="form" action="lecturer_resultview.php" method="get"  onsubmit="return validateForm()">
		<select id='option' name='option'>
			<option value=1 disabled selected>According to Marks/Grade or Date Time</option>
			<option value=2>Marks & Grade</option>
			<option value=3>Date</option>
		</select>
		<br>
		<!-- Dropdown for Grade -->
		<div id="grade" style="display: none;">
			<select id='gradeSelect'  name="grade" >
				<option value=A>A - More than/ equal 80</option>
				<option value=B>B - More than/ equal 70</option>
				<option value=C>C - More than/ equal 60</option>
				<option value=D>D - More than/ equal 50</option>
				<option value=F>F - Below 40</option>
			</select>
		</div>
		 <!-- Date Selection -->
		<div id="date" style= "display:none;">
			<table>
				<tr>
					<td>Start date</td>
					<td>:</td>
					<td><input type='date' id='startdate' name='startdate'></td>
				</tr>
				<tr>
					<td>End date</td>
					<td>:</td>
					<td><input type='date' id='enddate' name='enddate'></td>
				</tr>
			</table>
		</div>
		<button class="show" type="submit">Show</button>
	</center>
	</form>
</div>
<!-- JavaScript to dynamically show/hide elements based on the selected option -->
<script>
		document.getElementById('option').addEventListener('change',function(){
			var show_marksORgrade = 'none';
			var show_date = 'none';
			var option = this.value;
			
			if(option == 1){
				show_marksORgrade = 'none';
				show_date = 'none';
			}else if(option == 2){
				show_marksORgrade = 'block';
				show_date = 'none';
			}else if(option == 3){
				show_marksORgrade = 'none';
				show_date = 'block';
			}
			document.getElementById('grade').style.display = show_marksORgrade;
			document.getElementById('date').style.display = show_date;
		});

	//Function to validate the form before submission
	function validateForm() {
        var option = document.getElementById('option').value;
        var gradeSelected = document.getElementById('grade').style.display === 'block';
        var startDate = document.getElementById('startdate').value;
        var endDate = document.getElementById('enddate').value;

        if (option == 1) {
            //According to Topics and Date is selected
            if (!gradeSelected && (startDate === '' || endDate === '')) {
                alert('Please select a topic or provide start and end dates.');
                return false;
            }
        } else if (option == 2) {
            //Topics is selected
            if (!gradeSelected) {
                alert('Please select a topic.');
                return false;
            }
        } else if (option == 3) {
            //Date is selected
            if (startDate === '' || endDate === '') {
                alert('Please provide start and end dates.');
                return false;
            }
        }

        //Continue with form submission if validation passes
        return true;
    }		
</script>