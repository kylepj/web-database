<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("removed for security");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!--View teachers_tbl table and add data-->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Hogwarts Teachers</title>
	<link rel="stylesheet" href="format.css" type="text/css">
  </head>
  
  <body>
  <!--Display contents of teachers_tbl-->
  <div class="tables">
	<table>
		<tr>
			<td>teachers_tbl</td>
		</tr>
		<tr>
			<td>teacher_id</td>
			<td>f_name</td>
			<td>l_name</td>
		</tr>
<?php
if(!($stmt = $mysqli->prepare("SELECT teacher_id, f_name, l_name FROM teachers_tbl"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $fname, $lname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $id . "\n</td>\n<td>\n" . $fname . "\n</td>\n<td>\n" . $lname . "\n</td>\n<td>\n";
}
$stmt->close();
?>
		</table>
	</div>		

<!--Description of teacher to be added-->

	<div>
	<form method="post" action="addTeachers.php"> 
		<fieldset>
			<legend>Teacher Name:</legend>
			<p>First Name: <input type="text" name="Fname" /></p>
			<p>Last Name: <input type="text" name="Lname" /></p>
		</fieldset>
		<p><input type="submit" value="Add Teacher" /></p>
	</form>
	</div>
	<br><a href="homePage.html">Back to Home</a>
	</body>
</html>