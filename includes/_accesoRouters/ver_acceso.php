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
<div class="modal fade" id="verAccesoRouterModal<?php echo $fila['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="verAccesoRouterModalLabel<?php echo $fila['id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bold mayus" id="verAccesoRouterModalLabel<?php echo $fila['id']; ?>">Detalles de Acceso a Router</h5>
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
                            <div class="col-md-8 text-left my-4">
                                <div class="card-body">
                                    <h2 class="card-title font-dark bold mayus ">Acceso a router</h2>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 mx-3">
                            <div class="row g-0">
                                <div class="col-md-12 text-justify font-dark">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <p><strong class="bold mayus">Equipo Router:</strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p class="bold">
                                                    <?php echo (!empty($fila['tipo_equipo']) ? $fila['tipo_equipo'] : 'N/T') . ' - ' . (!empty($fila['marca']) ? $fila['marca'] : 'N/T'); ?>
                                                </p>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col 6">
                                                <p><strong class="bold">Dirección IP (Puerta de Enlace):</strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p class="bold"><?php echo $fila['direccion_ip'] ?: 'N/T'; ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col 6">
                                                <p><strong class="bold">Dirección WAN IP:</strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p class="bold"><?php echo $fila['wan_ip'] ?: 'N/T'; ?></p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-6 col-lg-6 col-md-12 col-sm-12">
                                                <label for="" class="label-span">Acceso a Red WIFI</label>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $fila['nombre'] ?: 'N/T'; ?>" readonly>
                                                    <label for="floatingInputGrid">Nombre Red WIFI (SSID)</label>
                                                </div>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="contraseña" name="contraseña" value="<?php echo $fila['contraseña'] ?: 'N/T'; ?>" readonly>
                                                    <label for="floatingInputGrid">Contraseña WIFI</label>
                                                </div>
                                            </div>

                                            <div class="col-6 col-lg-6 col-md-12 col-sm-12">
                                                <label for="" class="label-span">Acceso a Panel Admin</label>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="usuario_acceso" name="usuario_acceso" value="<?php echo $fila['usuario_acceso'] ?: 'N/T'; ?>" readonly>
                                                    <label for="floatingInputGrid">Usuario</label>
                                                </div>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="contraseña_acceso" name="contraseña_acceso" value="<?php echo $fila['contraseña_acceso'] ?: 'N/T'; ?>" readonly>
                                                    <label for="floatingInputGrid">Contraseña</label>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col 6">
                                                <p><strong class="bold mayus">Uso:</strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p><?php echo $fila['uso'];
                                                    'N/T'; ?></p>
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
                                        <p class="card-text font-dark bold mayus" style="font-size: 12px;"> <small class="bold">Encargado de registro: <?php echo $nombreEncargado . ' ' . $apellidoEncargado; ?></small></p>

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