<?php
include "../db.php";

$unidad_id = intval($_GET['unidad_id']);
$result = mysqli_query($conexion, "SELECT id, nombre, apellido FROM usuarios_responsables WHERE unidad_id = $unidad_id ORDER BY nombre ASC");

$usuarios = [];
while($row = mysqli_fetch_assoc($result)){
    $usuarios[] = $row;
}

header('Content-Type: application/json');
echo json_encode($usuarios);
