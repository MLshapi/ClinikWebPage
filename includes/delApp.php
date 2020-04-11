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

	$sql2 = "SELECT EmployeeID, ClinicID FROM employee WHERE EmployeeFirstName = '$docFName' AND EmployeeLastName = '$docLName';";
	$result2 = mysqli_query($conn, $sql2);
	$arr_dentist = mysqli_fetch_row($result2);

	$sql = "DELETE FROM appointment WHERE PatientID = '$arr_patient[0]' AND DentistEmployeeID = '$arr_dentist[0]' AND AppointmentDateTime = '$appDate';";
    mysqli_query($conn, $sql);
    
	header("Location: ../dmp.php");