<?php
require '../db.php'; // conexión MySQLi

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $equipo_id   = $_POST['equipo_id'];
    $usuario_id  = $_POST['usuario_id'];
    $tipo_evento = $_POST['tipo_evento'];
    $notas       = $_POST['notas'];

    // 1️⃣ Insertar en historial_cambios
    $stmt = $conexion->prepare("INSERT INTO historial_cambios (equipo_id, usuario_id, fecha, tipo_evento, modo, notas) VALUES (?, ?, NOW(), ?, 'manual', ?)");
    $stmt->bind_param("iiss", $equipo_id, $usuario_id, $tipo_evento, $notas);

    if($stmt->execute()){
        $historial_id = $stmt->insert_id;

        // 2️⃣ Insertar en historial_detalle
        $campo_modificado = 'tipo_evento';
        $valor_anterior = ''; // opcional: puedes traer el valor previo del equipo si quieres
        $valor_nuevo = $tipo_evento;

        $stmt2 = $conexion->prepare("INSERT INTO historial_detalle (historial_id, campo_modificado, valor_anterior, valor_nuevo) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("isss", $historial_id, $campo_modificado, $valor_anterior, $valor_nuevo);
        $stmt2->execute();

        echo json_encode(['success' => true, 'mensaje' => 'Cambio manual registrado correctamente']);
    } else {
        echo json_encode(['success' => false, 'mensaje' => 'Error al guardar el cambio']);
    }

}
