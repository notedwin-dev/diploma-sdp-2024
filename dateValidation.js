function validateDOB() {
	var dobInput = document.getElementById('dob');
	var today = new Date();
	var dob = new Date(dobInput.value);

	//Calculate age of the user from their selected date
	var age = today.getFullYear() - dob.getFullYear();
	var monthDiff = today.getMonth() - dob.getMonth();
	if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
		age--;
	}

	//Check if the user age is at least 16 years old
	if (age < 16) {
		alert("You must be at least 16 years old to proceed.");
		//Clear the input data if the date selected is less than 16 years old
		dobInput.value = "";
		return false;
	}

	return true;
}