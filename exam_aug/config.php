<?php
$host = 'localhost';
$user = 'root';
$pass = '2997';
$dbname = 'webapp';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
