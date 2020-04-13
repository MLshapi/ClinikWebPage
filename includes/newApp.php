<?php
	include_once 'dbh.php';
	$docFName = $_POST['docFName'];
	$docLName = $_POST['docLName'];
	$appDate = date("Y-m-d H:i:s",strtotime($_POST['appDate']));
	$pFName = $_POST['first'];
	$pLName = $_POST['last'];

    $sql1 = "SELECT PatientID FROM patient WHERE PatientFirstName = '$pFName' AND PatientLastName = '$pLName';";
    $result = mysqli_query($conn, $sql1);
    $arr_patient = mysqli_fetch_row($result);
    //if patient already has an appointment same as appdate alert user to select new date
    $sql4 = "SELECT PatientID, AppointmentDateTime FROM appointment WHERE PatientID = '$arr_patient[0]' AND AppointmentDateTime = '$appDate';";
    mysqli_query($conn, $sql4);
    if (mysqli_affected_rows($conn) >= 1) {
    	echo "<script>
         	alert('You already have a schedule appointment on this date,
         	select a new date for a new appointment.');
         	window.location.href='../dmp.php';
         	</script>";
    }
    else {
	$sql2 = "SELECT EmployeeID, ClinicID FROM employee WHERE EmployeeFirstName = '$docFName' AND EmployeeLastName = '$docLName';";
	$result2 = mysqli_query($conn, $sql2);
	$arr_dentist = mysqli_fetch_row($result2);
	//is patient already has an app with a doc in the table that means creating a new app for missed app hence ismissedapp attr = 1
	$sql3 = "SELECT PatientID, DentistEmployeeID FROM appointment WHERE PatientID = $arr_patient[0] AND DentistEmployeeID = $arr_dentist[0];";
	mysqli_query($conn, $sql3);
	if (mysqli_affected_rows($conn) >= 1 ) {
		$sql = "INSERT INTO appointment(`PatientID`, `AppointmentDateTime`, `ClinicID`, `DentistEmployeeID`, `CreatedByEmployeeID`,
		`IsMissedAppointment`)
	        SELECT '$arr_patient[0]', '$appDate', '$arr_dentist[1]', '$arr_dentist[0]', '3', '1'
            FROM dual 
            WHERE NOT EXISTS 
            (SELECT * FROM appointment WHERE DentistEmployeeID = '$arr_dentist[0]'  AND AppointmentDateTime = '$appDate');";
         mysqli_query($conn, $sql);
         //if cond
         $notify = mysqli_affected_rows($conn);
         if ($notify >= 1) {
         	echo "<script>
         	alert('Appointment Successful');
         	window.location.href='../dmp.php';
         	</script>";
         }
         else {
         	echo "<script>
         	alert('No available dentist on selected date, please select a new date');
         	window.location.href='../dmp.php';
         	</script>";
         } 
	}
	//else new app with a doctor so no old missed app and appdate doesnot conflict with existing doctos in the app table
	else {
		$sql = "INSERT INTO appointment(`PatientID`, `AppointmentDateTime`, `ClinicID`, `DentistEmployeeID`, `CreatedByEmployeeID`,
		`IsMissedAppointment`)
	        SELECT '$arr_patient[0]', '$appDate', '$arr_dentist[1]', '$arr_dentist[0]', '3', '0'
            FROM dual 
            WHERE NOT EXISTS 
            (SELECT * FROM appointment WHERE DentistEmployeeID = '$arr_dentist[0]'  AND AppointmentDateTime = '$appDate');";
         mysqli_query($conn, $sql);
         $notify = mysqli_affected_rows($conn);
         //if cond
         if ($notify >= 1) {
         	echo "<script>
         	alert('Appointment Successful');
         	window.location.href='../dmp.php';
         	</script>";
         }
         else {
         	echo "<script>
         	alert('No available dentist on selected date, please select a new date');
         	window.location.href='../dmp.php';
         	</script>";
         } 
	}

}
	

