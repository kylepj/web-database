<!--update blood_status and/or house for students_tbl-->

<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("removed for security");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

if(!($stmt = $mysqli->prepare("UPDATE students_tbl SET house_id=?, blood_id=? WHERE student_id=?"))){
echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!($stmt->bind_param("iii",$_POST['HouseID2'], $_POST['BloodID2'],$_POST['Student']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Updated " . $stmt->affected_rows . " rows in students_tbl.";
}
?>

<br>
<a href="main.php">Back to Main Page</a>