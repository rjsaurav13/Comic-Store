<?php
//Database Authentication
$username = "root";
$password = "";
$server = 'localhost';
$database = 'comicstore';

// Email Information
$from = "rjsaurav13@gmail.com";
$fromName = 'Comic Store';
$headers = "From: $fromName" . " <" . $from . ">";

$hostname = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ' ';

// Connecting database.
$con = mysqli_connect($server, $username, $password, $database);
if ($con->connect_error) {
    die('Not Connected: ' . $con->connect_error);
}
