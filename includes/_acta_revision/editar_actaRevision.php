<?php


session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion == '') {
    header("Location: ../includes/_sesion/login.php");
}

$id = $_GET['id_acta'];
include "../db.php";
$consulta = "SELECT * FROM acta_revision WHERE id_acta = $id";
$resultado = mysqli_query($conexion, $consulta);
$usuario = mysqli_fetch_assoc($resultado);


// Asegúrate de que los datos del usuario estén disponibles en la sesión
if (isset($_SESSION['user_id'])) {
    $idUsuario = $_SESSION['user_id'];
} else {
    // Si no están disponibles, puedes mostrar el nombre de usuario
    $nombreUsuario = $_SESSION['username'];
}

date_default_timezone_set('America/Caracas');
?>

<?php include_once "header.php"; ?>

<style>
    .vertical-line {
        border-left: 1px solid #000;
        height: 100%;
        position: absolute;
    }

    .prefix-input-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .prefix {
        position: absolute;
        left: 10px;
        color: red;
        font-weight: bold;
    }

    .input-with-prefix {
        padding-left: 120px;
        /* Adjust according to the prefix length */
    }
</style>

<body>

    <!-- Begin Page Content -->
    <div class="container">

        <!-- DataTales Example -->
        <div class="card shadow my-5">

            <div class="card-header py-3">
                <div class="row">
                    <h4 class="m-0 font-primary mayus bold col-8">Modificar acta de revisión de equipos</h4>
                    <div class="col-4 text-right">
                    </div>
                </div>
            </div>

            <div class="card-body">

                <form action="../functions.php" id="form" method="POST">

                    <div class="row">

                        <div class="col-12">

                            <div class="form-row mb-0 mt-0">
                                <div class="col-lg-6 col-md-6 col-sm-4 mt-0">
                                    <img src="../../assets/img/logo1.png" class="img-fluid rounded-start" alt="...">
                                </div>

                                <div class="col-md-1 col-sm-1 d-flex justify-content-center align-items-center">
                                    <hr class="vertical-line">
                                </div>

                                <div class="form-group col-2 col-md-2 col-sm-3">
                                    <label for="id_acta" class="label-span">Nº de Acta:</label>
                                    <div class="input-group">
                                        <input type="number" id="id_acta" name="id_acta" class="form-control text-center" value="<?php echo $usuario['id_acta']; ?>" required readonly>
                                    </div>
                                </div>


                                <div class="form-group col-3 col-md-3 col-sm-4">
                                    <label for="fecha_revision" class="label-span">Fecha de Revisión:</label>
                                    <input type="date" id="fecha_revision" name="fecha_revision" class="form-control text-center" value="<?php echo $usuario['fecha_revision']; ?>" required>
                                </div>
                            </div>

                            <hr class="mb-0 mt-0">

                            <div class="form-row mb-0 mt-0">

                                <div class="form-group col mt-3">
                                    <label for="descripcion_equipo" class="label-span">Descripción del Equipo:</label>
                                    <input type="text" id="descripcion_equipo" name="descripcion_equipo" class="form-control" value="<?php echo $usuario['descripcion_equipo']; ?>" required>
                                </div>

                                <div class="col-md-1 d-flex justify-content-center align-items-center">
                                    <hr class="vertical-line">
                                </div>

                                <div class="form-group col mt-3">
                                    <label for="unidad_trabajo" class="label-span">Unidad de Trabajo:</label>
                                    <input type="text" id="unidad_trabajo" name="unidad_trabajo" class="form-control" value="<?php echo $usuario['unidad_trabajo']; ?>" required>
                                </div>


                            </div>

                            <div class="form-row mb-0 mt-0">

                                <div class="form-group col">
                                    <label for="serial" class="label-span">Serial:</label>
                                    <input type="text" id="serial" name="serial" class="form-control" value="<?php echo $usuario['serial']; ?>" required>
                                </div>

                                <div class="col-md-1 d-flex justify-content-center align-items-center">
                                    <hr class="vertical-line">
                                </div>

                                <div class="form-group col">
                                    <label for="responsable_uso" class="label-span">Responsable(s) de uso:</label>
                                    <input type="text" id="responsable_uso" name="responsable_uso" class="form-control" value="<?php echo $usuario['responsable_uso']; ?>">
                                </div>

                            </div>

                            <div class="form-row mb-0 mt-0">

                                <div class="form-group col">
                                    <label for="codigo_bienes_visible" class="label-span">Código de Bien:</label>
                                    <div class="prefix-input-container">
                                        <span class="prefix">3-1800-1-37-2-</span>
                                        <input type="text" id="codigo_bienes_visible" class="form-control ms-2 input-with-prefix" value="<?php echo $usuario['codigo_bienes']; ?>" oninput="syncInput()">
                                        <input type="hidden" id="codigo_bienes" name="codigo_bienes">
                                    </div>
                                </div>

                                <script>
                                    function syncInput() {
                                        const prefix = '3-1800-1-37-2-';
                                        const visibleInput = document.getElementById('codigo_bienes_visible');
                                        const hiddenInput = document.getElementById('codigo_bienes');
                                        hiddenInput.value = visibleInput.value;
                                    }

                                    document.addEventListener('DOMContentLoaded', function() {
                                        syncInput(); // Initialize hidden input value
                                    });
                                </script>

                                <div class="col-md-1 d-flex justify-content-center align-items-center">
                                    <hr class="vertical-line">
                                </div>

                                <div class="form-group col">

                                </div>

                            </div>

                            <hr class="mb-0 mt-0">

                            <div class="form-row mb-0 mt-4">
                                <div class="form-group col">
                                    <label class="label-span me-5">Estado:</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="estado_bueno" name="estado_equipo" value="BUENO" <?php echo ($usuario['estado_equipo'] == 'BUENO') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="estado_bueno">Bueno</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="estado_regular" name="estado_equipo" value="REGULAR" <?php echo ($usuario['estado_equipo'] == 'REGULAR') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="estado_regular">Regular</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="estado_deteriorado" name="estado_equipo" value="DETERIORADO" <?php echo ($usuario['estado_equipo'] == 'DETERIORADO') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="estado_deteriorado">Deteriorado</label>
                                    </div>
                                </div>

                                <div class="form-group col">
                                    <label class="label-span me-5">Operatividad:</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="operatividad_enciende" name="operatividad" value="ENCIENDE" <?php echo ($usuario['operatividad'] == 'ENCIENDE') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="operatividad_enciende">Enciende</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="operatividad_no_enciende" name="operatividad" value="NO ENCIENDE" <?php echo ($usuario['operatividad'] == 'NO ENCIENDE') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="operatividad_no_enciende">No Enciende</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="operatividad_otros" name="operatividad" value="OTRO" <?php echo ($usuario['operatividad'] == 'OTRO') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="operatividad_otros">Otros</label>
                                    </div>
                                </div>
                            </div>


                            <hr class="mb-0 mt-0">

                            <div class="form-row mb-0 mt-2">
                                <div class="form-group col">
                                    <label for="accesorios_perifericos" class="label-span">Accesorios y/o Perifericos:</label>
                                    <textarea type="text" name="accesorios_perifericos" id="accesorios_perifericos" class="form-control" rows="3"><?php echo $usuario['accesorios_perifericos']; ?></textarea>
                                </div>
                            </div>

                            <div class="form-row mb-0 mt-2">
                                <div class="form-group col">
                                    <label for="resultado_revision" class="label-span">Resultados de la Revisión:</label>
                                    <textarea type="text" name="resultado_revision" id="resultado_revision" class="form-control" rows="8"><?php echo $usuario['resultado_revision']; ?></textarea>
                                </div>
                            </div>

                            <div class="form-row mb-0 mt-2">
                                <div class="form-group col">
                                    <label for="conclusion_revision" class="label-span">Conclusiones y/o Recomendaciones:</label>
                                    <textarea type="text" name="conclusion_revision" id="conclusion_revision" class="form-control" rows="5"><?php echo $usuario['conclusion_revision']; ?></textarea>
                                </div>
                            </div>

                            <hr class="mb-0 mt-0">

                            <div class="form-row mb-0 mt-3">

                                <div class="form-group col">
                                    <label for="user_elaboracion" class="label-span">Elaborado por:</label>
                                    <input type="text" id="user_elaboracion" name="user_elaboracion" class="form-control" value="<?php echo $usuario['user_elaboracion']; ?>" required>
                                </div>

                                <div class="form-group col">
                                    <label for="user_revision" class="label-span">Revisado por:</label>
                                    <input type="text" id="user_revision" name="user_revision" class="form-control" value="<?php echo $usuario['user_revision']; ?>" required>
                                </div>

                            </div>


                        </div>

                        <input type="hidden" name="accion" value="editar_actaRevision">
                        <input type="hidden" name="id_acta" value="<?php echo $usuario['id_acta']; ?>">


                        <div class="card-footer">

                            <div class="my-2 d-flex justify-content-center">
                                <button type="submit" id="form" name="form" class="btn btn-agg mr-2 mayus bold">
                                    <i class="fa-regular fa-floppy-disk"></i> Guardar Cambios</button>

                                <a href="../../views/acta_revision.php" class="btn btn-delete ml-2 mayus bold">
                                    <i class="fa-solid fa-x"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>


    </form>

    <?php include_once "footer.php"; ?>

</body>

</html>