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

<div class="modal fade" id="insert_equipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title mayus bold" id="exampleModalLabel">Agregar Equipo</h3>
                <button type="button" class="btn btn-light" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>

            <div class="modal-body">

                <form id="form-equipo" action="../includes/functions.php" method="POST">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-row mb-0 mt-2">

                                <div class="form-group col">
                                    <label for="unidad_id" class="label-span mayus">Unidad de Trabajo: </label>
                                    <select class="form-select" id="unidad_id" name="unidad_id" required>
                                        <option value="">--Selecciona la Unidad--</option>
                                        <?php
                                        include("../db.php");
                                        $sql = "SELECT * FROM unidades ORDER BY nombre_unidad ASC";
                                        $resultado = mysqli_query($conexion, $sql);
                                        while ($consulta = mysqli_fetch_array($resultado)) {
                                            echo '<option value="' . $consulta['id'] . '">' . $consulta['nombre_unidad'] . '</option>';
                                        }
                                        ?>
                                    </select>

                                </div>

                                <div class="form-group col">
                                    <label for="usuario_responsable" class="label-span mayus">Usuario Responsable:</label>
                                    <input type="text" id="usuario_responsable" name="usuario_responsable" class="form-control" required>
                                </div>

                            </div>

                            <hr>

                            <div class="form-row mb-0 mt-3">

                                <div class="form-group col">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="ubicacion" name="ubicacion"></textarea>
                                        <label for="floatingTextarea2">Ubicación Física del Equipo</label>
                                    </div>
                                </div>

                            </div>

                            <div class="form-row mb-0 mt-3">

                                <div class="form-group col">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="observaciones" name="observaciones"></textarea>
                                        <label for="floatingTextarea2">Observaciones del Equipo</label>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-row mb-0 mt-2">

                                <div class="form-group col">
                                    <label for="tipo_equipo" class="label-span mayus">Tipo de Equipo</label>
                                    <select class="form-control form-select" id="tipo_equipo" name="tipo_equipo" required onchange="mostrarCampos()">
                                        <option value="">--Selecciona el tipo de equipo--</option>
                                        <option value="CPU">CPU</option>
                                        <option value="Laptop">Laptop</option>
                                        <option value="Cargador de Laptop">Cargador de Laptop</option>
                                        <option value="Mouse">Mouse</option>
                                        <option value="Teclado">Teclado</option>
                                        <option value="Monitor">Monitor</option>
                                        <option value="UPS">UPS</option>
                                        <option value="Regulador de Voltaje">Regulador de Voltaje</option>
                                        <option value="Impresora">Impresora</option>
                                        <option value="Switch de Red">Switch de Red</option>
                                        <option value="Router">Router</option>
                                        <option value="Telefono">Telefono</option>
                                        <option value="Televisor">Televisor</option>
                                    </select>
                                </div>

                            </div>



                            <!-- Campos comunes -->
                            <div id="campos-comunes">
                                <!-- Campos comunes para todos los tipos de equipo -->

                                <div class="form-row mb-0 mt-1">
                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="marca" name="marca" style="text-transform: uppercase;">
                                            <label for="floatingInputGrid">Marca</label>
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="modelo" name="modelo" style="text-transform: uppercase;">
                                            <label for="floatingInputGrid">Modelo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-row mb-0 mt-1">

                                <div class="form-group col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="serial" name="serial">
                                        <label for="floatingInputGrid">Serial</label>
                                    </div>
                                </div>

                                <div class="form-group col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="codigo_bienes" name="codigo_bienes">
                                        <label for="floatingInputGrid">Código de Bienes</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Campos específicos -->
                            <div id="campos-especificos" style="display: none;">
                                <!-- Campos específicos para PC -->

                                <div class="form-row mb-0 mt-1">
                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="procesador" name="procesador">
                                            <label for="floatingInputGrid">Procesador</label>
                                        </div>
                                    </div>

                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="sistema_operativo" name="sistema_operativo">
                                            <label for="floatingInputGrid">Sistema Operativo</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mb-0 mt-1">

                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <select class="form-select" id="tipo_ram" name="tipo_ram">
                                                <option selected>Selecciona una Opcion</option>
                                                <option value="DDR">DDR</option>
                                                <option value="DDR2">DDR2</option>
                                                <option value="DDR3">DDR3</option>
                                                <option value="DDR4">DDR4</option>
                                                <option value="DDR5">DDR5</option>
                                            </select>
                                            <label for="floatingSelectGrid">Tipo de Memoria RAM</label>
                                        </div>
                                    </div>

                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="cant_memoria" name="cant_memoria">
                                            <label for="floatingInputGrid">Cantidad de Memoria Ram</label>
                                        </div>
                                    </div>

                                </div>


                                <div class="form-row mb-0 mt-1">

                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <select class="form-select" id="tipo_disco" name="tipo_disco">
                                                <option selected>Selecciona una Opcion</option>
                                                <option value="HDD / SATA">HDD / SATA</option>
                                                <option value="SSD">SSD</option>
                                                <option value="PATA / IDE">PATA / IDE</option>
                                            </select>
                                            <label for="floatingSelectGrid">Tipo de Disco Duro</label>
                                        </div>
                                    </div>

                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="almacenamiento" name="almacenamiento">
                                            <label for="floatingInputGrid">Cantidad de Almacenamiento</label>
                                        </div>
                                    </div>

                                </div>

                            </div>


                        </div>
                    </div>

                    <?php
                    date_default_timezone_set('America/Caracas');
                    ?>
                    <input type="hidden" id="fecha_registro" name="fecha_registro" value="<?php echo date('Y-m-d H:i:s'); ?>">
                    <input type="hidden" id="encargado_registro" name="encargado_registro" value="<?php echo $idUsuario; ?>">


                    <input type="hidden" name="estado" value="Activo">
                    <input type="hidden" name="accion" value="insert_equipo">

                    <div class="modal-footer d-flex justify-content-center">

                        <button type="button" onclick="validarFormulario()" id="register" name="registrar" class="btn btn-agg mayus mr-2">Agregar Equipo</button>

                        <a href="equipos.php" class="btn btn-delete mayus ml-2">Cancelar</a>


                    </div>


                    <script>
                        function mostrarCampos() {
                            var tipoEquipo = document.getElementById("tipo_equipo").value;

                            // Ocultar todos los campos específicos
                            document.getElementById("campos-especificos").style.display = "none";

                            // Mostrar campos específicos según el tipo de equipo seleccionado
                            if (tipoEquipo === "CPU" || tipoEquipo === "Laptop") {
                                document.getElementById("campos-especificos").style.display = "block";
                            }
                        }
                    </script>

                    <script>
                        function validarFormulario() {
                            var departamento = document.getElementById("departamento").value;
                            var usuarioResponsable = document.getElementById("usuario_responsable").value;
                            var tipoEquipo = document.getElementById("tipo_equipo").value;

                            // Verificar si alguno de los campos está vacío
                            if (departamento.trim() === '') {
                                // Mostrar mensaje de error para el campo Departamento
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'El campo Departamento es obligatorio. Por favor, complételo.'
                                });
                            } else if (usuarioResponsable.trim() === '') {
                                // Mostrar mensaje de error para el campo Usuario Responsable
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'El campo Usuario Responsable es obligatorio. Por favor, complételo.'
                                });
                            } else if (tipoEquipo.trim() === '') {
                                // Mostrar mensaje de error para el campo Tipo de Equipo
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Debe seleccionar un Tipo de Equipo. Por favor, seleccione uno.'
                                });
                            } else {
                                // Si todos los campos están completos, enviar el formulario
                                document.getElementById("form-equipo").submit();
                            }
                        }
                    </script>


                </form>


            </div>
        </div>

    </div>
</div>

</div>
</div>