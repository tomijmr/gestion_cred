<?php
require 'config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'vendedor') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_nombre = $_POST['cliente_nombre'];
    $dni_cliente = $_POST['dni_cliente'];
    $telefono_cliente = $_POST['telefono_cliente'];
    $financieras = isset($_POST['financieras']) ? $_POST['financieras'] : [];

    $stmt = $conn->prepare("INSERT INTO solicitudes (vendedor_id, cliente_nombre, dni_cliente, telefono_cliente) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $_SESSION['usuario_id'], $cliente_nombre, $dni_cliente, $telefono_cliente);
    $stmt->execute();

    $solicitud_id = $stmt->insert_id;

    foreach ($financieras as $financiera) {
        $stmt2 = $conn->prepare("INSERT INTO solicitudes_financieras (solicitud_id, financiera) VALUES (?, ?)");
        $stmt2->bind_param("is", $solicitud_id, $financiera);
        $stmt2->execute();
    }

    header("Location: panel_vendedor.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Solicitud</title>
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
    <h2>Nueva Solicitud</h2>
    <form method="post">
        <input type="text" name="cliente_nombre" placeholder="Nombre del Cliente" required>
        <input type="text" name="dni_cliente" placeholder="DNI" required>
        <input type="text" name="telefono_cliente" placeholder="Teléfono" required>

        <h4>Seleccionar Financieras:</h4>
        <label><input type="checkbox" name="financieras[]" value="Banco Macro"> Banco Macro</label><br>
        <label><input type="checkbox" name="financieras[]" value="Banco Columbia"> Banco Columbia</label><br>
        <label><input type="checkbox" name="financieras[]" value="Banco Galicia"> Banco Galicia</label><br>

        <button type="submit">Enviar Solicitud</button>
    </form>
    <br>
    <a href="panel_vendedor.php">Volver al Panel</a>
</div>
</body>
</html>
