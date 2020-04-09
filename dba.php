<?php
	include_once 'includes/dbh.php';
	include_once 'includes/tablesDisplayer.php';


	//INSERT INTO patient(`p_id`,`first_name`,`last_name`) VALUES (5, 'St1' , 'Bo2o');
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

<h1>Database Administrator Page</h1>
<nav>
  <ul>
    <li><a href="index.php">Select Queries</a></li>
    <li><a href="dmp.php">Data Manipulation Page</a></li>
    <li><a href="dba.php">Database Administrator Page</a></li>
  </ul>
</nav>
<br>

<h3>Database Administrator Text Area:</h3>
<form action="dba.php" method="POST">
	<textarea type="text" name="query" placeholder="Insert query and run" rows="5" cols="100"></textarea>
	<br>
	<button type="submit" name="submit">Run query</button>
</form>

<?php

	function sql_format_query($raw_query) {
	  $keywords = array("select", "from", "where", "order by", "group by", "insert into", "update", "inner join");
	  foreach ($keywords as $keyword) {
	    if (preg_match("/($keyword *)/i", $raw_query, $matches)) {
	      $raw_query = str_replace($matches[1], "<br>" . strtoupper($matches[1]) . "  ", $raw_query);
	    }
	  }
	  return $raw_query;
	}
	if(isset($_POST)){
		if((!empty($_POST)) && $_POST['query'])
		{
			@$query = $_POST['query'] ?? '';
			$formatted = sql_format_query($query);
			echo $formatted;
			$result = mysqli_query($conn, $query);

			//if it is a select --> display table
			if(strpos(strtolower($query), 'select') !== false)
			{
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
			//else print success
			else
			{
				if($result)
				{
					echo 'Success!';
				}
			}
		}
	 	
	}
	//INSERT INTO patient(`first_name`,`last_name`) VALUES ('St1' , 'Bo2o');
?>

</body>
</html>