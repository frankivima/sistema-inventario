<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../db.php';

$q = $_GET['q'] ?? '';
$q = mysqli_real_escape_string($conexion, $q);

$sql = "
SELECT 
    e.id,
    CONCAT(
        '[#', SUBSTRING_INDEX(e.codigo_bienes, '-', -1), '] ',
        e.tipo_equipo, ' ',
        e.marca, ' ',
        e.modelo,
        IF(e.serial IS NOT NULL AND e.serial <> '', CONCAT(' - ', e.serial), ''),
        ' | ',
        IFNULL(u.nombre_unidad, 'Sin unidad'),
        IF(res.nombre IS NOT NULL AND res.nombre <> '', 
            CONCAT(' (', res.nombre, ' ', res.apellido,') '),
            ' (Sin responsable)'
        )
    ) AS text,
    SUBSTRING_INDEX(e.codigo_bienes, '-', -1) AS codigo_corto
FROM equipos e
LEFT JOIN unidades u ON e.unidad_id = u.id
LEFT JOIN usuarios_responsables res ON e.usuarioRes_id = res.id
WHERE 
    e.tipo_equipo LIKE '%$q%' OR 
    e.serial LIKE '%$q%' OR
    e.codigo_bienes LIKE '%$q%' OR
    SUBSTRING_INDEX(e.codigo_bienes, '-', -1) LIKE '%$q%' OR
    u.nombre_unidad LIKE '%$q%' OR
    res.nombre LIKE '%$q%' OR
    res.apellido LIKE '%$q%'
LIMIT 20
";

$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    http_response_code(500);
    echo json_encode(["error" => "SQL Error", "detalle" => mysqli_error($conexion)]);
    exit;
}

$datos = [];
while($row = mysqli_fetch_assoc($resultado)){
    $datos[] = $row;
}

header('Content-Type: application/json');
echo json_encode($datos, JSON_PRETTY_PRINT);
