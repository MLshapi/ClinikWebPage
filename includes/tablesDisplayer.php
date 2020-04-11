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
		$dentistID = $post['dentistID'] ?? 0;
		
		$sql = "SELECT 
					a.DentistEmployeeID, e.EmployeeFirstName, a.AppointmentID,a.AppointmentDateTime, p.PatientFirstName, b.PaidAmount
				FROM 
					appointment as a, employee as e, patient as p, bill as b
				WHERE 
					a.DentistEmployeeID = $dentistID AND e.EmployeeID = a.DentistEmployeeID AND p.PatientID =a.PatientID AND WEEK(a.AppointmentDateTime) =  WEEK('$date') AND a.AppointmentID = b.AppointmentID;";
		printQueryTable($sql, $conn);
	}
	function displayQueryThree($post)
	{
		global $conn;
		$date = $post['date'] ?? 0;
		$clinicId = $post['clinicId'] ?? 0;

		$sql = "SELECT 
					a.AppointmentID, c.ClinicName, a.AppointmentDateTime, e.EmployeeFirstName
				FROM
					clinic as c, appointment as a, employee as e
				WHERE
					c.ClinicID = $clinicId AND DAY(a.appointmentDateTime) = DAY('$date') AND e.EmployeeID = a.DentistEmployeeID;";
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
		$sql = "WITH AllBills AS
				(
					SELECT
						p.PatientID,
						CONCAT(p.PatientFirstName, ' ', p.PatientLastName) AS PatientFullName,
						a.AppointmentID,
						DATE_FORMAT(a.AppointmentDateTime, '%b, %d %Y %h:%i %p') AS AppointmentDateTime,
						c.ClinicID,
						concat(c.ClinicAddress, ' ', c.ClinicCity, ' ', c.ClinicProvince, ' ', c.ClinicPostalCode, ' ',c.ClinicCountry) AS ClinicAddress,
						SUM(bi.TreatmentPrice*bi.TreatmentUnitCount) AS BilledAmount,
						COALESCE(b.PaidAmount, 0) AS PaidAmount
					FROM
						bill b
						INNER JOIN appointment a 
						ON b.AppointmentID = a.AppointmentID
						INNER JOIN patient p
						ON p.PatientID = a.PatientID
						INNER JOIN billitem bi
						ON bi.BillID = b.BillID
						INNER JOIN clinic c
						ON c.ClinicID = a.ClinicID
					GROUP BY
						p.PatientID,
						CONCAT(p.PatientFirstName, ' ', p.PatientLastName),
						a.AppointmentID,
						DATE_FORMAT(a.AppointmentDateTime, '%b, %d %Y %h:%i %p'),
						c.ClinicID,
						concat(c.ClinicAddress, ' ', c.ClinicCity, ' ', c.ClinicProvince, ' ', c.ClinicPostalCode, ' ',c.ClinicCountry),
						COALESCE(b.PaidAmount, 0)
				)
					SELECT
						ab.PatientID, ab.PatientFullName, ab.AppointmentID, ab.AppointmentDateTime, ab.ClinicID, ab.ClinicAddress, ab.BilledAmount, ab.PaidAmount
					FROM
						AllBills ab
					WHERE
						ab.BilledAmount <> ab.PaidAmount;";
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