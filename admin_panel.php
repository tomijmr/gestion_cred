<?php
require 'config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'administrativo') {
    header("Location: login.php");
    exit;
}

$sql = "SELECT s.*, u.nombre as vendedor 
        FROM solicitudes s 
        JOIN usuarios u ON s.vendedor_id = u.id
        ORDER BY s.creado_en DESC";

$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrativo</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <h2>Panel Administrativo</h2>
    <a href="logout.php">Cerrar Sesión</a>
    <table>
        <tr>
            <th>Cliente</th>
            <th>DNI</th>
            <th>Teléfono</th>
            <th>Vendedor</th>
            <th>Fecha</th>
            <th>Revisado por</th>
            <th>Acción</th>
        </tr>
        <?php while ($row = $res->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['cliente_nombre']) ?></td>
            <td><?= htmlspecialchars($row['dni_cliente']) ?></td>
            <td><?= htmlspecialchars($row['telefono_cliente']) ?></td>
            <td><?= htmlspecialchars($row['vendedor']) ?></td>
            <td><?= $row['creado_en'] ?></td>
            <td>
                <?php 
                if ($row['revisado_por']) {
                    $revisor = $conn->query("SELECT nombre FROM usuarios WHERE id = ".$row['revisado_por'])->fetch_assoc();
                    echo "<span class='revisado'>".$revisor['nombre']."</span>";
                } else {
                    echo "<span class='pendiente'>Pendiente</span>";
                }
                ?>
            </td>
            <td><a href="editar_solicitud.php?id=<?= $row['id'] ?>">Revisar</a></td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
