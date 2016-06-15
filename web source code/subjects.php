<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("removed for security");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!--View subjects_tbl table and add data-->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Hogwarts Subjects</title>
	<link rel="stylesheet" href="format.css" type="text/css">
  </head>
  
  <body>
  <!--Display contents of subjects_tbl-->
  <div class="tables">
	<table>
		<tr>
			<td>subjects_tbl</td>
		</tr>
		<tr>
			<td>subject_id</td>
			<td>subject_desc</td>
			<td>taught_by</td>
		</tr>
<?php
if(!($stmt = $mysqli->prepare("SELECT subject_id, subject_desc, taught_by FROM subjects_tbl"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $sub, $taught)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $id . "\n</td>\n<td>\n" . $sub . "\n</td>\n<td>\n" . $taught . "\n</td>\n<td>\n";
}
$stmt->close();
?>
		</table>
	</div>		

<!--Description of subject to be added-->

	<div>
	<form method="post" action="addSubjects.php"> 
		<fieldset>
			<legend>Subject and Teacher:</legend>
			<p>Description: <input type="text" name="Desc" /></p>
<!--Get teacher_id from name-->			
			<legend>Teacher:</legend>
			<select name="Teacher">
<?php
if(!($stmt = $mysqli->prepare("SELECT teacher_id, CONCAT(f_name, ' ', l_name) FROM teachers_tbl"))){
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
		<p><input type="submit" value="Add Subject" /></p>
	</form>
	</div>
	<br><a href="homePage.html">Back to Home</a>
	</body>
</html>