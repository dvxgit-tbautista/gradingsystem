<?php

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbName = "gradingsystem";

$connection = mysqli_connect($servername, $dbusername, $dbpassword, $dbName);

if (!$connection) {
    die("Connection Failed!" . mysqli_connect_error());
}
