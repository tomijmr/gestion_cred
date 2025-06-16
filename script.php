<?php
require 'config.php';

$password_plano = "12345";
$password_hash = password_hash($password_plano, PASSWORD_DEFAULT);

$usuario = "idiaz";

$stmt = $conn->prepare("UPDATE usuarios SET password = ? WHERE usuario = ?");
$stmt->bind_param("ss", $password_hash, $usuario);
$stmt->execute();

echo "Contraseña actualizada correctamente.";
?>
