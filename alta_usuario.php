<?php
require 'config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'administrativo') {
    header("Location: login.php");
    exit;
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $usuario = trim($_POST['usuario']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    if (!$nombre || !$usuario || !$email || !$password || !$rol) {
        $mensaje = "Por favor completa todos los campos.";
    } else {
        // Hashear la contraseña
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Verificar que usuario o email no existan
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ? OR email = ?");
        $stmt->bind_param("ss", $usuario, $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $mensaje = "El usuario o email ya están en uso.";
        } else {
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, usuario, email, password, rol) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nombre, $usuario, $email, $password_hash, $rol);
            if ($stmt->execute()) {
                $mensaje = "Usuario creado correctamente.";
            } else {
                $mensaje = "Error al crear el usuario.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta de Usuario</title>
        <style>
            /* Reinicio básico para evitar márgenes y paddings por defecto */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Contenedor principal con ancho máximo y centrado */
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 15px;
}

/* Texto e imágenes flexibles */
img, video {
  max-width: 100%;
  height: auto;
}

/* Tipografía responsiva usando unidades relativas */
body {
  font-family: Arial, sans-serif;
  font-size: 16px;
  line-height: 1.5;
}

/* Diseño flexible con flexbox para secciones */
.flex-row {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
}

.flex-item {
  flex: 1 1 300px; /* crece, encoge, base de 300px */
}

/* Media queries para ajustar en pantallas pequeñas */
@media (max-width: 768px) {
  body {
    font-size: 14px;
  }

  .flex-row {
    flex-direction: column;
  }
}

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
<h2>Alta de nuevo usuario</h2>
<p style="color:red;"><?= $mensaje ?></p>
<form method="POST" action="alta_usuario.php">
    <label>Nombre completo:</label><br>
    <input type="text" name="nombre" required><br>

    <label>Usuario:</label><br>
    <input type="text" name="usuario" required><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password" required><br>

    <label>Rol:</label><br>
    <select name="rol" required>
        <option value="vendedor">Vendedor</option>
        <option value="administrativo">Administrativo</option>
    </select><br><br>

    <button type="submit">Crear usuario</button>
</form>
<a href="admin_panel.php">Volver al panel administrativo</a>
</body>
</html>
