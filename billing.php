<?php
	include_once 'includes/dbh.php';
	include_once 'includes/tablesDisplayer.php';
?>


<!DOCTYPE html>
<html>
<head>
	<title>Page Title</title>
	<style>
	      table {border-style: ridge;  border-width: 1px; border-color: #000000 ;}
	      th  {border:1px solid #000000;}   
	      td {border:1px solid #000000;text-align:center;}
	      div {display: none;}
	      ul {list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #333;}
		  li {float: left;}
		  li a {display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;}
		  li a:hover {background-color: #111;}
}
	 </style>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	 <script>
	 	function displayTable(id) {
		  var x = document.getElementById(id);
		  if (x.style.display === "none") {
		    x.style.display = "block";
		  } else {
		    x.style.display = "none";
		  }
		}
	 </script>
</head>
<body>

<h1>Billing</h1>
<nav>
  <ul>
    <li><a href="index.php">Select Queries</a></li>
    <li><a href="dmp.php">Data Manipulation Page</a></li>
    <li><a href="dba.php">Database Administrator Page</a></li>
	<li><a href="billing.php">Billing Page</a></li>
  </ul>
</nav>
<br>
<h3> Create bill</h3>
 <form action="" method="POST">
  <label>
    Enter Appointment ID:
    <input type="text" name="appID" placeholder="Appointment ID">      
  </label>
  <br>
  <label>
    Enter Treatment ID:
    <input type="text" name="treatmentID" placeholder="TreatmentID">      
  </label>
  <br>
  <button type="submit" name="submit">Create Bill</button>
</form>

<h3> Pay bill</h3>
 <form action="" method="POST">
  <label>
    Enter Bill ID:
    <input type="text" name="billID" placeholder="Bill ID">      
  </label>
  <br>
  <label>
    Enter Amount:
    <input type="text" name="amount" placeholder="999">      
  </label>
  <br>
  <button type="submit" name="submit1">Pay</button>
</form>

</body>
</html>
<?php

if(isset($_POST['submit']))
{
	$appID = $_POST['appID'];
	$treatmentID = $_POST['treatmentID'];
	
	$sql1 = "SELECT TreatmentStandardPrice FROM treatment WHERE TreatmentID = '$treatmentID';";
    $result = mysqli_query($conn, $sql1);
	$row = $result->fetch_assoc();
	$tPrice = $row['TreatmentStandardPrice'];
	
	$today = date("Y/m/d");
	$sql = "INSERT into bill(`AppointmentID`,`PaidAmount`,`PaymentDateTime`,`BillProcessedByEmployeeID`) VALUES 
			('$appID' , '$tPrice','$today', 6);";
    mysqli_query($conn, $sql);
	
	$sql2 = "SELECT MAX(BillID) as bID FROM bill;";
    $result2 = mysqli_query($conn, $sql2);
	$row2 = $result2->fetch_assoc();
	$billID = $row2['bID'];
	
	$sql3 = "SELECT AppointmentDateTime FROM appointment WHERE AppointmentID` = '$appID';";
    $result3 = mysqli_query($conn, $sql3);
	$row3 = $result3->fetch_assoc();
	$appDate = $row3['AppointmentDateTime'];
	
	$sql4 = "INSERT into billitem(`BillID`,`TreatmentID`,`TreatmentPrice`,`TreatmentUnitCount`,`TreatmentAssignedByEmployeeID`,`TreatmentAssignedDateTime`,`TreatmentExecutedByEmployeeID`,`TreatmentExecutedDateTime`) 
			VALUES 
			('$billID' , '$treatmentID', '$tPrice', 1, 7, '1990-01-07', 3, '$appDate' );";
    mysqli_query($conn, $sql4);

	
}

?>


<?php
if(isset($_POST['submit1']))
{
	$billID = $_POST['billID'];
	$amount = $_POST['amount'];
	
	$sql1 = "SELECT PaidAmount FROM bill WHERE BillID = '$billID';";
    $result = mysqli_query($conn, $sql1);
	$row = $result->fetch_assoc();
	$payAmount = $row['PaidAmount'];
	
	if($payAmount == $amount)
	{
		$sql2 = "UPDATE bill SET isPaid = 0 WHERE BillID = '$billID';";
		mysqli_query($conn, $sql2);
		
		echo "Thank You!";
	}
	else
	{
		echo "INCORRECT AMOUNT!";
	}
}

?>
