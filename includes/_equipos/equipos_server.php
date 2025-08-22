<?php
session_start();

// Mostrar errores de PHP para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "../db.php";

// Estructura inicial
$output = [
    "draw" => intval($_POST['draw'] ?? 0),
    "recordsTotal" => 0,
    "recordsFiltered" => 0,
    "data" => []
];

if (!$conexion) {
    $output["error"] = "Error de conexión a la base de datos.";
    echo json_encode($output);
    exit;
}

// Total registros
$resultTotal = mysqli_query($conexion, "SELECT COUNT(*) AS total FROM equipos");
if (!$resultTotal) {
    $output["error"] = "Error al obtener total de registros: " . mysqli_error($conexion);
    echo json_encode($output);
    exit;
}
$totalRecords = mysqli_fetch_assoc($resultTotal)['total'];
$output['recordsTotal'] = $totalRecords;
$output['recordsFiltered'] = $totalRecords;

// Columnas para ordenar
$columns = [
    "CAST(SUBSTRING_INDEX(e.codigo_bienes, '-', -1) AS UNSIGNED)", 
    "u.nombre_unidad", 
    "usuario_responsable", 
    "tipo_equipo", 
    "estado"
];

// Ordenamiento
$orderColumnIndex = intval($_POST['order'][0]['column'] ?? 0);
$orderDir = $_POST['order'][0]['dir'] ?? 'asc';
$orderDir = ($orderDir === 'asc' || $orderDir === 'desc') ? $orderDir : 'asc';
$orderColumnName = $columns[$orderColumnIndex] ?? $columns[0];
$orderClause = "$orderColumnName $orderDir";

// Búsqueda
$searchTerm = $_POST['search']['value'] ?? '';
$query = "SELECT e.*, u.nombre_unidad
          FROM equipos e
          LEFT JOIN unidades u ON e.unidad_id = u.id";

if (!empty($searchTerm)) {
    $searchTerm = mysqli_real_escape_string($conexion, $searchTerm);
    $query .= " WHERE e.codigo_bienes LIKE '%$searchTerm%'
                OR u.nombre_unidad LIKE '%$searchTerm%'
                OR e.usuario_responsable LIKE '%$searchTerm%'
                OR e.tipo_equipo LIKE '%$searchTerm%'
                OR e.estado LIKE '%$searchTerm%'";
}

// Registros filtrados
$resultFiltered = mysqli_query($conexion, $query);
if (!$resultFiltered) {
    $output["error"] = "Error en filtrado: " . mysqli_error($conexion);
    echo json_encode($output);
    exit;
}
$output['recordsFiltered'] = mysqli_num_rows($resultFiltered);

// Paginación
$start = intval($_POST['start'] ?? 0);
$length = intval($_POST['length'] ?? 20);
$query .= " ORDER BY $orderClause LIMIT $start, $length";

// Ejecutar query final
$result = mysqli_query($conexion, $query);
if (!$result) {
    $output["error"] = "Error en consulta final: " . mysqli_error($conexion);
    echo json_encode($output);
    exit;
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {

    // Manejo de código de bienes
    $codigo_bienes = 'Sin Código';
    if (!empty($row['codigo_bienes'])) {
        $partes = explode('-', $row['codigo_bienes']);
        if (count($partes) > 1) {
            $codigo_bienes = implode('-', array_slice($partes, -3));
        } else {
            $codigo_bienes = $row['codigo_bienes'];
        }
    }

    // Estado con badge
    $estado = $row['estado'] ?? 'N/T';
    $row['estado'] = '<span class="badge '.($estado=='Activo'?'bg-verde text-white':'bg-secondary text-white').' rounded">'.$estado.'</span>';

    // Código de bienes
    $row['codigo_bienes'] = $codigo_bienes;

    // Acciones según rol
    $acciones = '';
    if ($_SESSION['rol'] == 1) {
        $acciones = '
           <button type="button" class="btn btn-infor btn-sm btn-ver" 
                    title="Ver Registro" 
                    data-id="'.$row["id"].'">
                <i class="fa fa-eye"></i>
            </button>

            <a href="../includes/_equipos/editar_equipo.php?id='.$row['id'].'" class="btn btn-edit btn-sm" title="Editar Registro">
                <i class="fa fa-edit "></i>
            </a>
            
            <a href="../includes/_equipos/eliminar_equipo.php?id='.$row['id'].'" 
            data-nombre="'. $row['tipo_equipo'].'" 
            data-apellido="'.$row['nombre_unidad'].'" 
            class="btn btn-delete btn-del btn-sm" title="Eliminar Registro">
                <i class="fa fa-trash "></i>
             </a>
        ';

    }
    $row['acciones'] = $acciones;

    $data[] = $row;
}

$output['data'] = $data;
echo json_encode($output);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'Error en la codificación JSON: ' . json_last_error_msg();
}
