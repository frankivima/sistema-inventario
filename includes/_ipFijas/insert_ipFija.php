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

<div class="modal fade" id="insert_ip_fija" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title mayus bold" id="exampleModalLabel">Asignar ip fija</h3>
                <button type="button" class="btn btn-black" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>

            <div class="modal-body">

                <form id="form-ip-fija" action="../includes/functions.php" method="POST">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="form-row mb-0 mt-2">

                                <div class="form-group col">
                                    <label for="departamento" class="label-span mayus">Departamento: </label>
                                    <select class="form-select" id="departamento" name="departamento" required>
                                        <option value="">--Selecciona un departamento--</option>
                                        <?php
                                        include("../db.php");
                                        $sql = "SELECT * FROM departamentos ";
                                        $resultado = mysqli_query($conexion, $sql);
                                        while ($consulta = mysqli_fetch_array($resultado)) {
                                            echo '<option value="' . $consulta['nombre_departamento'] . '">' . $consulta['nombre_departamento'] . '</option>';
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
                                    <input type="text" name="ip" id="ip" class="form-control" value="192.168.15.">
                                </div>
                            </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    var direccionIpInput = document.getElementById("ip");

                                    // Permitir al usuario cambiar solo los últimos tres dígitos después del punto
                                    direccionIpInput.addEventListener("input", function() {
                                        var inputValue = direccionIpInput.value;
                                        var prefix = "192.168.15.";

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
                                            direccionIpInput.value = prefix;
                                            return;
                                        }

                                        // Limitar la longitud de los últimos tres dígitos a tres caracteres
                                        if (lastDigits.length > 3) {
                                            direccionIpInput.value = prefix + lastDigits.slice(0, 3);
                                        }
                                    });
                                });
                            </script>

                            <div class="form-row mb-0 mt-2">

                                <div class="form-group col">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="6"></textarea>
                                        <label for="floatingTextarea2" class="label-span">Descripción (Opcional):</label>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <?php
                    date_default_timezone_set('America/Caracas');
                    ?>
                    <input type="hidden" id="fecha_registro" name="fecha_registro" value="<?php echo date('Y-m-d'); ?>">
                    <input type="hidden" id="encargado_registro" name="encargado_registro" value="<?php echo $idUsuario; ?>">


                    <input type="hidden" name="estado" value="Activo">
                    <input type="hidden" name="accion" value="insert_ip_fija">

                    <div class="modal-footer d-flex justify-content-center">

                        <button type="button" onclick="validarFormulario()" id="register" name="registrar" class="btn btn-agg mayus mr-2">Asignar IP</button>

                        <a href="ip_fijas.php" class="btn btn-delete mayus ml-2">Cancelar</a>


                    </div>


                    <script>
                        $(document).ready(function() {
                            $('#departamento').change(function() {
                                var departamento = $(this).val();
                                if (departamento !== '') {
                                    $.ajax({
                                        url: '../includes/_ipFijas/obtener_equipos.php', // Archivo PHP que obtiene los equipos según el departamento
                                        method: 'POST',
                                        data: {
                                            departamento: departamento
                                        },
                                        success: function(data) {
                                            $('#id_equipo').html(data); // Actualiza el select de equipos con los datos devueltos
                                            $('#id_equipo').val("");
                                        }
                                    });
                                } else {
                                    $('#id_equipo').html('<option value="">--Selecciona un departamento--</option>'); // Restablece el select de equipos
                                }
                            });
                        });
                    </script>


                    <script>
                        function validarFormulario() {
                            var departamento = document.getElementById("departamento").value;
                            var equipo = document.getElementById("id_equipo").value;
                            var ip = document.getElementById("ip").value;

                            // Verificar si alguno de los campos está vacío
                            if (departamento.trim() === '') {
                                // Mostrar mensaje de error para el campo Departamento
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'El campo Departamento es obligatorio. Por favor, complételo.'
                                });
                            } else if (ip.trim() === '') {
                                // Mostrar mensaje de error para el campo Tipo de Equipo
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Debe insertar un dirección IP. Por favor, asígnalo.'
                                });
                            } else {
                                // Si todos los campos están completos, enviar el formulario
                                document.getElementById("form-ip-fija").submit();
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