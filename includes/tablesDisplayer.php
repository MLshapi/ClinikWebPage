<?php
	$appointmentTable = array('a_id','p_id','d_id','c_id', 'date');
	$billTable = array('b_id','p_id','t_id','price', 'paid');
	$clinicTable = array('c_id','c_name','location');
	$dentistTable = array('d_id','first_name','last_name','c_id');
	$patientTable = array('p_id','first_name','last_name');
	$treatmentTable = array('t_id','a_id','p_id','d_id', 'description','price');
	function printTable($sql,$arrayOfTable,$tableName, $funcConn) {
    	$result = mysqli_query($funcConn, $sql);
		$resultNumRows = mysqli_num_rows($result);
		$toPrint = "";
		if($resultNumRows > 0)
		{
			$toPrint .= "<table>";
			$toPrint .= "<tr><td colspan=\"" . sizeof($arrayOfTable) . "\">" . $tableName  . " Table</td></tr>";
			$toPrint .= "<tr>";
			foreach($arrayOfTable as $attribute)
			{
				$toPrint .= "<td>" . $attribute . "</td>";
			}
			$toPrint .= "</tr>";
			
			while($row = mysqli_fetch_assoc($result))
			{
				$toPrint .= "<tr>";
				foreach($arrayOfTable as $attribute)
				{
					$toPrint .= "<td>" . $row[$attribute] . "</td>";
				}
				$toPrint .= "</tr>";
			}
			$toPrint .= "</table>";

		}
		else
		{
			$toPrint .= "No result";
		}
		
		echo $toPrint;
	}	


	function displayAllAppointments()
	{
		global $appointmentTable;
		global $conn;
		$sql = "SELECT * FROM appointment;";
		printTable($sql, $appointmentTable, "Appointment" ,$conn);
	}
	function displayAllBills()
	{
		global $billTable;
		global $conn;
		$sql = "SELECT * FROM bill;";
		printTable($sql, $billTable,"Bill" ,$conn);
	}
	function displayAllClinics()
	{
		global $clinicTable;
		global $conn;
		$sql = "SELECT * FROM clinic;";
		printTable($sql, $clinicTable,"Clinic" ,$conn);
	}
	function displayAllDentists()
	{
		global $dentistTable;
		global $conn;
		$sql = "SELECT * FROM dentist;";
		printTable($sql, $dentistTable,"Dentist" ,$conn);
	}
	function displayAllPatients()
	{
		global $patientTable;
		global $conn;
		$sql = "SELECT * FROM patient;";
		printTable($sql, $patientTable,"Patient" ,$conn);
	}
	function displayAllTreatments()
	{
		global $treatmentTable;
		global $conn;
		$sql = "SELECT * FROM treatment;";
		printTable($sql, $treatmentTable,"Treatment" ,$conn);
	}
	


 
	



	



	


 
	
?>