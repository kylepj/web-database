<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("removed for security");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>
<!--filtered list of subjects by student name-->

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
		<td>Subjects Taken by Student:</td>
		</tr>
		<tr>
			<td>Subject</td>
			<td>Teacher First Name</td>
			<td>Teacher Last Name</td>
		</tr>
<?php
if(!($stmt = $mysqli->prepare("SELECT subjects_tbl.subject_desc, teachers_tbl.f_name, teachers_tbl.l_name
FROM students_tbl
INNER JOIN takes_subject on takes_subject.student_id = students_tbl.student_id
INNER JOIN	subjects_tbl on subjects_tbl.subject_id = takes_subject.subject_id
INNER JOIN  teachers_tbl on teachers_tbl.teacher_id = subjects_tbl.taught_by
WHERE students_tbl.student_id=?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!($stmt->bind_param("i",$_POST['Student']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($subject, $fname, $lname)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $subject . "\n</td>\n<td>\n" . $fname . "\n</td>\n<td>\n" . $lname . "\n</td>\n<td>\n";
}
$stmt->close();
?>
		</table>
	</div>		
	<br><a href="classList.php">Back</a>
</body>
</html>