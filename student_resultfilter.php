<?php
	include('secure.php');
	include('connection.php');
	include('nav_stu.php');
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        //Get HTML elements for report type, topic, and date
        var optionElement = document.getElementById('option');
        var topicElement = document.getElementById('topic');
        var dateElement = document.getElementById('date');

        // Initial setup
        updateDisplay();
        optionElement.addEventListener('change', function(){
            updateDisplay();
        });

        //Function to update the display based on the selected report type
        function updateDisplay() {
            var option = optionElement.value;

            if (option == 2) {
                showElement(topicElement);
                hideElement(dateElement);
            } else if (option == 3) {
                showElement(dateElement);
                hideElement(topicElement);
            } else {
                hideElement(topicElement);
                hideElement(dateElement);
            }
        }
        //Function to show an HTML element
        function showElement(element) {
            element.style.display = 'block';
        }
        //Function to hide an HTML element
        function hideElement(element) {
            element.style.display = 'none';
        }
    });

	//Function to validate the form before submission
	function validateForm() {
        var option = document.getElementById('option').value;
        var topicSelected = document.getElementById('topic').style.display === 'block';
        var startDate = document.getElementById('startdate').value;
        var endDate = document.getElementById('enddate').value;

        if (option == 1) {
            //Validate if Topics and Date are selected
            if (!topicSelected && (startDate === '' || endDate === '')) {
                alert('Please select a topic or provide start and end dates.');
                return false;
            }
        } else if (option == 2) {
            //Validate if Topics is selected
            if (!topicSelected) {
                alert('Please select a topic.');
                return false;
            }
        } else if (option == 3) {
            //Validate if Date is selected
            if (startDate === '' || endDate === '') {
                alert('Please provide start and end dates.');
                return false;
            }
        }

        //Continue with form submission if validation passes
        return true;
    }
</script>
<link rel="stylesheet" href="form2.css">
<link rel="stylesheet" href="button.css">
<div class="content">
    <center>
    <h3 class="header">REPORT TYPE SELECTION</h3>

    <!-- Form (filter)for selecting report type, topic, and date -->
    <form class="form" action="student_resultview.php" method="get" onsubmit="return validateForm()">
        <select id='option' name='option'>
            <option value=1 disabled selected>Please Select Topic or Date</option>
            <option value=2>Topics</option>
            <option value=3>Date</option>
        </select><br>

        <?php
			$idstudent = $_SESSION['userid'];
            //SQL query to retrieve distinct topics for the student
			$sql = "SELECT DISTINCT topic.TopicID, topic.TopicName FROM topic JOIN overall_result ON topic.TopicID = overall_result.TopicID JOIN student ON overall_result.StuID = student.StuID WHERE overall_result.StuID = '".$idstudent."' ORDER BY topic.TopicID ASC";

            //Execute the SQL query
			$data = mysqli_query($connection,$sql);

            //Check if there are quiz history records
			$hasRecords = mysqli_num_rows($data) > 0;
        ?>

         <!-- Display topics if there are records -->
        <div id="topic" style="display: <?php echo $hasRecords ? 'block' : 'none'; ?>;">
            <?php if ($hasRecords) : ?>
                <select class="topic" name="topic">
                    <?php
						while($topic = mysqli_fetch_array($data)){
							echo "<option value='$topic[TopicID]'>$topic[TopicName]</option>";
						}
                    ?>
                </select>
            <?php else : ?>
                <!-- Display message if no quiz history records -->
                <p>No quiz history record</p>
            <?php endif; ?>
        </div>
        
        <!-- Display date inputs if there are records -->
        <div id="date" style="display: <?php echo $hasRecords ? 'block' : 'none'; ?>;">
            <?php if ($hasRecords) : ?>
                Start date:<input type='date' id='startdate' name='startdate' <?php echo $hasRecords ? '' : 'disabled'; ?>><br>
                End date:<input type='date' id='enddate' name='enddate' <?php echo $hasRecords ? '' : 'disabled'; ?>>
            <?php else : ?>
                <!-- Display message if no quiz history records -->
                <p>No quiz history record</p>
            <?php endif; ?>
        </div>

        <?php
            // Display the "Show" button if there are records
			if($hasRecords) {
				echo "<button class='submit' type='submit'>Show</button>";
			}
        ?>
	</form>
	</center>
</div>