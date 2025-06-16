<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "gestion_creditos";

$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
