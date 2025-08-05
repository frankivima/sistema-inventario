<?php
include("../db.php");

if (isset($_POST['switches'])) {
    $switchSeleccionado = $_POST['switches'];
    $query_sw_assigned = "SELECT DISTINCT puerto_sw FROM puntos_red WHERE switches = $switchSeleccionado";
    $result_sw_assigned = mysqli_query($conexion, $query_sw_assigned);

    // Recopilar los puertos asignados en un array
    $sw_assigned = array();
    while ($row_sw_assigned = mysqli_fetch_assoc($result_sw_assigned)) {
        $sw_assigned[] = $row_sw_assigned['puerto_sw'];
    }

    // Construir las opciones para los puertos de switches disponibles
    $output = '<option value="" selected> Selecciona un Puerto Disponible</option>';
    for ($i = 1; $i <= 24; $i++) {
        // Si el puerto no está asignado, agregarlo como opción
        if (!in_array($i, $sw_assigned)) {
            $output .= '<option value="' . $i . '">' . $i . '</option>';
        }
    }

    echo $output;
}
?>
