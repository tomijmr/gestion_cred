<?php
require 'config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'administrativo') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: admin_panel.php");
    exit;
}

$solicitud_id = intval($_GET['id']);

// Marcar quien está revisando la solicitud (si aún no tiene revisor)
$conn->query("UPDATE solicitudes SET revisado_por = {$_SESSION['usuario_id']} WHERE id = $solicitud_id AND revisado_por IS NULL");

// Traer datos generales de la solicitud
$stmt = $conn->prepare("SELECT s.*, u.nombre as vendedor FROM solicitudes s JOIN usuarios u ON s.vendedor_id = u.id WHERE s.id = ?");
$stmt->bind_param("i", $solicitud_id);
$stmt->execute();
$res = $stmt->get_result();
$solicitud = $res->fetch_assoc();

// Financieras
$res_financieras = $conn->query("SELECT * FROM solicitudes_financieras WHERE solicitud_id = $solicitud_id");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Solicitud</title>
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
    <h2>Revisión de Solicitud</h2>
    <p><b>Cliente:</b> <?= htmlspecialchars($solicitud['cliente_nombre']) ?></p>
    <p><b>DNI:</b> <?= htmlspecialchars($solicitud['dni_cliente']) ?></p>
    <p><b>Teléfono:</b> <?= htmlspecialchars($solicitud['telefono_cliente']) ?></p>
    <p><b>Vendedor:</b> <?= htmlspecialchars($solicitud['vendedor']) ?></p>

    <form method="post" action="guardar_financieras.php">
        <input type="hidden" name="solicitud_id" value="<?= $solicitud_id ?>">
        <table>
            <tr>
                <th>Financiera</th>
                <th>Estado</th>
                <th>Monto Aprobado</th>
                <th>Observaciones</th>
            </tr>
            <?php while ($fin = $res_financieras->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($fin['financiera']) ?></td>
                <td>
                    <select name="estado[<?= $fin['id'] ?>]">
                        <option value="Pendiente" <?= $fin['estado'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                        <option value="Aprobado" <?= $fin['estado'] == 'Aprobado' ? 'selected' : '' ?>>Aprobado</option>
                        <option value="Rechazado" <?= $fin['estado'] == 'Rechazado' ? 'selected' : '' ?>>Rechazado</option>
                    </select>
                </td>
                <td><input type="number" name="monto[<?= $fin['id'] ?>]" value="<?= $fin['monto_aprobado'] ?>" step="1000"></td>
                <td><input type="text" name="obs[<?= $fin['id'] ?>]" value="<?= htmlspecialchars($fin['observaciones']) ?>"></td>
            </tr>
            <?php } ?>
        </table>
        <button type="submit">Guardar Cambios</button>
    </form>
    <br><a href="admin_panel.php">Volver al Panel</a>
</div>
</body>
</html>
