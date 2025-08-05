<?php


session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion == '') {
    header("Location: ../includes/_sesion/login.php");
}

$id = $_GET['id'];
include "../db.php";
$consulta = "SELECT * FROM ip_fijas WHERE id = $id";
$resultado = mysqli_query($conexion, $consulta);
$usuario = mysqli_fetch_assoc($resultado);


// Asegúrate de que los datos del usuario estén disponibles en la sesión
if (isset($_SESSION['user_id'])) {
    $idUsuario = $_SESSION['user_id'];
} else {
    // Si no están disponibles, puedes mostrar el nombre de usuario
    $nombreUsuario = $_SESSION['username'];
}

?>

<?php include_once "header.php"; ?>

<body>

    <!-- Begin Page Content -->
    <div class="container">

        <!-- DataTales Example -->
        <div class="card shadow my-5">

            <div class="card-header py-3">
                <div class="row">
                    <h4 class="m-0 font-primary mayus bold col-8">Modificar Asignación de IP Fija</h4>
                    <div class="col-4 text-right">
                    </div>
                </div>
            </div>

            <div class="card-body">

                <form action="../functions.php" id="form" method="POST">

                    <div class="row mt-4">

                        <div class="col-md-3"></div>

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
                                        $sql = "SELECT * FROM departamentos";
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
                                    <label for="id_equipo" class="label-span mayus">Equipo: </label>
                                    <select class="form-select" id="id_equipo" name="id_equipo" required>
                                        <option value="" selected>--Selecciona un equipo--</option>
                                    </select>
                                </div>

                            </div>

                            <div class="form-row mb-0 mt-2">

                                <div class="form-group col">
                                    <label for="ip" class="label-span mayus">Dirección IP: </label>
                                    <input type="text" name="ip" id="ip" class="form-control" value="<?php echo $usuario['ip']; ?>">
                                </div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        var direccionIpInput = document.getElementById("ip");

                                        // Obtener la dirección IP predeterminada del registro
                                        var defaultValue = "<?php echo $usuario['ip']; ?>";
                                        var prefix = "192.168.15.";

                                        // Establecer el valor predeterminado en el campo de dirección IP
                                        direccionIpInput.value = defaultValue;

                                        // Permitir al usuario cambiar solo los últimos tres dígitos después del punto
                                        direccionIpInput.addEventListener("input", function() {
                                            var inputValue = direccionIpInput.value;

                                            // Si el valor no comienza con el prefijo predeterminado, restablecerlo
                                            if (!inputValue.startsWith(prefix)) {
                                                direccionIpInput.value = prefix;
                                                return;
                                            }

                                            // Obtener los últimos tres dígitos después del punto
                                            var lastDigits = inputValue.substring(prefix.length);

                                            // Asegurarse de que los últimos tres dígitos sean números y están en el rango
                                            var lastDigitsNumber = parseInt(lastDigits);
                                            if (isNaN(lastDigitsNumber) || lastDigitsNumber < 0 || lastDigitsNumber > 260) {
                                                // Restaurar el valor predeterminado si los últimos tres dígitos no son válidos
                                                direccionIpInput.value = defaultValue;
                                                return;
                                            }

                                            // Limitar la longitud de los últimos tres dígitos a tres caracteres
                                            if (lastDigits.length > 3) {
                                                direccionIpInput.value = prefix + lastDigits.slice(0, 3);
                                            }
                                        });
                                    });
                                </script>


                            </div>

                            <div class="form-row mb-0 mt-2">

                                <div class="form-group col">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="descripcion" name="descripcion"><?php echo $usuario['descripcion']; ?></textarea>
                                        <label for="floatingTextarea2" class="label-span">Descripción (Opcional):</label>
                                    </div>
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

                        <div class="col-md-3"></div>

                        <?php
                        date_default_timezone_set('America/Caracas');
                        ?>
                        <input type="hidden" id="fecha_ultima_modificacion" name="fecha_modificacion" value="<?php echo date('Y-m-d'); ?>">

                        <input type="hidden" id="encargado_modificacion" name="encargado_modificacion" value="<?php echo $idUsuario; ?>">

                        <input type="hidden" name="accion" value="editar_ip_fija">
                        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

                        <div class="card-footer">

                            <div class="my-2 d-flex justify-content-center">
                                <button type="submit" id="form" name="form" class="btn btn-agg mr-2 mayus bold">
                                    <i class="fa-regular fa-floppy-disk"></i> Guardar Cambios</button>

                                <a href="../../views/ip_fijas.php" class="btn btn-delete ml-2 mayus bold">
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
            // Obtener el departamento seleccionado
            var departamento = $('#departamento').val();

            // Si el departamento está seleccionado, obtener los equipos correspondientes
            if (departamento !== '') {
                $.ajax({
                    url: '../_ipFijas/obtener_equipos.php', // Archivo PHP que obtiene los equipos según el departamento
                    method: 'POST',
                    data: {
                        departamento: departamento
                    },
                    success: function(data) {
                        $('#id_equipo').html(data); // Actualiza el select de equipos con los datos devueltos

                        // Obtener el ID del equipo del registro actual
                        var id_equipo_actual = '<?php echo $usuario['id_equipo']; ?>';

                        // Si hay un ID de equipo actual, seleccionarlo en el select de equipos
                        if (id_equipo_actual !== '') {
                            $('#id_equipo').val(id_equipo_actual);
                        }
                    }
                });
            } else {
                $('#id_equipo').html('<option value="">--Selecciona un departamento--</option>'); // Restablece el select de equipos
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            // Cuando se cambia la selección del departamento
            $('#departamento').change(function() {
                var departamentoSeleccionado = $(this).val();

                // Si se ha seleccionado un departamento
                if (departamentoSeleccionado !== '') {
                    $.ajax({
                        url: '../_ipFijas/obtener_equipos.php', // Archivo PHP que obtiene los equipos según el departamento
                        method: 'POST',
                        data: {
                            departamento: departamentoSeleccionado
                        },
                        success: function(data) {
                            $('#id_equipo').html(data); // Actualiza el select de equipos con los datos devueltos
                        }
                    });
                } else {
                    // Si no se ha seleccionado un departamento, reinicia el select de equipos
                    $('#id_equipo').html('<option value="">--Selecciona un departamento--</option>');
                }
            });
        });
    </script>


    <?php include_once "footer.php"; ?>



</body>

</html>