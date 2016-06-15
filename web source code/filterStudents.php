<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("removed for security");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!--filter students by House and view associated students and blood_status-->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Harry Potter Database - Filtered</title>
	<link rel="stylesheet" href="format.css" type="text/css">
  </head>
  
  <body>	
	<div class="tables">
		<table>
		<tr>
			<td>Hogwarts Students by House</td>
		</tr>
		<tr>
			<td>First Name</td>
			<td>Last Name</td>
			<td>House</td>
			<td>Blood Status</td>
		</tr>
<?php
if(!($stmt = $mysqli->prepare("SELECT students_tbl.f_name, students_tbl.l_name, houses_tbl.house_name, blood_status.blood_status
FROM students_tbl
INNER JOIN houses_tbl on houses_tbl.house_id = students_tbl.house_id
INNER JOIN blood_status on blood_status.blood_id = students_tbl.blood_id
WHERE students_tbl.house_id = ?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!($stmt->bind_param("i",$_POST['HouseID3']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($fname, $lname, $hname, $bstatus )){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $fname . "\n</td>\n<td>\n" . $lname . "\n</td>\n<td>\n" . $hname . "\n</td>\n<td>\n" . $bstatus . "\n</td>\n</tr>";
}
$stmt->close();
?>
		</table>
	</div>	

<br>
<a href="main.php">Back to Main Page</a>	
	
</body>
</html>