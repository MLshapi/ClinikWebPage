<?php
	include_once 'dbh.php';
	$docFName = $_POST['docFName'];
	$docLName = $_POST['docLName'];
	$appDate = $_POST['appDate'];
	$pFName = $_POST['first'];
	$pLName = $_POST['last'];
	$nDate = $_POST['nDate'];

    $sql1 = "SELECT p_id FROM patient WHERE first_name = '$pFName' AND last_name = '$pLName';";
    $result = mysqli_query($conn, $sql1);
    $arr_patient = mysqli_fetch_row($result);

	$sql2 = "SELECT d_id, c_id FROM dentist WHERE first_name = '$docFName' AND last_name = '$docLName';";
	$result2 = mysqli_query($conn, $sql2);
	$arr_dentist = mysqli_fetch_row($result2);

	$sql = "UPDATE appointment SET date = '$nDate' WHERE p_id = '$arr_patient[0]' AND d_id = '$arr_dentist[0]' AND date = '$appDate';";
    mysqli_query($conn, $sql);
	
	header("Location: ../dmp.php");