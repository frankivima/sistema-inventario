<?php
session_start();
include "../db.php";

// Respuesta por defecto
$response = ['success' => false, 'message' => 'Error desconocido'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanear datos recibidos
    $unidad_id = intval($_POST['unidad_id'] ?? 0);
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre'] ?? ''));
    $apellido = mysqli_real_escape_string($conexion, trim($_POST['apellido'] ?? ''));
    $cargo = mysqli_real_escape_string($conexion, trim($_POST['cargo'] ?? ''));

    // Validar campos requeridos
    if ($unidad_id > 0 && $nombre && $apellido) {
        $query = "INSERT INTO usuarios_responsables (unidad_id, nombre, apellido, cargo) 
                  VALUES ($unidad_id, '$nombre', '$apellido', '$cargo')";

        if (mysqli_query($conexion, $query)) {
            $response['success'] = true;
            $response['message'] = 'Usuario agregado correctamente';
        } else {
            $response['message'] = 'Error al insertar en la base de datos: ' . mysqli_error($conexion);
        }
    } else {
        $response['message'] = 'Faltan datos obligatorios';
    }
} else {
    $response['message'] = 'Método no permitido';
}

// Retornar JSON
header('Content-Type: application/json');
echo json_encode($response);
