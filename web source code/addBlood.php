<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("removed for security");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!--View blood_status table and add data-->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Blood Status</title>
	<link rel="stylesheet" href="format.css" type="text/css">
  </head>
  
  <body>
  <!--Display contents of blood_status-->
  <div class="tables">
	<table>
		<tr>
			<td>blood_status</td>
		</tr>
		<tr>
			<td>blood_id</td>
			<td>blood_status</td>
		</tr>
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
 echo "<tr>\n<td>\n" . $id . "\n</td>\n<td>\n" . $status . "\n</td>\n<td>\n";
}
$stmt->close();
?>
		</table>
	</div>		

<!--Description of Blood Status to be added-->

	<div>
	<form method="post" action="addBloodResults.php"> 
		<fieldset>
			<legend>Blood Status Description:</legend>
			<p>Blood Status: <input type="text" name="Status" /></p>
		</fieldset>
		<p><input type="submit" value="Add Blood Status" /></p>
	</form>
	</div>
	<br><a href="homePage.html">Back to Home</a>
	</body>
</html>
	
