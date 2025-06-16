<?php
require 'config.php';

if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "Hubo un problema al iniciar sesión. Por favor, inténtelo de nuevo.";

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
