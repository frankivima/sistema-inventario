<?php
session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion == '') {
    header("Location: ../_sesion/login.php");
}

// Realizar la consulta para obtener el nombre y apellido del encargado
$idEncargado = $fila['encargado_registro'];
$consultaEncargado = "SELECT nombre, apellido FROM usuarios WHERE id = $idEncargado";
$resultadoEncargado = mysqli_query($conexion, $consultaEncargado);

if ($resultadoEncargado) {
    $filaEncargado = mysqli_fetch_assoc($resultadoEncargado);
    $nombreEncargado = $filaEncargado['nombre'];
    $apellidoEncargado = $filaEncargado['apellido'];
} else {
    // Manejar el caso de error si la consulta no se ejecuta correctamente
    $nombreEncargado = "No disponible";
    $apellidoEncargado = "";
}

// Realizar la consulta para obtener el nombre y apellido del encargado de registro
$idModificacion = $fila['encargado_modificacion'];
$consultaEncargadoModificacion = "SELECT nombre, apellido FROM usuarios WHERE id = $idModificacion";
$resultadoEncargadoModificacion = mysqli_query($conexion, $consultaEncargadoModificacion);

if ($resultadoEncargadoModificacion) {
    $filaEncargadoModificacion = mysqli_fetch_assoc($resultadoEncargadoModificacion);
    $nombreEncargadoModificacion = $filaEncargadoModificacion['nombre'];
    $apellidoEncargadoModificacion = $filaEncargadoModificacion['apellido'];
} else {
    // Manejar el caso de error si la consulta no se ejecuta correctamente
    $nombreEncargadoModificacion = "No disponible";
    $apellidoEncargadoModificacion = "";
}

?>

<style>
    .custom-badge {
        font-size: 16px;
    }
</style>



<!-- Contenido del modal para ver la cita -->
<div class="modal fade" id="verIpFijaModal<?php echo $fila['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="verIpFijaModalLabel<?php echo $fila['id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bold mayus" id="verIpFijaModalLabel<?php echo $fila['id']; ?>">Detalles de Dirección IP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="card mb-1 px-5">
                        <div class="row g-0">
                            <div class="col-md-4 mt-3">
                                <img src="../assets/img/logo1.png" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8 text-left">
                                <div class="card-body">
                                    <h2 class="card-title font-dark bold mayus ">Detalles De Dirección IP Fija</h2>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 mx-3">
                            <div class="row g-0">
                                <div class="col-md-12 text-justify font-dark">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col 6">
                                                <p><strong class="bold mayus">Dirección IP:</strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p class="bold"><?php echo $fila['ip'] ?: 'N/T'; ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col 6">
                                                <p><strong class="bold mayus">Departamento:</strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p><?php echo $fila['departamento'] ?: 'N/T'; ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col 6">
                                                <p><strong class="bold mayus">Equipo:</strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p><?php echo $fila['tipo_equipo'] . ' - ' . $fila['marca'];
                                                    'N/T'; ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col 6">
                                                <p><strong class="bold mayus">Descripción:</strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p><?php echo $fila['descripcion'] ?: 'N/T'; ?></p>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col 6">
                                                <p><strong class="bold mayus">Estado:</strong> </p>
                                            </div>
                                            <div class="col 6">
                                                <span class="badge <?php
                                                                    $estado = strtolower($fila['estado']);
                                                                    switch ($estado) {
                                                                        case 'activo':
                                                                            echo 'bg-verde text-white';
                                                                            break;
                                                                        default:
                                                                            echo 'bg-secondary text-white';
                                                                            break;
                                                                    }
                                                                    ?> rounded custom-badge">
                                                    <?php echo $fila['estado']; ?>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 mx-3">
                            <div class="row g-0">
                                <div class="col-md-12 text-right font-dark">
                                    <div class="card-body">
                                        <p class="card-text font-dark bold mayus" style="font-size: 12px;"> <small class="bold">Fecha de registro: <?php echo $fila['fecha_registro']; ?></small></p>
                                        <p class="card-text font-dark bold mayus" style="font-size: 12px;"> <small class="bold">Encargado de registro:  <?php echo $nombreEncargado . ' ' . $apellidoEncargado; ?></small></p>

                                        <?php if ($idModificacion !== 0 && !empty($fila['fecha_modificacion']) && !empty($nombreEncargadoModificacion) && !empty($apellidoEncargadoModificacion)) : ?>
                                            <p class="card-text font-dark bold mayus" style="font-size: 12px;">
                                                <small class="bold">Última Modificación: <?php echo $fila['fecha_modificacion']; ?></small>
                                            </p>
                                            <p class="card-text font-dark bold mayus" style="font-size: 12px;">
                                                <small class="bold">Encargado de modificación: <?php echo $nombreEncargadoModificacion . ' ' . $apellidoEncargadoModificacion; ?></small>
                                            </p>
                                        <?php elseif ($idModificacion !== 0) : ?>
                                            <p class="card-text font-dark bold mayus" style="font-size: 12px;">
                                                <small class="bold">No ha sido modificado.</small>
                                            </p>
                                        <?php endif; ?>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-delete mayus" s data-dismiss="modal">Cerrar</button>
            </div>



        </div>
    </div>

</div>