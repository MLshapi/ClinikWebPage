<?php
	$appointmentTable = array('AppointmentID','PatientID','AppointmentDateTime','ClinicID', 'DentistEmployeeID', 'CreatedByEmployeeID', 'IsMissedAppointment');
	$billTable = array('BillID','AppointmentID','PaidAmount','PaymentDateTime', 'BillProcessedByEmployeeID');
	$clinicTable = array('ClinicID','ClinicName','ClinicAddress', 'ClinicCity', 'ClinicProvince', 'ClinicPostalCode', 'ClinicCountry');
	$dentistTable = array('EmployeeID','EmployeeFirstName','EmployeeLastName','EmployeeTitleID', 'ClinicID');
	$patientTable = array('PatientID','PatientFirstName','PatientLastName', 'PatientDOB');
	$treatmentTable = array('TreatmentID','TreatmentName','TreatmentStandardPrice');
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
		$sql = "SELECT * FROM employee;";
		printTable($sql, $dentistTable,"Employee" ,$conn);
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