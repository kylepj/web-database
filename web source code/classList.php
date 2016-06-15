<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("removed for security");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Subject and Student List</title>
	<link rel="stylesheet" href="format.css" type="text/css">
  </head>
  
  <body>

  <!--view list of subjects, teachers, and all students taking subject-->
	
	<div class="tables">
		<table>
		<tr>
			<td>Subjects, Teachers, and Students Taking Subject</td>
		</tr>
		<tr>
			<td>Subject</td>
			<td>Student First Name</td>
			<td>Student Last Name</td>
			<td>Teacher First Name</td>
			<td>Teacher Last Name</td>
			
		</tr>
<?php
if(!($stmt = $mysqli->prepare("SELECT subjects_tbl.subject_desc, students_tbl.f_name, students_tbl.l_name, teachers_tbl.f_name, teachers_tbl.l_name
FROM students_tbl
INNER JOIN takes_subject on takes_subject.student_id = students_tbl.student_id
INNER JOIN	subjects_tbl on subjects_tbl.subject_id = takes_subject.subject_id
INNER JOIN teachers_tbl on teachers_tbl.teacher_id = subjects_tbl.taught_by
ORDER BY subjects_tbl.subject_desc"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($subject, $fname, $lname, $tnamef, $tnamel)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $subject . "\n</td>\n<td>\n" . $fname . "\n</td>\n<td>\n" . $lname . "\n</td>\n<td>\n" . $tnamef . "\n</td>\n<td>\n" . $tnamel . "\n</td>\n<td>\n" ;
}
$stmt->close();
?>
		</table>
	</div>		
	<br><br>
	
<!--filter subjects taken by student-->
	
<div class="title">View Subjects Taken by Student:</div><br>
<form method="post" action="filterSubjects.php"> 
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
	<p><input type="submit" value="See Student Subjects" /></p>
</form>

<!--add student/subject to takes_subject relationship table (many to many)-->

<div class="title">Add Student to Subject:</div><br>
	<form method="post" action="addStoS.php"> 
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

	<!--get subject to add student to-->
		
	<legend>Subject:</legend>
		<select name="Subject">
<?php
if(!($stmt = $mysqli->prepare("SELECT subject_id, subject_desc FROM subjects_tbl"))){
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
	<p><input type="submit" value="Add Student" /></p>
	</form>
	</div>
	
<!--Remove Students from a class-->

<div class="title">Remove Student From Subject:</div><br>
	<form method="post" action="removeSS.php"> 
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
	
	<legend>Subject:</legend>
		<select name="Subject">
<?php
if(!($stmt = $mysqli->prepare("SELECT subject_id, subject_desc FROM subjects_tbl"))){
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
	</div>

<!--Update subject teacher-->

<div class="title">Update Subject Teacher:</div><br>
	<form method="post" action="updateTeacher.php"> 
		<fieldset>
			<legend>Subject to Update:</legend>
			<select name="Subject">
<?php
if(!($stmt = $mysqli->prepare("SELECT subject_id, subject_desc FROM subjects_tbl"))){
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

<legend>Update Teacher to:</legend>
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
	<p><input type="submit" value="Update Teacher" /></p>
	</form>
	</div>
	<br><a href="homePage.html">Back to Home Page</a>

  </body>
  </html>