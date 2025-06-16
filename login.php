<?php
require 'config.php';

if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, nombre, usuario, password, rol FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $usuario = $res->fetch_assoc();

        if (password_verify($pass, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Gestión Créditos</title>
    <link rel="stylesheet" href="assets/style.css">
        <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f0f2f5;
}

.container {
    width: 90%;
    max-width: 700px;
    margin: 40px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
}

input, button {
    width: 100%;
    padding: 10px;
    margin: 5px 0 15px 0;
}

button {
    background-color: #4CAF50;
    color: white;
    border: none;
}

.error {
    color: red;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
}

.pendiente { color: orange; font-weight: bold; }
.parcial { color: blue; font-weight: bold; }
.revisado { color: green; font-weight: bold; }

</style>
</head>
<body>
<div class="container">
    <h2>Iniciar Sesión</h2>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
<form method="POST" action="login.php">
    <label for="usuario">Usuario:</label>
    <input type="text" name="usuario" id="usuario" required>

    <label for="password">Contraseña:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Ingresar</button>
</form>

</div>
</body>
</html>
