<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("removed for security");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!--View houses_tbl table and add data-->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Hogwarts Houses</title>
	<link rel="stylesheet" href="format.css" type="text/css">
  </head>
  
  <body>
  <!--Display contents of houses_tbl-->
  <div class="tables">
	<table>
		<tr>
			<td>houses_tbl</td>
		</tr>
		<tr>
			<td>house_id</td>
			<td>house_name</td>
			<td>mascot</td>
		</tr>
<?php
if(!($stmt = $mysqli->prepare("SELECT house_id, house_name, mascot FROM houses_tbl"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $house, $mascot)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $id . "\n</td>\n<td>\n" . $house . "\n</td>\n<td>\n" . $mascot . "\n</td>\n<td>\n";
}
$stmt->close();
?>
		</table>
	</div>		

<!--Description of House to be added-->

	<div>
	<form method="post" action="addHouse.php"> 
		<fieldset>
			<legend>House Name and Mascot:</legend>
			<p>Name: <input type="text" name="House" /></p>
			<p>Mascot: <input type="text" name="Mascot" /></p>
		</fieldset>
		<p><input type="submit" value="Add House" /></p>
	</form>
	</div>
	<br><a href="homePage.html">Back to Home</a>
	</body>
</html>