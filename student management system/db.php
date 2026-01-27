<?php 
$host = "127.0.0.1";
$user = "root";
$pass = "root";
$db = "students";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed:" . mysqli_connect_error());
}
?>