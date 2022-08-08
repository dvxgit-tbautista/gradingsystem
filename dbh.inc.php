<?php

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbName = "gradingsystem";

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbName);

if (!$conn) {
	die("Connection Failed!" . mysqli_connect_error());
}
