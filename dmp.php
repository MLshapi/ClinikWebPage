<?php
	include_once 'includes/dbh.php';
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

<h1>Data Manipulation Page</h1>
<nav>
  <ul>
    <li><a href="index.php">Select Queries</a></li>
    <li><a href="dmp.php">Data Manipulation Page</a></li>
    <li><a href="dba.php">Database Administrator Page</a></li>
  </ul>
</nav>
<br>
<h3>Insert patient form:</h3>
<form action="includes/add_patient.php" method="POST">
	<input type="text" name="first" placeholder="FirstName">
	<br>
	<input type="text" name="last" placeholder="LastName">
	<br>
	<button type="submit" name="submit">Add Patient</button>
</form>
              <h3> Schedule a new appointment </h3>
              <form action="includes/newApp.php" method="POST">
              <label>
              Enter doctor name:
              <input type="text" name="docFName" placeholder="FirstName">
              <input type="text" name="docLName" placeholder="LastName">
              </label>
              <br>
              <input type="date" name="appDate">
              <br>
              <label>
              Patient name:
              <input type="text" name="first" placeholder="FirstName">
              <input type="text" name="last" placeholder="LastName">
              </label>
              <button type="submit" name="submit">Schedule appointment</button>
              </form>
              <h3> Delete existing appointment </h3>
              <form action="includes/delApp.php" method="POST">
              <label>
              Enter doctor name:
              <input type="text" name="docFName" placeholder="FirstName">
              <input type="text" name="docLName" placeholder="LastName">
              </label>
              <br>
              <input type="date" name="appDate">
              <br>
              <label>
              Patient name:
              <input type="text" name="first" placeholder="FirstName">
              <input type="text" name="last" placeholder="LastName">
              </label>
              <button type="submit" name="submit">Delete Appointment</button>
              </form>
              <h3> Modify existing appointment </h3>
              <form action="includes/modApp.php" method="POST">
              <label>
              Enter old appointment information
              <br>
              Doctor name:
              <input type="text" name="docFName" placeholder="FirstName">
              <input type="text" name="docLName" placeholder="LastName">
              </label>
              <br>
              <input type="date" name="appDate">
              <br>
              <label>
              Patient name:
              <input type="text" name="first" placeholder="FirstName">
              <input type="text" name="last" placeholder="LastName">
              </label>
              <br>
              <label>
              Select a new date for appointment:
                  <input type="date" name="nDate">
                  </label>
                  <button type="submit" name="submit">Modify appointment</button>
                  </form>
</body>
</html>
