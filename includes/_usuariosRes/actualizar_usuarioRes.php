<?php
include "../db.php";

$id = intval($_POST['id']);
$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
$apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
$cargo = mysqli_real_escape_string($conexion, $_POST['cargo']);
$unidad_id = intval($_POST['unidad_id']);

mysqli_query($conexion, "UPDATE usuarios_responsables SET nombre='$nombre', apellido='$apellido', cargo='$cargo', unidad_id=$unidad_id WHERE id=$id");

header("Location: ../../views/unidades.php?m=2"); // Puedes usar m=2 para mensaje "actualizado"
exit;
?>
