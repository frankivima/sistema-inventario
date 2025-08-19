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


?>

<style>
    .custom-badge {
        font-size: 16px;
    }
</style>



<!-- Contenido del modal para ver la cita -->
<div class="modal fade" id="verDepartamentoModal<?php echo $fila['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="verDepartamentoModalLabel<?php echo $fila['id']; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bold mayus" id="verDepartamentoModalLabel<?php echo $fila['id']; ?>">Detalles de Departamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="card mb-1">
                        <div class="row g-0">
                            <div class="col-md-4 mt-3">
                                <img src="../assets/img/logo1.png" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8 text-justify">
                                <div class="card-body">
                                    <h2 class="card-title font-dark bold mayus ">Detalles </h2>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-12 text-left font-dark">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col 6">
                                                <p><strong class="bold mayus">Nombre del Departamento:</strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p><?php echo $fila['nombre_departamento'] ?: 'N/T'; ?></p>
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


                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-12 text-right font-dark">
                                    <div class="card-body">
                                        <p class="card-text font-dark bold mayus" style="font-size: 12px;"> <small class="bold">Fecha de registro: <?php echo $fila['fecha_registro']; ?></small></p>
                                        <p class="card-text font-dark bold mayus" style="font-size: 12px;"> <small class="bold">Encargado de registro: <?php echo $nombreEncargado . ' ' . $apellidoEncargado; ?></small></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-delete" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>