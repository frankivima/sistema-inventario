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

// Realizar la consulta para obtener el nombre y apellido del encargado de modificación
$idEncargadoModificacion = $fila['encargado_modificacion'];
$consultaEncargadoModificacion = "SELECT nombre, apellido FROM usuarios WHERE id = $idEncargadoModificacion";
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
<div class="modal fade" id="verEquipoModal<?php echo $fila['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="verEquipoModalLabel<?php echo $fila['id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bold mayus" id="verEquipoModalLabel<?php echo $fila['id']; ?>">Detalles de Equipos</h5>
                <button type="button" class="btn btn-light" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body" style="line-height: 1.0;">
                <div class="row">
                    <div class="card mb-1 px-5">

                        <div class="row g-0">
                            <div class="col-lg-4 col-md-2 col-sm-0 mt-3">
                                <img src="../assets/img/logo1.png" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-lg-8 col-md-10 col-sm-12 text-left">
                                <div class="card-body">
                                    <h3 class="card-title font-dark bold mayus ">Detalles De Equipo Tecnológico</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="m-0">

                    <div class="container mt-4">

                        <div class="row g-0 mx-5">
                            <div class="col-md-12 text-justify font-dark">

                                <div class="row">
                                    <div class="col-6">
                                        <p><strong class="bold mayus">Nombre del Departamento:</strong></p>
                                    </div>
                                    <div class="col-6">
                                        <p><?php echo $fila['departamento'] ?: 'N/T'; ?></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col 6">
                                        <p><strong class="bold mayus">Usuario Responsable:</strong></p>
                                    </div>
                                    <div class="col-6">
                                        <p><?php echo $fila['usuario_responsable'] ?: 'N/T'; ?></p>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col 6">
                                        <p><strong class="bold mayus">Tipo Equipo:</strong></p>
                                    </div>
                                    <div class="col-6">
                                        <p><?php echo $fila['tipo_equipo'] ?: 'N/T'; ?></p>
                                    </div>
                                </div>

                                <div id="campos-comuness">
                                    <div class="row">
                                        <div class="col 6">
                                            <p><strong class="bold mayus">Marca:</strong></p>
                                        </div>
                                        <div class="col-6">
                                            <p class="mayus"><?php echo $fila['marca'] ?: 'N/T'; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col 6">
                                            <p><strong class="bold mayus">Modelo:</strong></p>
                                        </div>
                                        <div class="col-6">
                                            <p class="mayus"><?php echo $fila['modelo'] ?: 'N/T'; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col 6">
                                            <p><strong class="bold mayus">Serial:</strong></p>
                                        </div>
                                        <div class="col-6">
                                            <p class="mayus"><?php echo $fila['serial'] ?: 'N/T'; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col 6">
                                            <p><strong class="bold mayus">Código de Bienes:</strong></p>
                                        </div>
                                        <div class="col-6">
                                            <p class="mayus"><?php echo $fila['codigo_bienes'] ?: 'N/T'; ?></p>
                                        </div>
                                    </div>
                                </div>


                                <div id="campos-especificoss" <?php if ($fila['tipo_equipo'] != 'Laptop' && $fila['tipo_equipo'] != 'CPU') echo 'style="display: none;"'; ?>>

                                    <hr>

                                    <div class="row">
                                        <div class="col 6">
                                            <p><strong class="bold mayus">Procesador:</strong></p>
                                        </div>
                                        <div class="col-6">
                                            <p><?php echo $fila['procesador'] ?: 'N/T'; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col 6">
                                            <p><strong class="bold mayus">Sistema Operativo:</strong></p>
                                        </div>
                                        <div class="col-6">
                                            <p><?php echo $fila['sistema_operativo'] ?: 'N/T'; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col 6">
                                            <p><strong class="bold mayus">Memoria RAM:</strong></p>
                                        </div>
                                        <div class="col-6">
                                            <p><?php echo $fila['cant_memoria'] ?: 'N/T'; ?> GB <?php echo $fila['tipo_ram'] ?: 'N/T'; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col 6">
                                            <p><strong class="bold mayus">Almacenamiento (Disco):</strong></p>
                                        </div>
                                        <div class="col-6">
                                            <p><?php echo $fila['almacenamiento'] ?: 'N/T'; ?> GB. <?php echo $fila['tipo_disco'] ?: 'N/T'; ?></p>
                                        </div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col 6">
                                        <p><strong class="bold mayus">Ubicación:</strong></p>
                                    </div>
                                    <div class="col-6">
                                        <p><?php echo $fila['ubicacion'] ?: 'N/T'; ?></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col 6">
                                        <p><strong class="bold mayus">Observaciones:</strong></p>
                                    </div>
                                    <div class="col-6">
                                        <p><?php echo $fila['observaciones'] ?: 'N/T'; ?></p>
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

                        <hr>
                        <br>

                        <div class="card mb-3 mx-3">
                            <div class="row g-0">
                                <div class="col-md-12 text-left font-dark">
                                    <div class="card-body">

                                        <div class="row">

                                            <div class="col-6">
                                                <p class="card-text font-dark bold mayus" style="font-size: 13px; line-height: 0.5;">
                                                    Fecha de registro: <?php echo date('d-m-Y h:i A', strtotime($fila['fecha_registro'])); ?>
                                                </p>
                                                <p class="card-text font-dark bold mayus" style="font-size: 13px; line-height: 0.5;">
                                                    Encargado de registro: <?php echo $nombreEncargado . ' ' . $apellidoEncargado; ?>
                                                </p>
                                            </div>


                                            <div class="col-6">
                                                <?php if ($idModificacion !== 0 && !empty($fila['fecha_ultima_modificacion']) && !empty($nombreEncargadoModificacion) && !empty($apellidoEncargadoModificacion)) : ?>
                                                    <p class="card-text font-dark bold mayus" style="font-size: 13px; line-height: 0.5;">
                                                        Ultima Modificación: <?php echo date('d-m-Y h:i A', strtotime($fila['fecha_ultima_modificacion'])); ?>
                                                    </p>
                                                    <p class="card-text font-dark bold mayus" style="font-size: 13px; line-height: 0.5;">
                                                        Encargado de modificación: <?php echo $nombreEncargadoModificacion . ' ' . $apellidoEncargadoModificacion; ?>
                                                    </p>
                                                <?php else : ?>
                                                    <p class="card-text font-dark bold mayus" style="font-size: 13px;">
                                                        No ha sido modificado.
                                                    </p>
                                                <?php endif; ?>
                                            </div>

                                        </div>

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