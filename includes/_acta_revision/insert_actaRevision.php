<?php
session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion == '') {
    header("Location: _sesion/login.php");
    exit(); // Añadido para evitar la ejecución adicional del código
}

// Asegúrate de que los datos del usuario estén disponibles en la sesión
if (isset($_SESSION['user_id'])) {
    $idUsuario = $_SESSION['user_id'];
} else {
    // Si no están disponibles, puedes mostrar el nombre de usuario
    $nombreUsuario = $_SESSION['username'];
}

?>

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

<div class="modal fade" id="insert_actaRevision" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title mayus bold" id="exampleModalLabel">Acta Revisión de Equipos</h3>
                <button type="button" class="btn btn-light" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>

            <div class="modal-body mayus">

                <form action="../includes/functions.php" method="POST">

                    <div class="form-row mb-0 mt-0">
                        <div class="col-lg-6 col-md-4 col-sm-4 mt-0">
                            <img src="../assets/img/logo1.png" class="img-fluid rounded-start" alt="...">
                        </div>

                        <div class="col-lg-1 col-md-1 col-sm-1 d-flex justify-content-center align-items-center">
                            <hr class="vertical-line">
                        </div>

                        <div class="form-group col-lg-2 col-md-3 col-sm-3">
                            <label for="id_acta" class="label-span">Nº de Acta:</label>
                            <div class="input-group">
                                <input type="number" id="id_acta" name="id_acta" class="form-control text-center" required readonly>
                                <button type="button" class="btn btn-edit" onclick="obtenerProximoIdActa()"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </div>

                        <script>
                            // JavaScript con AJAX
                            function obtenerProximoIdActa() {
                                // Realizar la petición AJAX
                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        // Cuando se recibe la respuesta
                                        var maxId = parseInt(this.responseText);
                                        var proximoId = (isNaN(maxId) || maxId === 0) ? 1 : maxId + 1;
                                        document.getElementById("id_acta").value = proximoId;
                                    }
                                };
                                xhttp.open("GET", "../includes/_acta_revision/obtener_idActa.php", true);
                                xhttp.send();
                            }
                        </script>

                        <div class="form-group col-lg-3 col-md-4 col-sm-4">
                            <label for="fecha_revision" class="label-span">Fecha de Revisión:</label>
                            <input type="date" id="fecha_revision" name="fecha_revision" class="form-control text-center" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <hr class="mb-0 mt-0">

                    <div class="form-row mb-0 mt-0">

                        <div class="form-group col mt-3">
                            <label for="descripcion_equipo" class="label-span">Descripción del Equipo:</label>
                            <input type="text" id="descripcion_equipo" name="descripcion_equipo" class="form-control" required>
                        </div>

                        <div class="col-md-1 d-flex justify-content-center align-items-center">
                            <hr class="vertical-line">
                        </div>

                        <div class="form-group col mt-3">
                            <label for="unidad_trabajo" class="label-span">Unidad de Trabajo:</label>
                            <input type="text" id="unidad_trabajo" name="unidad_trabajo" class="form-control" required>
                        </div>


                    </div>

                    <div class="form-row mb-0 mt-0">

                        <div class="form-group col">
                            <label for="serial" class="label-span">Serial:</label>
                            <input type="text" id="serial" name="serial" class="form-control" required>
                        </div>

                        <div class="col-md-1 d-flex justify-content-center align-items-center">
                            <hr class="vertical-line">
                        </div>

                        <div class="form-group col">
                            <label for="responsable_uso" class="label-span">Responsable(s) de uso:</label>
                            <input type="text" id="responsable_uso" name="responsable_uso" class="form-control">
                        </div>

                    </div>

                    <div class="form-row mb-0 mt-0">

                        <div class="form-group col">
                            <label for="codigo_bienes_visible" class="label-span">Código de Bien:</label>
                            <div class="prefix-input-container">
                                <span class="prefix">3-1800-1-37-2-</span>
                                <input type="text" id="codigo_bienes_visible" class="form-control ms-2 input-with-prefix" oninput="syncInput()">
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
                                <input class="form-check-input" type="radio" id="estado_bueno" name="estado_equipo" value="BUENO">
                                <label class="form-check-label" for="estado_bueno">Bueno</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="estado_regular" name="estado_equipo" value="REGULAR">
                                <label class="form-check-label" for="estado_regular">Regular</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="estado_deteriorado" name="estado_equipo" value="DETERIORADO">
                                <label class="form-check-label" for="estado_deteriorado">Deteriorado</label>
                            </div>
                        </div>

                        <div class="form-group col">
                            <label class="label-span me-5">Operatividad:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="operatividad_enciende" name="operatividad" value="ENCIENDE">
                                <label class="form-check-label" for="operatividad_enciende">Enciende</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="operatividad_no_enciende" name="operatividad" value="NO ENCIENDE">
                                <label class="form-check-label" for="operatividad_no_enciende">No Enciende</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="operatividad_otros" name="operatividad" value="OTRO">
                                <label class="form-check-label" for="operatividad_otros">Otros</label>
                            </div>
                        </div>
                    </div>


                    <hr class="mb-0 mt-0">

                    <div class="form-row mb-0 mt-2">
                        <div class="form-group col">
                            <label for="accesorios_perifericos" class="label-span">Accesorios y/o Perifericos:</label>
                            <textarea type="text" name="accesorios_perifericos" id="accesorios_perifericos" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="form-row mb-0 mt-2">
                        <div class="form-group col">
                            <label for="resultado_revision" class="label-span">Resultados de la Revisión:</label>
                            <textarea type="text" name="resultado_revision" id="resultado_revision" class="form-control" rows="8"></textarea>
                        </div>
                    </div>

                    <div class="form-row mb-0 mt-2">
                        <div class="form-group col">
                            <label for="conclusion_revision" class="label-span">Conclusiones y/o Recomendaciones:</label>
                            <textarea type="text" name="conclusion_revision" id="conclusion_revision" class="form-control" rows="5"></textarea>
                        </div>
                    </div>

                    <hr class="mb-0 mt-0">

                    <div class="form-row mb-0 mt-3">

                        <div class="form-group col">
                            <label for="user_elaboracion" class="label-span">Elaborado por:</label>
                            <input type="text" id="user_elaboracion" name="user_elaboracion" class="form-control" required>
                        </div>

                        <div class="form-group col">
                            <label for="user_revision" class="label-span">Revisado por:</label>
                            <input type="text" id="user_revision" name="user_revision" class="form-control" required>
                        </div>

                    </div>



            </div>

            <input type="hidden" name="accion" value="insert_actaRevision">

            <div class="modal-footer d-flex justify-content-center">

                <button type="submit" id="register" name="registrar" class="btn btn-agg mr-2 bold mayus">Guardar Acta de Revisión</button>
                <a href="acta_revision.php" class="btn btn-delete ml-2 bold mayus">Cancelar</a>

            </div>

            </form>


        </div>
    </div>


</div>
</div>