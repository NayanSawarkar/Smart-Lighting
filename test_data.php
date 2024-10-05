<?php
 
$hostname = "localhost";
$username = "root";
$password = "";
$database = "sensorinformation";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}

echo "Database connection is OK";

if (isset($_POST["id"]) && isset($_POST["status"])) {
   $ld = $_POST["id"];
   $st = $_POST["status"];

   $sql = "UPDATE dht11 SET status='$st', datetime=NOW() WHERE id='$ld'";

   if (mysqli_query($conn, $sql)) {
       echo "Record updated successfully";
   } else {
       echo "Error updating record: " . mysqli_error($conn);
   }
}

?>
