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

// Procesar el formulario al guardar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['financiera_id'] as $index => $financiera_id) {
        $estado = $_POST['estado'][$index];
        $monto = ($_POST['monto'][$index] !== '') ? floatval($_POST['monto'][$index]) : null;
        $revisado_por = $_SESSION['usuario_id'];

        $stmt = $conn->prepare("UPDATE solicitudes_financieras SET estado = ?, monto_aprobado = ?, revisado_por = ? WHERE id = ?");
        $stmt->bind_param("sdii", $estado, $monto, $revisado_por, $financiera_id);
        $stmt->execute();
    }
    header("Location: admin_panel.php");
    exit;
}

// Obtener datos de la solicitud
$stmt = $conn->prepare("SELECT s.*, u.nombre AS vendedor FROM solicitudes s JOIN usuarios u ON s.vendedor_id = u.id WHERE s.id = ?");
$stmt->bind_param("i", $solicitud_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows == 0) {
    echo "Solicitud no encontrada.";
    exit;
}

$solicitud = $res->fetch_assoc();

// Obtener las financieras
$stmt2 = $conn->prepare("SELECT f.*, u.nombre AS revisado_nombre FROM solicitudes_financieras f LEFT JOIN usuarios u ON f.revisado_por = u.id WHERE solicitud_id = ?");
$stmt2->bind_param("i", $solicitud_id);
$stmt2->execute();
$financieras = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Solicitud</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f0f2f5; }
        .container { width: 90%; max-width: 800px; margin: 40px auto; background: #fff; padding: 20px; border-radius: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        input[type="number"] { width: 100px; }
        select { width: 120px; }
        button { margin-top: 20px; padding: 10px 30px; background-color: #007bff; color: white; border: none; border-radius: 5px; }
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<div class="container">
    <h2>Editar Solicitud</h2>
    <p><strong>Cliente:</strong> <?= htmlspecialchars($solicitud['cliente_nombre']) ?></p>
    <p><strong>DNI:</strong> <?= htmlspecialchars($solicitud['dni_cliente']) ?></p>
    <p><strong>Teléfono:</strong> <?= htmlspecialchars($solicitud['telefono_cliente']) ?></p>
    <p><strong>Vendedor:</strong> <?= htmlspecialchars($solicitud['vendedor']) ?></p>

    <form method="post">
        <table>
            <tr>
                <th>Financiera</th>
                <th>Estado</th>
                <th>Monto Aprobado</th>
                <th>Revisado por</th>
            </tr>
            <?php while ($fin = $financieras->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($fin['financiera']) ?></td>
                <td>
                    <input type="hidden" name="financiera_id[]" value="<?= $fin['id'] ?>">
                    <select name="estado[]">
                        <option value="Pendiente" <?= ($fin['estado']=='Pendiente') ? 'selected' : '' ?>>Pendiente</option>
                        <option value="Aprobado" <?= ($fin['estado']=='Aprobado') ? 'selected' : '' ?>>Aprobado</option>
                        <option value="Rechazado" <?= ($fin['estado']=='Rechazado') ? 'selected' : '' ?>>Rechazado</option>
                    </select>
                </td>
                <td><input type="number" name="monto[]" step="1000" value="<?= $fin['monto_aprobado'] ?>"></td>
                <td><?= $fin['revisado_nombre'] ?? '-' ?></td>
            </tr>
            <?php } ?>
        </table>
        <button type="submit">Guardar Cambios</button>
    </form>

    <br><a href="admin_panel.php">Volver al Panel</a>
</div>

</body>
</html>
