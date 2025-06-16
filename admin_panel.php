<?php
require 'config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'administrativo') {
    header("Location: login.php");
    exit;
}

// Obtener todas las solicitudes
$sql = "SELECT s.*, u.nombre AS vendedor FROM solicitudes s 
        JOIN usuarios u ON s.vendedor_id = u.id 
        ORDER BY s.creado_en DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrativo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
        }

        .container {
            width: 95%;
            max-width: 1200px;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
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
        .parcial { color: red; font-weight: bold; }
        .revisado { color: green; font-weight: bold; }

        a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
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
            <th>Financieras</th>
            <th>Estado General</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { 
            $solicitud_id = $row['id'];

            // Obtener el detalle de financieras para esta solicitud
            $stmtFin = $conn->prepare("SELECT * FROM solicitudes_financieras WHERE solicitud_id = ?");
            $stmtFin->bind_param("i", $solicitud_id);
            $stmtFin->execute();
            $resFin = $stmtFin->get_result();

            $total = 0;
            $revisadas = 0;
            ob_start(); // capturar las financieras
            while ($fin = $resFin->fetch_assoc()) {
                $total++;
                if ($fin['estado'] != 'Pendiente') $revisadas++;
                echo $fin['financiera'] . ": ";
                if ($fin['estado'] == 'Pendiente') {
                    echo "<span class='pendiente'>Pendiente</span>";
                } elseif ($fin['estado'] == 'Aprobado') {
                    echo "<span class='revisado'>Aprobado ($".$fin['monto_aprobado'].")</span>";
                } elseif ($fin['estado'] == 'Rechazado') {
                    echo "<span class='parcial'>Rechazado</span>";
                }
                echo "<br>";
            }
            $financieras_html = ob_get_clean();

            if ($total == 0) {
                $estadoGeneral = "<span class='pendiente'>Sin financieras</span>";
            } elseif ($revisadas == 0) {
                $estadoGeneral = "<span class='pendiente'>Pendiente</span>";
            } elseif ($revisadas < $total) {
                $estadoGeneral = "<span class='parcial'>En proceso</span>";
            } else {
                $estadoGeneral = "<span class='revisado'>Completado</span>";
            }
        ?>
        <tr>
            <td><?= htmlspecialchars($row['cliente_nombre']) ?></td>
            <td><?= htmlspecialchars($row['dni_cliente']) ?></td>
            <td><?= htmlspecialchars($row['telefono_cliente']) ?></td>
            <td><?= htmlspecialchars($row['vendedor']) ?></td>
            <td><?= $row['creado_en'] ?></td>
            <td><?= $financieras_html ?></td>
            <td><?= $estadoGeneral ?></td>
            <td><a href="editar_solicitud.php?id=<?= $solicitud_id ?>">Editar</a></td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
