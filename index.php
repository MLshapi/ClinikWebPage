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

<h1>Select Queries</h1>
<nav>
  <ul>
    <li><a href="index.php">Select Queries</a></li>
    <li><a href="dmp.php">Data Manipulation Page</a></li>
    <li><a href="dba.php">Database Administrator Page</a></li>
  </ul>
</nav>
<br>

<button id="appointmentBtn" onclick="displayTable('appointmentTable')">Show All Appointments</button>
<button id="billBtn" onclick="displayTable('billTable')">Show All Bills</button>
<button id="clinicBtn" onclick="displayTable('clinicTable')">Show All Clinics</button>
<button id="dentistBtn" onclick="displayTable('dentistTable')">Show All Employees</button>
<button id="patientBtn" onclick="displayTable('patientTable')">Show All Patients</button>
<button id="treatmentBtn" onclick="displayTable('treatmentTable')">Show All Treatments</button>
<br>



<div id="appointmentTable" style="visibility=hidden;">
	<?php
		displayAllAppointments();
	?>

</div>
<div id="billTable">
	<?php
		displayAllBills();
	?>

</div>
<div id="clinicTable">
	<?php
		displayAllClinics();

	?>

</div>
<div id="dentistTable">
	<?php
		displayAllDentists();
	?>

</div>
<div id="patientTable">
	<?php
		displayAllPatients();
	?>

</div>
<div id="treatmentTable">
	<?php
		displayAllTreatments();
	?>

</div>



</body>
</html>