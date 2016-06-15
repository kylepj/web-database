<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("removed for security");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!--forms for manipulating the students_tbl-->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Harry Potter Database</title>
	<link rel="stylesheet" href="format.css" type="text/css">
  </head>
  
  <body>

  <!--View table of students with house name and blood status (sourced from lecture)-->
	
	<div class="tables">
		<table>
		<tr>
			<td>Hogwarts Students, House, and Blood Status</td>
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
INNER JOIN blood_status on blood_status.blood_id = students_tbl.blood_id"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
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
	<br><br>

<!--Add student to table-->
<div class="title">Add Student to Database:</div><br>
<div>
	<form method="post" action="addStudent.php"> 
		<fieldset>
			<legend>Student Name:</legend>
			<p>First Name: <input type="text" name="FirstName" /></p>
			<p>Last Name: <input type="text" name="LastName" /></p>
	
<!--get selection for House-->	
	
			<legend>House:</legend>
			<select name="HouseID">
<?php
if(!($stmt = $mysqli->prepare("SELECT house_id, house_name FROM houses_tbl"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $hname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $hname . '</option>\n';
}
$stmt->close();
?>
			</select>
	
<!--get selection for blood_status-->

			<legend>Blood Status:</legend>
			<select name="BloodID">
<?php
if(!($stmt = $mysqli->prepare("SELECT blood_id, blood_status FROM blood_status"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $status)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $status . '</option>\n';
}
$stmt->close();
?>
			</select>
		</fieldset>
		
		<p><input type="submit" value="Add Student" /></p>
	</form>
</div>

<!--Delete students from table -->

<div class="title">Remove Student from Database:</div><br>
<form method="post" action="removeStudent.php"> 
	<fieldset>
		<legend>Student:</legend>
		<select name="Student">
<?php
if(!($stmt = $mysqli->prepare("SELECT student_id, CONCAT(f_name, ' ', l_name) FROM students_tbl"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $sname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $sname . '</option>\n';
}
$stmt->close();
?>
		</select>
	</fieldset>
	<p><input type="submit" value="Remove Student" /></p>
</form>

<!--Update student House and/or Blood Status-->

<div class="title">Update Student House and Blood Status:</div><br>
	<form method="post" action="updateBlood.php"> 
		<fieldset>
		<legend>Student:</legend>
		<select name="Student">
<?php
if(!($stmt = $mysqli->prepare("SELECT student_id, CONCAT(f_name, ' ', l_name) FROM students_tbl"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $sname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $sname . '</option>\n';
}
$stmt->close();
?>
		</select>
		
	<!--get house_id-->
		
		<legend>Set New House:</legend>
		<select name="HouseID2">
<?php
if(!($stmt = $mysqli->prepare("SELECT house_id, house_name FROM houses_tbl"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $hname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $hname . '</option>\n';
}
$stmt->close();
?>
		</select>
			
	<!--get blood_status id-->
			
		<legend>Set New Blood Status:</legend>
		<select name="BloodID2">
<?php
if(!($stmt = $mysqli->prepare("SELECT blood_id, blood_status FROM blood_status"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $status)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $status . '</option>\n';
}
$stmt->close();
?>
		</select>	
	</fieldset>
	<p><input type="submit" value="Update Student" /></p>
	</form>
</div>

<!--Filter students by House-->

<div class="title">Filter Students by House:</div><br>
	<form method="post" action="filterStudents.php"> 
		<fieldset>
			<legend>House:</legend>
		<select name="HouseID3">
<?php
if(!($stmt = $mysqli->prepare("SELECT house_id, house_name FROM houses_tbl"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $hname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $hname . '</option>\n';
}
$stmt->close();
?>
		</select>
	</fieldset>
	<p><input type="submit" value="Filter Students" /></p>
	</form>
</div>

<br><a href="homePage.html">Back to Home</a>

  </body>
</html>
  