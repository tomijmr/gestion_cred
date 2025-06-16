<?php
require 'config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'vendedor') {
    header("Location: login.php");
    exit;
}

$vendedor_id = $_SESSION['usuario_id'];

$stmt = $conn->prepare("SELECT * FROM solicitudes WHERE vendedor_id = ? ORDER BY creado_en DESC");
$stmt->bind_param("i", $vendedor_id);
$stmt->execute();
$res = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Solicitudes</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <h2>Mis Solicitudes</h2>
    <a href="nueva_solicitud.php">Nueva Solicitud</a> | <a href="logout.php">Cerrar Sesión</a>
    <table>
        <tr>
            <th>Cliente</th>
            <th>DNI</th>
            <th>Fecha</th>
            <th>Estado</th>
        </tr>
        <?php while ($row = $res->fetch_assoc()) {
            $solicitud_id = $row['id'];
            // Verificar si alguna financiera fue revisada
            $fin = $conn->query("SELECT COUNT(*) AS total, SUM(estado != 'Pendiente') AS revisadas FROM solicitudes_financieras WHERE solicitud_id = $solicitud_id");
            $fin_row = $fin->fetch_assoc();

            $total = $fin_row['total'];
            $revisadas = $fin_row['revisadas'];

            if ($total == 0) {
                $estado = "<span class='pendiente'>Sin financieras</span>";
            } elseif ($revisadas == 0) {
                $estado = "<span class='pendiente'>Pendiente</span>";
            } elseif ($revisadas < $total) {
                $estado = "<span class='parcial'>En proceso</span>";
            } else {
                $estado = "<span class='revisado'>Completado</span>";
            }
        ?>
        <tr>
            <td><?= htmlspecialchars($row['cliente_nombre']) ?></td>
            <td><?= htmlspecialchars($row['dni_cliente']) ?></td>
            <td><?= $row['creado_en'] ?></td>
            <td><?= $estado ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
