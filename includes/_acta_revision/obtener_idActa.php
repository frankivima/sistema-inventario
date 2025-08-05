<?php
include "../db.php"; // Incluye tu archivo de conexión a la base de datos

// Consulta para obtener el último id_acta
$sql = "SELECT MAX(id_acta) AS ultimo_id FROM acta_revision";
$resultado = mysqli_query($conexion, $sql);

if ($resultado && mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);
    $ultimoId = $fila['ultimo_id'] ?? 0; // Si es nulo, devolver 0
    echo $ultimoId; // Devuelve el último id_acta
} else {
    echo "0"; // Si no hay resultados, devuelve 0 o un valor por defecto
}

mysqli_close($conexion);
?>
