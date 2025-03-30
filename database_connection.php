<?php
$hostName = "localhost";
$serverUsername = "root";
$serverPassword = "";
$databaseName = "cms_db";

$connection = mysqli_connect($hostName, $serverUsername, $serverPassword, $databaseName);

if (!$connection) {
    die("Error Code: " . mysqli_connect_errno() . "<br>" . "Error: " . mysqli_connect_error());
} else {
    return $connection;
}
