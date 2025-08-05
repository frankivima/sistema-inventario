<?php


session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion == '') {
    header("Location: ../includes/_sesion/login.php");
}

$id = $_GET['id'];
include "../db.php";
$consulta = "SELECT * FROM puntos_red WHERE id = $id";
$resultado = mysqli_query($conexion, $consulta);
$usuario = mysqli_fetch_assoc($resultado);


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

<?php include_once "header.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>
</head>

<body>

    <!-- Begin Page Content -->
    <div class="container">

        <!-- DataTales Example -->
        <div class="card shadow my-5">

            <div class="card-header py-3">
                <div class="row">
                    <h4 class="m-0 font-primary mayus bold col-8">Modificar Punto de Red</h4>
                    <div class="col-4 text-right">
                    </div>
                </div>
            </div>

            <div class="card-body">

                <form action="../functions.php" id="form" method="POST">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-row mb-0 mt-2">

                                <div class="form-group col">
                                    <label for="departamento" class="label-span left mayus">Departamento:</label>
                                    <select class="form-select" id="departamento" name="departamento" required>
                                        <option value="">--Selecciona un departamento--</option>
                                        <?php
                                        include("../db.php");

                                        // Obtener el departamento actual del equipo
                                        $departamento_actual = $usuario['departamento'];

                                        // Consultar todos los departamentos disponibles
                                        $sql = "SELECT * FROM departamentos ORDER BY nombre_departamento ASC";
                                        $resultado = mysqli_query($conexion, $sql);

                                        // Iterar sobre los resultados y crear las opciones del select
                                        while ($consulta = mysqli_fetch_array($resultado)) {
                                            // Marcar como seleccionado el departamento actual del equipo
                                            $selected = ($departamento_actual == $consulta['nombre_departamento']) ? 'selected' : '';

                                            // Imprimir la opción del departamento
                                            echo '<option value="' . $consulta['nombre_departamento'] . '" ' . $selected . '>' . $consulta['nombre_departamento'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>


                                <div class="form-group col">
                                    <label for="descripcion" class="label-span left mayus">Descripción:</label>
                                    <input type="text" id="descripcion" name="descripcion" class="form-control" value="<?php echo $usuario['descripcion']; ?>">
                                </div>

                            </div>

                            <hr class="custom-hr-center">

                            <div class="form-row mb-0 mt-2">
                                <div class="form-group col-6">
                                    <label for="estado" class="form-label label-span left mayus">Estado:</label>
                                    <select name="estado" id="estado" class="form-select" required>
                                        <option value="">--Selecciona una opción--</option>
                                        <option <?php echo $usuario['estado'] === 'Activo' ? "selected='selected' " : "" ?> value="Activo">Activo</option>
                                        <option <?php echo $usuario['estado'] === 'Inactivo' ? "selected='selected' " : "" ?> value="Inactivo">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-6">

                            <div class="form-row mb-0 mt-2">

                                <?php if (!empty($usuario['patch_panel']) && $usuario['patch_panel'] !== null && $usuario['patch_panel'] !== 0) : ?>
                                    <div class="form-group col-6">
                                        <label for="patch_panel" class="label-span mayus">Patch Panel</label>
                                        <select class="form-control form-select" id="patch_panel" name="patch_panel">
                                            <option value="">--Selecciona el Patch Panel--</option>
                                            <option <?php echo ($usuario['patch_panel'] == 1) ? 'selected' : ''; ?> value="1">1</option>
                                            <option <?php echo ($usuario['patch_panel'] == 2) ? 'selected' : ''; ?> value="2">2</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-2 col-6">
                                        <br>
                                        <!-- Mostrar el número de puerto seleccionado -->
                                        <span class="font-dark bold mayus" id="puerto_pp_text"><?php echo 'Puerto PP: ' . $usuario['puerto_pp']; ?></span>
                                        <!-- Botón para cambiar -->
                                        <button type="button" id="cambiar_puerto_pp" class="btn btn-sm btn-agg ml-2">Cambiar</button>


                                    </div>

                                    <div class="form-group col-6" id="puerto_pp_select" style="display: none;">
                                        <label for="puerto_pp" class="label-span mayus">Puerto PP</label>
                                        <select class="form-select" name="puerto_pp" id="puerto_pp">
                                            <!-- Aquí se generarán dinámicamente las opciones de puerto PP -->
                                            <?php
                                            // Obtén el valor de puerto_pp de la base de datos
                                            $puerto_pp_db = $usuario['puerto_pp'];

                                            // Muestra una opción seleccionada con el valor de puerto_pp de la base de datos
                                            echo '<option value="' . $puerto_pp_db . '" selected>' . $puerto_pp_db . '</option>';
                                            ?>
                                        </select>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <div class="form-row mb-0 mt-2">
                                <div class="form-group col-6">
                                    <label for="switches" class="label-span mayus">Switches</label>
                                    <select class="form-control form-select" id="switches" name="switches">
                                        <option value="">--Selecciona el Switch--</option>
                                        <option <?php echo ($usuario['switches'] == 1) ? 'selected' : ''; ?> value="1">1</option>
                                        <option <?php echo ($usuario['switches'] == 2) ? 'selected' : ''; ?> value="2">2</option>
                                    </select>
                                </div>

                                <div class="form-group mt-2 col-6">
                                    <br>
                                    <!-- Mostrar el número de puerto seleccionado -->
                                    <span class="font-dark bold mayus" id="puerto_sw_text"><?php echo 'Puerto SW: ' . $usuario['puerto_sw']; ?></span>
                                    <!-- Botón para cambiar -->
                                    <button type="button" id="cambiar_puerto_sw" class="btn btn-sm btn-agg ml-2">Cambiar</button>


                                </div>

                                <div class="form-group col-6" id="puerto_sw_select" style="display: none;">
                                    <label for="puerto_sw" class="label-span mayus">Puerto SW</label>
                                    <select class="form-select" name="puerto_sw" id="puerto_sw">
                                        <option value="" selected>Selecciona un Puerto Disponible</option>
                                        <!-- Aquí se generarán dinámicamente las opciones de puerto PP -->
                                        <?php
                                        // Obtén el valor de puerto_pp de la base de datos
                                        $puerto_sw_db = $usuario['puerto_sw'];

                                        // Muestra una opción seleccionada con el valor de puerto_pp de la base de datos
                                        echo '<option value="' . $puerto_sw_db . '" selected>' . $puerto_sw_db . '</option>';
                                        ?>
                                    </select>
                                </div>
                            </div>



                        </div>

                        <?php
                        date_default_timezone_set('America/Caracas');
                        ?>
                        <input type="hidden" id="fecha_ultima_modificacion" name="fecha_ultima_modificacion" value="<?php echo date('Y-m-d H:i:s'); ?>">
                        <input type="hidden" id="encargado_modificacion" name="encargado_modificacion" value="<?php echo $nombreUsuario . ' ' . $apellidoUsuario; ?>">

                        <input type="hidden" name="accion" value="editar_puntored">
                        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

                        <div class="card-footer">

                            <div class="my-2 d-flex justify-content-center">
                                <button type="submit" id="form" name="form" class="btn btn-agg mr-2 mayus bold">
                                    <i class="fa-regular fa-floppy-disk"></i> Guardar Cambios</button>

                                <a href="../../views/puntos_red.php" class="btn btn-delete ml-2 mayus bold">
                                    <i class="fa-solid fa-x"></i> Cancelar
                                </a>
                            </div>

                        </div>


                    </div>
            </div>
        </div>
    </div>

    </form>



    <script>
        $(document).ready(function() {
            // Manejar el clic en el botón "Cambiar" de puerto PP
            $('#cambiar_puerto_pp').click(function() {
                // Ocultar el texto del puerto PP y mostrar el select de puertos disponibles

                $('#puerto_pp_select').show();
                $('#cambiar_puerto_pp').hide();
            });

            // Manejar el cambio en la selección del patch panel
            $('#patch_panel').change(function() {
                var patchPanelSeleccionado = $(this).val();
                console.log('Patch panel seleccionado:', patchPanelSeleccionado);
                obtenerPuertosPP(patchPanelSeleccionado);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Manejar el clic en el botón "Cambiar" de puerto SW
            $('#cambiar_puerto_sw').click(function() {
                // Ocultar el texto del puerto SW y mostrar el select de puertos disponibles

                $('#puerto_sw_select').show();
                $('#cambiar_puerto_sw').hide();
            });

            // Manejar el cambio en la selección del switches
            $('#switches').change(function() {
                var switchSeleccionado = $(this).val();
                console.log('Switches seleccionado:', switchSeleccionado);
                obtenerPuertosSW(switchSeleccionado);
            });
        });
    </script>

    <script>
        // Definir la función obtenerPuertosPP fuera del bloque $(document).ready()
        function obtenerPuertosPP(patchPanelSeleccionado) {
            $.ajax({
                type: 'POST',
                url: '..//_puntosred/obtener_puertos_pp.php',
                data: {
                    patch_panel: patchPanelSeleccionado
                },
                success: function(response) {
                    console.log('Respuesta del servidor:', response);
                    // Limpiar las opciones existentes antes de agregar las nuevas
                    $('#puerto_pp').empty();

                    // Agregar las nuevas opciones
                    $('#puerto_pp').html(response);

                    // Obtener el valor actual del puerto PP de la base de datos
                    var puerto_pp_db = <?php echo json_encode($usuario['puerto_pp']); ?>;

                    // Establecer el valor predeterminado
                    $('#puerto_pp').val(puerto_pp_db);
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        }

        $(document).ready(function() {
            // Cargar los puertos PP disponibles al cargar la página
            var patchPanelSeleccionado = $('#patch_panel').val();
            obtenerPuertosPP(patchPanelSeleccionado);

            // Cambio en la selección del patch panel
            $('#patch_panel').change(function() {
                var patchPanelSeleccionado = $(this).val();
                console.log('Patch panel seleccionado:', patchPanelSeleccionado);
                obtenerPuertosPP(patchPanelSeleccionado); // Llama a la función para obtener los puertos PP cada vez que se cambia el patch panel
            });
        });
    </script>


    <script>
        // Definir la función obtenerPuertosSW fuera del bloque $(document).ready()
        function obtenerPuertosSW(switchSeleccionado) {
            $.ajax({
                type: 'POST',
                url: '..//_puntosred/obtener_puertos_sw.php',
                data: {
                    switches: switchSeleccionado
                },
                success: function(response) {
                    console.log('Respuesta del servidor:', response);
                    // Limpiar las opciones existentes antes de agregar las nuevas
                    $('#puerto_sw').empty();

                    // Agregar las nuevas opciones
                    $('#puerto_sw').html(response);

                    // Obtener el valor actual del puerto PP de la base de datos
                    var puerto_sw_db = <?php echo json_encode($usuario['puerto_sw']); ?>;

                    // Establecer el valor predeterminado
                    $('#puerto_sw').val(puerto_sw_db);
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        }

        $(document).ready(function() {
            // Cargar los puertos PP disponibles al cargar la página
            var switchSeleccionado = $('#switches').val();
            obtenerPuertosSW(switchSeleccionado);
            // Manejar el cambio en la selección del switch
            $('#switches').change(function() {
                var switchSeleccionado = $(this).val();
                console.log('Switch seleccionado:', switchSeleccionado); // Mensaje de depuración
                obtenerPuertosSW(switchSeleccionado); // Llama a la función para obtener los puertos SW cada vez que se cambia el switch
            });
        });
    </script>


    <?php include_once "footer.php"; ?>



</body>

</html>