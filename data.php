<?php
/**
 * filename: data.php
 * description: this will return the score of the teams.
 */

//setting header to json
header('Content-Type: application/json');

$servername = "localhost";

// REPLACE with your Database name
$dbname = "i6442462_wp2";
// REPLACE with Database user
$username = "i6442462_wp2";
// REPLACE with Database user password
$password = "advdsc";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($mysqli->connect_error) {
die("Connection failed: " . $mysqli->connect_error);
}

//query to get data from the table
$query = sprintf("SELECT value1, value2,value5, value6, reading_time FROM SensorData ORDER BY ID ");
//$query = sprintf("SELECT AVG(value1) AS value1_sd, AVG(value2) AS value2_sd, AVG(value5) AS value5_sd, AVG(value6) AS value6_sd, reading_time FROM SensorData ORDER BY ID");
//execute query
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
print json_encode($data); 