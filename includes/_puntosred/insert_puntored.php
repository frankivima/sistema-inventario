<?php
session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion == '') {
    header("Location: _sesion/login.php");
    exit(); // Añadido para evitar la ejecución adicional del código
}

// Asegúrate de que los datos del usuario estén disponibles en la sesión
if (isset($_SESSION['nombre']) && isset($_SESSION['apellido'])) {
    $nombreUsuario = $_SESSION['nombre'];
    $apellidoUsuario = $_SESSION['apellido'];
} else {
    // Si no están disponibles, puedes mostrar el nombre de usuario
    $nombreUsuario = $_SESSION['username'];
    $apellidoUsuario = ''; // Debes adaptar esto según la estructura de tu sesión
}

?>

<div class="modal fade" id="insert_puntored" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title mayus bold" id="exampleModalLabel">Asignar Punto de Red</h3>
                <button type="button" class="btn btn-black" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>

            <div class="modal-body">

                <form id="form-equipo" action="../includes/functions.php" method="POST">



                    <div class="form-row mb-0 mt-2">

                        <div class="form-group col">
                            <label for="departamento" class="label-span mayus">Departamento: </label>
                            <select class="form-select" id="departamento" name="departamento" required>
                                <option value="">--Selecciona un departamento--</option>
                                <?php
                                include("../db.php");
                                $sql = "SELECT * FROM departamentos ORDER BY nombre_departamento ASC";
                                $resultado = mysqli_query($conexion, $sql);
                                while ($consulta = mysqli_fetch_array($resultado)) {
                                    echo '<option value="' . $consulta['nombre_departamento'] . '">' . $consulta['nombre_departamento'] . '</option>';
                                }
                                ?>

                            </select>

                        </div>
                    </div>

                    <div class="form-row mb-0 mt-2">

                        <div class="form-group col">
                            <label for="descripcion" class="label-span mayus">Descripción:</label>
                            <input type="text" id="descripcion" name="descripcion" class="form-control" required>
                        </div>

                    </div>


                    <div class="form-row mb-0 mt-2">
                        <div class="form-group col">
                            <label for="patch_panel" class="label-span mayus">Patch Panel</label>
                            <select class="form-control form-select" id="patch_panel" name="patch_panel">
                                <option value="">--Selecciona el Patch Panel--</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="form-group col">
                            <label for="puerto_pp" class="label-span mayus">Puerto PP</label>
                            <!-- Aquí se generan dinámicamente las opciones de puerto PP -->
                            <select class="form-select" name="puerto_pp" id="puerto_pp">
                                <option value="" selected> Selecciona un Puerto Disponible</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row mb-0 mt-2">
                        <div class="form-group col">
                            <label for="switches" class="label-span mayus">Switches</label>
                            <select class="form-control form-select" id="switches" name="switches">
                                <option value="">--Selecciona el Switch--</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>

                        <div class="form-group col">
                            <label for="puerto_sw" class="label-span mayus">Puerto SW</label>
                            <select class='form-select' name='puerto_sw' id='puerto_sw'>
                                <option value='' selected> Selecciona un Puerto Disponible</option>
                                <!-- Opciones de puertos SW -->
                            </select>
                        </div>
                    </div>

                    <hr>

                    <div class="form-row mb-0 mt-2">
                        <div class="form-group col">
                            <label for="estado" class="form-label label-span left mayus">Estado:</label>
                            <select name="estado" id="estado" class="form-select" required>
                                <option value="">--Selecciona una opción--</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>



            </div>


            <?php
            date_default_timezone_set('America/Caracas');
            ?>
            <input type="hidden" id="fecha_registro" name="fecha_registro" value="<?php echo date('Y-m-d H:i:s'); ?>">
            <input type="hidden" id="encargado_registro" name="encargado_registro" value="<?php echo $nombreUsuario . ' ' . $apellidoUsuario; ?>">

            <input type="hidden" name="accion" value="insert_puntored">

            <div class="modal-footer d-flex justify-content-center">

                <button type="submit" id="register" name="registrar" class="btn btn-agg mayus mr-2">Agregar Punto de Red</button>

                <a href="puntos_red.php" class="btn btn-delete mayus ml-2">Cancelar</a>


            </div>

            </form>

            <script>
                $(document).ready(function() {
                    // Cambio en la selección del patch panel
                    $('#patch_panel').change(function() {
                        var patchPanelSeleccionado = $(this).val();
                        console.log('Patch panel seleccionado:', patchPanelSeleccionado); // Mensaje de depuración
                        $.ajax({
                            type: 'POST',
                            url: '../includes/_puntosred/obtener_puertos_pp.php', // Ruta al archivo PHP que obtiene los puertos PP
                            data: {
                                patch_panel: patchPanelSeleccionado
                            },
                            success: function(response) {
                                console.log('Respuesta del servidor:', response); // Mensaje de depuración
                                $('#puerto_pp').html(response);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX:', error); // Mensaje de depuración
                            }
                        });
                    });

                    // Cambio en la selección del switch
                    $('#switches').change(function() {
                        var switchSeleccionado = $(this).val();
                        console.log('Switch seleccionado:', switchSeleccionado); // Mensaje de depuración
                        $.ajax({
                            type: 'POST',
                            url: '../includes/_puntosred/obtener_puertos_sw.php', // Ruta al archivo PHP que obtiene los puertos SW
                            data: {
                                switches: switchSeleccionado
                            },
                            success: function(response) {
                                console.log('Respuesta del servidor:', response); // Mensaje de depuración
                                $('#puerto_sw').html(response);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX:', error); // Mensaje de depuración
                            }
                        });
                    });
                });
            </script>





        </div>
    </div>

</div>
</div>

</div>
</div>