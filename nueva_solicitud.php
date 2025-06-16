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
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    input[type="text"], button {
        width: 100%;
        padding: 10px;
        margin: 5px 0 15px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        background-color: #4CAF50;
        color: white;
        border: none;
        font-weight: bold;
    }

    .financieras {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .financiera-item {
        background: #f9f9f9;
        border: 1px solid #ccc;
        padding: 10px 15px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        min-width: 200px;
    }

    .financiera-item input {
        margin-right: 10px;
    }
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
        <div class="financieras">
            <label class="financiera-item"><input type="checkbox" name="financieras[]" value="Banco Macro">Banco Macro</label>
            <label class="financiera-item"><input type="checkbox" name="financieras[]" value="Banco Columbia">Banco Columbia</label>
            <label class="financiera-item"><input type="checkbox" name="financieras[]" value="Banco Galicia">Banco Galicia</label>
            <label class="financiera-item"><input type="checkbox" name="financieras[]" value="Argenpesos">Argenpesos</label>
            <label class="financiera-item"><input type="checkbox" name="financieras[]" value="Banco Santander">Banco Santander</label>
            <label class="financiera-item"><input type="checkbox" name="financieras[]" value="Rapicuotas">Rapicuotas</label>
            <label class="financiera-item"><input type="checkbox" name="financieras[]" value="Cuota Red">Cuota Red</label>
            <label class="financiera-item"><input type="checkbox" name="financieras[]" value="Tarjeta Naranja">Tarjeta Naranja</label>
            <label class="financiera-item"><input type="checkbox" name="financieras[]" value="CuotaYa!">CuotaYa!</label>
        </div>

        <button type="submit">Enviar Solicitud</button>
    </form>
    <br>
    <a href="panel_vendedor.php">Volver al Panel</a>
</div>
</body>
</html>
