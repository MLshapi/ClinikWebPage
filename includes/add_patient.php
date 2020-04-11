<?php
	include_once 'dbh.php';
	$first = $_POST['first'];
	$last = $_POST['last'];
	$sql = "INSERT INTO patient(`PatientFirstName`,`PatientLastName`) VALUES ('$first' , '$last');";
    mysqli_query($conn, $sql);


	header("Location: ../dmp.php");