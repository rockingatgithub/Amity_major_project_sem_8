 <!DOCTYPE html>
<html><body  <div style="background-image: url('111.jpeg');"> >


<style>
* {
box-sizing: border-box;
}

body {
font-family: Arial, Helvetica, sans-serif;
}



a:link {
  text-decoration: none;
  background-color: yellow;
}

a:visited {
  text-decoration: none;
    background-color: cyan;
}

a:hover {
  text-decoration: underline;
  background-color: lightgreen;
}

a:active {
  text-decoration: underline;
    background-color: hotpink;
}

/* Float four columns side by side */
.column {
float: left;
width: 33.33%;
padding: 0 10px;
 margin-top: 30px;
}

/* Remove extra left and right margins, due to padding */
.row {margin: 0 -5px;}

/* Clear floats after the columns */
.row:after {
content: "";
display: table;
clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
.column {
width: 100%;
display: block;
margin-bottom: 20px;
 font-weight: bold;
}
}


/* Style the counter cards */
.card {
box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
padding: 16px;
border-radius: 25px;
opacity: 0.7;
text-align: center;
background-color: #83c9ec;
border: 5px solid black;
font-weight: bold;
}
</style>

<?php
header("refresh: 15");

echo date('H:i:s Y-m-d');


$servername = "localhost";


// REPLACE with your Database name
$dbname = "i6442462_wp2";
// REPLACE with Database user
$username = "i6442462_wp2";
// REPLACE with Database user password
$password = "advdsc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, value1, value2, value3, value4, value5, value6, reading_time FROM SensorData ORDER BY ID DESC LIMIT 1";


if ($result = $conn->query($sql)) {
while ($row = $result->fetch_assoc()) {
$row_id = $row["id"];
$row_value1 = $row["value1"];
$row_value2 = $row["value2"];
$row_value3 = $row["value3"];
$row_value4 = $row["value4"];
$row_value5 = $row["value5"];
$row_value6 = $row["value6"];

$row_reading_time = $row["reading_time"];

$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 12 hours"));

$temp_color = '#000000';
$temp1_color = "#000000";


if( $row_value1 < 96 or $row_value1 > 99){
    $temp_color = '#ff0000';
}
else {$temp1_color = '#000000';}




//if( $row_value6 < 10.00 and $row_value6 < 23.00){
// $row_value6  = '15.3624' ;
//}



echo '

<h1 style="color:white" align = "center">Health-Care Monitoring For Quarantine patients(Covid -19)</h1>
<h2 style="color:white" align = "center">DATA FROM SENSORS</h2>
<p style="color:yellow" align = "center"><a href="http://indocorpolex.com/hello/graph.html">Click Here For Graph!</a> <br><br> <a href="http://indocorpolex.com/hello/home.html">Go Back to Home Page</a> </p>


<div class="row">
<div class="column">
<div class="center">


</div>

<div class="card">
<h3 style="color:Black">TEMPERATURE</h3>
<div class="centered">

<p style="color:black">IN CENTIGRADE</p>
<p style=" color: '. $temp_color .' "> '. $row_value1 . '</p>
</div>
</div>
</div>

<div class="column">
<div class="card">
<h3 style="color:black">Heart Rate</h3>
<p style="color:black">VALUES</p>
<p style="color:black">'. $row_value2 . '</p>
</div>
</div>

<div class="column">
<div class="card">
<h3 style="color:black">Pulse rate</h3>
<p style="color:black"> VALUES</p>
<p style="color:black">'. $row_value5 . '</p>
</div>
</div>

<div class="column">
<div class="card">
<h3 style="color:black">Gyroscope</h3>
<p style="color:black">IN Axis inclination</p>
<p style="color:black" > Fallen </p>

</div>
</div>
<div class="column">
<div class="card">
<h3 style="color:black">LATITUDE</h3>
<p style="color:black"> VALUES</p>
<p style="color:black">22.5703</p>
</div>
</div>

<div class="column">
<div class="card">
<h3 style="color:black">LONGITUDE</h3>
<p style="color:black"> VALUES</p>
<p style="color:black">88.5116</p>
</div>
</div>
</div>

</br>

<div id="googleMap" style="width:90%;height:320px; margin-left:50px;"></div>

<script>
function myMap() {
var mapProp= {
center:new google.maps.LatLng( '. $row_value3 . ','. $row_value4 .'),
zoom:5,
};
var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAk4BBCmeZuWv0oV_uTjF9wBeW9YocUbOc&callback=myMap"></script>



';
}
$result->free();
}

$conn->close();
?>

</body>
</html>