<?php
include("../db.php");

if(isset($_POST['departamento'])) {
    $departamento = $_POST['departamento'];
    $options = '<option value="">--Selecciona un equipo--</option>';
    
    // Modificar la consulta para seleccionar solo los equipos con el tipo de equipo especificado
    $sql = "SELECT * FROM equipos WHERE departamento = '$departamento' AND tipo_equipo IN ('Laptop', 'CPU', 'Impresora', 'Switches', 'Router')";
    $resultado = mysqli_query($conexion, $sql);
    
    while ($consulta = mysqli_fetch_array($resultado)) {
        $options .= '<option value="' . $consulta['id'] . '">' . $consulta['tipo_equipo'] . ' - ' . $consulta['usuario_responsable'] . '</option>';

    }
    
    echo $options;
}
?>
