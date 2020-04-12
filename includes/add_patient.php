<?php
	include_once 'dbh.php';
	$first = $_POST['first'];
	$last = $_POST['last'];
	$dob = $_POST['dob'];
	$sql = "INSERT INTO patient(`PatientFirstName`,`PatientLastName`, `PatientDOB`) VALUES ('$first' , '$last', '$dob');";
    mysqli_query($conn, $sql);


	header("Location: ../dmp.php");
		