<?php
session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion == '') {
    header("Location: ../_sesion/login.php");
}

?>

<style>
    .custom-badge {
        font-size: 16px;
    }
</style>



<!-- Contenido del modal para ver la cita -->
<div class="modal fade" id="verPuntoRedModal<?php echo $fila['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="verPuntoRedModalLabel<?php echo $fila['id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bold mayus" id="verPuntoRedModalLabel<?php echo $fila['id']; ?>">Detalles de Equipos</h5>
                <button type="button" class="btn btn-light" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i>
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
                                    <h3 class="card-title font-dark bold mayus ">Detalles De Punto de Red</h3>
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
                                        <p><strong class="bold mayus">Descripción:</strong></p>
                                    </div>
                                    <div class="col-6">
                                        <p><?php echo $fila['descripcion'] ?: 'N/T'; ?></p>
                                    </div>
                                </div>

                                <hr>


                                <div class="row">
                                    <div class="col 3">
                                        <p><strong class="bold mayus">Patch Panel:</strong></p>
                                    </div>
                                    <div class="col-3">
                                        <p><?php echo $fila['patch_panel'] ?: 'N/T'; ?></p>
                                    </div>
                                    <div class="col 3">
                                        <p><strong class="bold mayus">Puerto PP:</strong></p>
                                    </div>
                                    <div class="col-3">
                                        <p><?php echo $fila['puerto_pp'] ?: 'N/T'; ?></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col 3">
                                        <p><strong class="bold mayus">Switches:</strong></p>
                                    </div>
                                    <div class="col-3">
                                        <p><?php echo $fila['switches'] ?: 'N/T'; ?></p>
                                    </div>
                                    <div class="col 3">
                                        <p><strong class="bold mayus">Puerto SW:</strong></p>
                                    </div>
                                    <div class="col-3">
                                        <p><?php echo $fila['puerto_sw'] ?: 'N/T'; ?></p>
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
                                                    Fecha de registro: <?php echo $fila['fecha_registro']; ?>
                                                </p>
                                                <p class="card-text font-dark bold mayus" style="font-size: 13px; line-height: 0.5;">
                                                    Encargado de registro: <?php echo $nombreEncargado . ' ' . $apellidoEncargado; ?>
                                                </p>
                                            </div>


                                            <div class="col-6">
                                                <?php if ($idModificacion !== 0 && !empty($fila['fecha_ultima_modificacion']) && !empty($nombreEncargadoModificacion) && !empty($apellidoEncargadoModificacion)) : ?>
                                                    <p class="card-text font-dark bold mayus" style="font-size: 13px; line-height: 0.5;">
                                                        Ultima Modificación: <?php echo $fila['fecha_ultima_modificacion']; ?>
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