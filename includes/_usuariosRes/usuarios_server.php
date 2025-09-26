<?php
include "../db.php";

$unidad_id = intval($_GET['unidad_id']);

// Obtener usuarios
$result = mysqli_query($conexion, "SELECT * FROM usuarios_responsables WHERE unidad_id = $unidad_id");

if (mysqli_num_rows($result) > 0) {
    echo '<div class="list-group">';
    while ($user = mysqli_fetch_assoc($result)) {
        echo '<div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center shadow-sm mb-2 rounded" data-user-id="' . $user['id'] . '" data-unidad-id="' . $user['unidad_id'] . '">
                <div>
                    <strong>' . htmlspecialchars($user['nombre'] . ' ' . $user['apellido']) . '</strong><br>
                    <small class="text-muted">' . htmlspecialchars($user['cargo']) . '</small>
                </div>
                <div class="btn-group">
                    <button class="btn btn-sm btn-outline-primary"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                </div>
              </div>';
    }
    echo '</div>';
} else {
    echo '<p class="text-center text-muted mt-3">No hay usuarios registrados para esta unidad.</p>';
}
?>
