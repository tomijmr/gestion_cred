<?php
require 'config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'administrativo') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $solicitud_id = intval($_POST['solicitud_id']);

    foreach ($_POST['estado'] as $financiera_id => $estado) {
        $monto = floatval($_POST['monto'][$financiera_id]);
        $obs = $_POST['obs'][$financiera_id];

        $stmt = $conn->prepare("UPDATE solicitudes_financieras SET estado=?, monto_aprobado=?, observaciones=? WHERE id=?");
        $stmt->bind_param("sdsi", $estado, $monto, $obs, $financiera_id);
        $stmt->execute();
    }
}

header("Location: admin_panel.php");
exit;
?>
