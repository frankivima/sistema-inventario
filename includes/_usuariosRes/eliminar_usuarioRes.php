<?php
session_start();
error_reporting(0);

$varsesion = $_SESSION['username'];
if ($varsesion == null || $varsesion == '') {
    header("Location: ../_sesion/login.php");
    exit;
}

include "../db.php";

$id = intval($_GET['id']); // Sanear el ID

if ($id > 0) {
    $query = mysqli_query($conexion, "DELETE FROM usuarios_responsables WHERE id = $id");
}

// Redirige de vuelta a la página de unidades
header('Location: ../../views/unidades.php?m=1');
exit;
?>
