<?php
require 'config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['rol'] == 'administrativo') {
    header("Location: admin_panel.php");
} else {
    header("Location: panel_vendedor.php");
}
exit;
?>
