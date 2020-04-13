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

	function printQueryTable($sql,$funcConn)
	{
		$result = mysqli_query($funcConn, $sql);
		$toPrint = "";
		if($result)
		{
			$resultNumRows = mysqli_num_rows($result);
		
			if($resultNumRows > 0)
			{
				$toPrint .= "<table>";
				$i = 0;
				while($row = mysqli_fetch_assoc($result))
				{
					$toPrint .= "<tr>";
					$attribute = "";
					$data = "";
					foreach($row as $k => $v){
						if($i == 0)
						{
							$attribute .= "<td>" . $k . "</td>";
						}
						
						$data .= "<td>" . $v . "</td>";
						

				 	}
				 	if($i == 0)
				 	{
				 		$toPrint .= $attribute;
				 		$toPrint .= "</tr>";
				 		$toPrint .= "<tr>";
				 	}
				 	$toPrint .= $data;
					$toPrint .= "</tr>";
					$i++;
				}
				$toPrint .= "</table>";

			}
			else
			{
				$toPrint .= "<br><h2>No result</h2>";
			}
		}
		else
		{
			$toPrint .= "<br><h2>No result</h2>";
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
	function displayQueryOne()
	{
		global $conn;
		$appId = $post['appId'] ?? 0;
		$sql = "SELECT 
					e.EmployeeID,
				    e.EmployeeFirstName,
				    e.EmployeeLastName,
				    cl.ClinicName
				FROM
					employee e
				    INNER JOIN employeetitle et ON
						 e.EmployeeTitleID = et.EmployeeTitleID
					INNER JOIN Clinic cl ON
						CL.ClinicID = e.ClinicID
				WHERE
					et.EmployeeTitle = 'Dentist';";
		printQueryTable($sql, $conn);
	}
	function displayQueryTwo($post)
	{
		global $conn;
		$date = $post['date1'] ?? 0;
		$dentistID = $post['dentistID'] ?? 0;
		
		$sql = "SELECT
				a.AppointmentID, p.PatientFirstName, a.AppointmentDateTime, e.employeeFirstName
				FROM
				appointment as a
				INNER JOIN patient p ON a.PatientID = p.PatientID
				INNER JOIN employee e ON e.EmployeeID = a.DentistEmployeeID
				WHERE a.DentistEmployeeID = '$dentistID' AND WEEK(a.AppointmentDateTime) = WEEK('$date');";
		printQueryTable($sql, $conn);
		
	}
	function displayQueryThree($post)
	{
		global $conn;
		$date = $post['date'] ?? 0;
		echo "$date";
		$sql = "SELECT 
					a.AppointmentID, c.ClinicName, a.AppointmentDateTime, e.EmployeeFirstName, p.patientFirstName
				FROM
					clinic as c, appointment as a, employee as e, patient as p
				WHERE
					DAY(a.appointmentDateTime) = DAY('$date') AND a.ClinicID = c.ClinicID AND e.EmployeeID = a.DentistEmployeeID AND p.PatientID = a.PatientID;";
		printQueryTable($sql, $conn);
	}
	function displayQueryFour($post)
	{
		global $conn;
		$patientId = $post['patientId'] ?? '0';
		$patientFName = $post['patientFName'] ?? '';
		$patientLName = $post['patientLName'] ?? '';
		if($patientId == '')
			$patientId = 0;
		echo $patientId;
		echo $patientFName . "," . $patientLName;
		$sql = "SELECT
					a.AppointmentID,
					p.PatientID,
				    p.PatientFirstName,
				    p.PatientLastName,
				    a.CreatedByEmployeeID,
				    a.IsMissedAppointment,
				    c.ClinicName,
				    c.ClinicAddress,
				    c.ClinicCity,
				    c.ClinicCountry,
				    c.ClinicProvince,
				    c.ClinicPostalCode
				FROM
					appointment a
					INNER JOIN clinic c ON
						c.ClinicID = a.ClinicID
					INNER JOIN .patient p On
						p.PatientID = a.PatientID
				WHERE
					p.PatientID = " . $patientId ." OR (p.PatientFirstName = '" . $patientFName . "' && p.PatientLastName = '" . $patientLName . "');";
		printQueryTable($sql, $conn);
	}
	function displayQueryFive()
	{
		global $conn;
		$sql = "SELECT
					count(P.PatientID),
				    P.PatientID,
				    p.PatientFirstName,
				    p.PatientLastName,
				    a.AppointmentDateTime
				FROM
					patient p 
				    INNER JOIN appointment a
				    ON p.PatientID = a.PatientID
				WHERE
					(a.IsMissedAppointment = 1)
				GROUP BY
					P.PatientID;";
		printQueryTable($sql, $conn);
	}
	function displayQuerySix($post)
	{
		global $conn;
		$appId = $post['appId'] ?? 0;
		if($appId == '')
			$appId = 0;
		$sql = "SELECT
					t.TreatmentID,
				    t.TreatmentName,
				    bi.TreatmentPrice,
				    bi.TreatmentUnitCount,
				    bi.TreatmentPrice*bi.TreatmentUnitCount AS TreatmentTotalPrice,
				    CONCAT(ea.EmployeeFirstName, ' ', ea.EmployeeLastName) AS AssignedBy,
				    bi.TreatmentAssignedDateTime,
				    CONCAT(ee.EmployeeFirstName, ' ', ee.EmployeeLastName) AS ExecutedBy
				FROM
					billitem bi
				    INNER JOIN bill b
				    ON bi.BillID = b.BillID
				    INNER JOIN appointment a
				    ON a.AppointmentID = b.AppointmentID
				    INNER JOIN treatment t
				    ON t.TreatmentID = bi.TreatmentID
				    INNER JOIN employee ea
				    ON ea.EmployeeID = bi.TreatmentAssignedByEmployeeID
				    LEFT JOIN employee ee
				    ON ee.EmployeeID = bi.TreatmentExecutedByEmployeeID
				WHERE
					a.AppointmentID = $appId;";
		printQueryTable($sql, $conn);
	}
	function displayQuerySeven()
	{
		global $conn;
		$sql = "SELECT b.BillID, b.AppointmentID, concat(p.PatientFirstName, ' ' , p.PatientLastName) AS 'Patient Name', b.PaidAmount AS 'TotalAmount', b.isPaid, bi.TreatmentPrice, t.treatmentName
				FROM
				bill as b
				INNER JOIN billitem bi ON b.BillID = bi.BillID
				INNER JOIN treatment t ON bi.TreatmentID = t.TreatmentID
				INNER JOIN appointment a ON b.AppointmentID = a.AppointmentID
				INNER JOIN patient p ON p.PatientID = a.PatientID
				WHERE b.isPaid = 1
				ORDER BY b.BillID;";
		printQueryTable($sql, $conn);
	}

		
 	function displayQueryNumber($queryOption,array $post)
 	{

		switch($queryOption) {
			case 1:
				displayQueryOne();
			break;
			case 2:
				displayQueryTwo($post);
			break;
			case 3:
				displayQueryThree($post);
			break;
			case 4:
				displayQueryFour($post);
			break;
			case 5:
				displayQueryFive();
			break;
			case 6:
				displayQuerySix($post);
			break;
			case 7:
				displayQuerySeven();
			break;
			default:
			echo "Select a query!";
	 	}
		

	 }

	
	
?>