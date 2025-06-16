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

// session_start();

// $host = "localhost";
// $user = "c2611613_gescred";
// $password = "SI42dakize";
// $dbname = "c2611613_gescred";

// $conn = new mysqli($host, $user, $password, $dbname);
// $conn->set_charset("utf8");

// if ($conn->connect_error) {
//     die("Error de conexión: " . $conn->connect_error);
// }
?>