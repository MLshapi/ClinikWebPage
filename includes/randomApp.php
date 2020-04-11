<?php
	include_once 'dbh.php';
	$appDate = date("Y-m-d H:i:s",strtotime($_POST['appDate']));
	$pFName = $_POST['first'];
	$pLName = $_POST['last'];

	$sql4 = "SELECT PatientID FROM patient WHERE PatientFirstName = '$pFName' AND PatientLastName = '$pLName';";
    $patient = mysqli_query($conn, $sql4);
    $arr_patient = mysqli_fetch_row($patient);
    //if patient already has an appointment same as appdate alert user to select new date
    $sql5 = "SELECT PatientID, AppointmentDateTime FROM appointment WHERE PatientID = '$arr_patient[0]' AND AppointmentDateTime = '$appDate';";
    mysqli_query($conn, $sql5);
    if (mysqli_affected_rows($conn) >= 1) {
    	//patient has a conflicted app date with current one
    	echo "<script>
         	alert('You already have a schedule appointment on this date, select a new date for a new appointment.');
         	window.location.href='../dmp.php';
         	</script>";
    }
    //else schedule a new app with a random doctor
    else {
	$sql = "SELECT AppointmentDateTime, DentistEmployeeID FROM appointment WHERE AppointmentDateTime = '$appDate'";
	$result = mysqli_query($conn, $sql);
	//checking for which doctor is booked for appdate then skipping that doctor randomize an available doctor for new app
    if (mysqli_affected_rows($conn) >= 1) {
    	$arr = mysqli_fetch_row($result);
    	$sql1 = "SELECT EmployeeID, ClinicID FROM employee
    	WHERE EmployeeID <> $arr[1]
    	ORDER BY RAND()
    	LIMIT 1;";
    	$doctors =  mysqli_query($conn, $sql1);
    	$arrDoc = mysqli_fetch_row($doctors);
    	$sql3 = "INSERT INTO appointment(`PatientID`, `AppointmentDateTime`, `ClinicID`, `DentistEmployeeID`, `CreatedByEmployeeID`,
		`IsMissedAppointment`) VALUES ('$arr_patient[0]', '$appDate', '$arrDoc[1]', '$arrDoc[0]', '3', '0');";
		mysqli_query($conn, $sql3);
		echo "<script>
         	alert('Appointment Successful');
         	window.location.href='../dmp.php';
         	</script>";
    }
    else {
    	//this appdate doesnt yet exist in app table so randomizing a doctor from employeetable for new app
    	$sql1 = "SELECT EmployeeID, ClinicID FROM employee
    	ORDER BY RAND()
    	LIMIT 1;";
    	$doctors =  mysqli_query($conn, $sql1);
    	$arrDoc = mysqli_fetch_row($doctors);
    	$sql3 = "INSERT INTO appointment(`PatientID`, `AppointmentDateTime`, `ClinicID`, `DentistEmployeeID`, `CreatedByEmployeeID`,
		`IsMissedAppointment`) VALUES ('$arr_patient[0]', '$appDate', '$arrDoc[1]', '$arrDoc[0]', '3', '0');";
		mysqli_query($conn, $sql3);
		echo "<script>
         	alert('Appointment Successful');
         	window.location.href='../dmp.php';
         	</script>";
    }
}


