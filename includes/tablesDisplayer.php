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
		$resultNumRows = mysqli_num_rows($result);
		$toPrint = "";
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
	function displayQueryTwo()
	{
		global $conn;
		$sql = "WITH cteSequence AS
				(
					SELECT 1 AS ID UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8
				),

				cteWeeks AS
				(
					SELECT
						MAKEDATE(2020,ROW_NUMBER() OVER (ORDER BY a.ID, b.ID, c.ID)) AS Date,
						WEEKOFYEAR(MAKEDATE(2020,ROW_NUMBER() OVER (ORDER BY a.ID, b.ID, c.ID))) AS WeekNumber,
				        YEAR(MAKEDATE(2020,ROW_NUMBER() OVER (ORDER BY a.ID, b.ID, c.ID))) AS DateYear
					FROM
						cteSequence a
						CROSS JOIN cteSequence b
				        CROSS JOIN cteSequence c
				)

				SELECT
					W.WeekNumber,
				    MIN(W.Date) AS WeekStartDate,
				    MAX(W.Date) AS WeekEndDate,
				    CASE
						WHEN MIN(W.Date) = MAX(W.Date) THEN DATE_FORMAT(MIN(W.Date), '%M %d, %Y')
				        ELSE CONCAT('From ', DATE_FORMAT(MIN(W.Date), '%M %d, %Y'), ' to ', DATE_FORMAT(MAX(W.Date), '%M %d, %Y'))
					END AS WeekName
				FROM
					cteWeeks W
				WHERE
					W.DateYear = 2020
				GROUP BY
					W.WeekNumber
				ORDER BY
					W.WeekNumber;";
		printQueryTable($sql, $conn);
	}
	function displayQueryThree()
	{
		global $conn;
		$sql = "SELECT
					a.AppointmentID,
				    e.EmployeeID,
					concat(e.EmployeeFirstName + ' ' + e.EmployeeLastName) AS DentistName,
				    concat(p.PatientFirstName + ' ' + p.PatientLastName) AS PatientName
				FROM
					nc.appointment a
				    INNER JOIN nc.Employee e ON
						e.EmployeeID = a.DentistEmployeeID
					INNER JOIN nc.clinic c ON
						e.ClinicID = c.ClinicID
					INNER JOIN nc.patient p On
						p.PatientID = a.PatientID
				WHERE
					date(a.AppointmentDateTime) = data($) AND (c.ClinicID = $ OR c.ClinicName = $); ";
		printQueryTable($sql, $conn);
	}
	function displayQueryFour()
	{
		global $conn;
		$sql = "SELECT
					a.AppointmentID,
				    a.PatientID,
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
					p.PatientID =$  OR (p.PatientFirstName =$ && p.PatientLastName =$); ";
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
	function displayQuerySix()
	{
		global $conn;
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
					a.AppointmentID = 1;";
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


 	function displayQueryNumber($queryOption)
 	{

		switch($queryOption) {
			case 1:
				displayQueryOne();
			break;
			case 2:
				displayQueryTwo();
			break;
			case 3:
				displayQueryThree();
			break;
			case 4:
				displayQueryFour();
			break;
			case 5:
				displayQueryFive();
			break;
			case 6:
				displayQuerySix();
			break;
			case 7:
				displayQuerySeven();
			break;
			default:
			echo "Select a query!";
	 	}
		

	 }

	
	
?>