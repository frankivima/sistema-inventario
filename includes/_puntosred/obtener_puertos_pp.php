<?php
include("../db.php");

if (isset($_POST['patch_panel'])) {
    $patchPanelSeleccionado = $_POST['patch_panel'];
    $query_pp_assigned = "SELECT DISTINCT puerto_pp FROM puntos_red WHERE patch_panel = $patchPanelSeleccionado";
    $result_pp_assigned = mysqli_query($conexion, $query_pp_assigned);

    // Recopilar los puertos asignados en un array
    $pp_assigned = array();
    while ($row_pp_assigned = mysqli_fetch_assoc($result_pp_assigned)) {
        $pp_assigned[] = $row_pp_assigned['puerto_pp'];
    }

    // Construir las opciones para los puertos disponibles
    $output = '<option value="" selected> Selecciona un Puerto Disponible</option>';
    for ($i = 1; $i <= 24; $i++) {
        // Si el puerto no está asignado, agregarlo como opción
        if (!in_array($i, $pp_assigned)) {
            $output .= '<option value="' . $i . '">' . $i . '</option>';
        }
    }

    echo $output;
}
?>
