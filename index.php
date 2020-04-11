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
		  .op {
    			display:none;
			}
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
		function showExtra(option)
		{
		   var divClass = option.value;
		   $('.op').css({ display: 'none' });
		   $('.' + divClass).css({ display: 'inline' });
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
	<li><a href="billing.php">Billing Page</a></li>
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
<br>
<form action="index.php" method="POST">
	<select name="queries" style="width: 250px;height:30px;" onchange="showExtra(this)">
	  <option value="1">Querie 1</option>
	  <option value="2">Querie 2</option>
	  <option value="3">Querie 3</option>
	  <option value="4">Querie 4</option>
	  <option value="5">Querie 5</option>
	  <option value="6">Querie 6</option>
	  <option value="7">Querie 7</option>
	</select>
	<br >
	<label class="2 op">Dentist ID:</label><input type="text" name="dentistID" class="2 op">
	<br class="2 op">
	<label class="2 op">Date:</label><input type="date" name="date" class="2 op">
	<br class="2 op">
	<label class="3 op">Appointment date:</label><input type="date" name="date" class="3 op">
	<br class="3 op">
	<label class="3 op">Clinic Id: </label><input type="text" class="3 op" name="clinicId">
	<label class="6 op">Appointment Id: </label><input type="text" name="appId" class="6 op">
	<label class="4 op" >Enter a Patient Id or enter a Patient Name</label>
	<br class="4 3 op">
	<label class="4 op">Patient Id: </label><input type="text" class="4 op" name="patientId">
	<br class="4 3 op">
	<label class="4 op">Patient First Name: </label><input type="text" class="4 op" name="patientFName">
	<br class="4 op">
	<label class="4 op">Patient Last Name: </label><input type="text" class="4 op" name="patientLName">
	<br class="6 4 3 op">
	<button type="submit" name="submit">Display Query</button>
</form>

<?php
	if(isset($_POST)){
		if((!empty($_POST)) && $_POST['queries'])
		{
			$queryOption = $_POST['queries'];
			echo "<h4>Query Number $queryOption</h4>";
			displayQueryNumber($queryOption,$_POST);
		}
	}
?>


<div id="appointmentTable" style="visibility=hidden;display:none;">
	<?php
		displayAllAppointments();
	?>

</div>
<div id="billTable" style="display:none;">
	<?php
		displayAllBills();
	?>

</div>
<div id="clinicTable" style="display:none;">
	<?php
		displayAllClinics();

	?>

</div>
<div id="dentistTable" style="display:none;">
	<?php
		displayAllDentists();
	?>

</div>
<div id="patientTable" style="display:none;">
	<?php
		displayAllPatients();
	?>

</div>
<div id="treatmentTable" style="display:none;">
	<?php
		displayAllTreatments();
	?>

</div>
</body>
</html>