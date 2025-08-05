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

<div class="modal fade" id="insert_acceso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title mayus bold" id="exampleModalLabel">Registrar Acceso Router</h3>
                <button type="button" class="btn btn-black" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>

            <div class="modal-body">

                <form id="form" action="../includes/functions.php" method="POST">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="form-row mb-0 mt-2">

                                <div class="form-group col">
                                    <label for="id_equipo" class="label-span mayus">Equipo Router: </label>
                                    <select class="form-select" id="id_equipo" name="id_equipo">
                                        <option value="">--Selecciona un equipo--</option>
                                        <?php
                                        include("../db.php");
                                        $sql = "SELECT * FROM equipos WHERE tipo_equipo = 'Router'";
                                        $resultado = mysqli_query($conexion, $sql);
                                        while ($consulta = mysqli_fetch_array($resultado)) {
                                            echo '<option value="' . $consulta['id'] . '">' . $consulta['marca'] . ' - ' . $consulta['modelo'] . '</option>';
                                        }
                                        ?>
                                    </select>

                                </div>

                            </div>

                            <hr>

                            <div class="form-row mb-0 mt-2">

                                <div class="form-group col-6">
                                    <label for="direccion_ip" class="label-span">Dirección IP (Puerta de Enlace): </label>
                                    <input type="text" name="direccion_ip" id="direccion_ip" class="form-control" value="192.168.1">
                                </div>

                                <div class="form-group col-6">
                                    <label for="wan_ip" class="label-span">Dirección WAN IP: </label>
                                    <input type="text" name="wan_ip" id="wan_ip" class="form-control" value="192.168.15.">
                                </div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        var direccionIpInput = document.getElementById("direccion_ip");
                                        var prefix = "192.168.";

                                        // Prellenar el campo con el prefijo
                                        direccionIpInput.value = prefix;

                                        // Deshabilitar la edición del prefijo
                                        direccionIpInput.addEventListener("keydown", function(event) {
                                            if (direccionIpInput.selectionStart < prefix.length) {
                                                event.preventDefault();
                                            }
                                        });

                                        // Manejar la entrada del usuario para los últimos segmentos
                                        direccionIpInput.addEventListener("input", function() {
                                            var inputValue = direccionIpInput.value;

                                            // Si el valor no comienza con el prefijo, restablecerlo
                                            if (!inputValue.startsWith(prefix)) {
                                                direccionIpInput.value = prefix;
                                                return;
                                            }

                                            // Obtener la parte editable después del prefijo
                                            var editablePart = inputValue.substring(prefix.length);

                                            // Asegurarse de que la parte editable contenga solo números y puntos
                                            var validEditablePart = editablePart.replace(/[^0-9.]/g, '');
                                            if (editablePart !== validEditablePart) {
                                                direccionIpInput.value = prefix + validEditablePart;
                                            }

                                            // Limitar el número de puntos a dos y validar que no haya más de tres números entre puntos
                                            var segments = validEditablePart.split('.');
                                            if (segments.length > 3) {
                                                segments = segments.slice(0, 3);
                                            }
                                            for (var i = 0; i < segments.length; i++) {
                                                if (segments[i].length > 3) {
                                                    segments[i] = segments[i].slice(0, 3);
                                                }
                                            }

                                            direccionIpInput.value = prefix + segments.join('.');
                                        });
                                    });
                                </script>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        var wanIPInput = document.getElementById("wan_ip");

                                        // Permitir al usuario cambiar solo los últimos tres dígitos después del punto
                                        wanIpInput.addEventListener("input", function() {
                                            var inputValue = wanIpInput.value;
                                            var prefix = "192.168.15.";

                                            // Si el valor no comienza con el prefijo predeterminado, restablecerlo
                                            if (!inputValue.startsWith(prefix)) {
                                                wanIpInput.value = prefix;
                                                return;
                                            }

                                            // Obtener los últimos tres dígitos después del punto
                                            var lastDigits = inputValue.substring(prefix.length);

                                            // Asegurarse de que los últimos tres dígitos sean números y están en el rango
                                            var lastDigitsNumber = parseInt(lastDigits);
                                            if (isNaN(lastDigitsNumber) || lastDigitsNumber < 0 || lastDigitsNumber > 299) {
                                                // Restaurar el valor predeterminado si los últimos tres dígitos no son válidos
                                                wanIpInput.value = prefix;
                                                return;
                                            }

                                            // Limitar la longitud de los últimos tres dígitos a tres caracteres
                                            if (lastDigits.length > 3) {
                                                wanIpInput.value = prefix + lastDigits.slice(0, 3);
                                            }
                                        });
                                    });
                                </script>

                            </div>

                            <hr>

                            <div class="form-row mb-0 mt-2">
                                <div class="form-group col-6">
                                    <label for="" class="label-span">Acceso a Red WIFI</label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nombre" name="nombre">
                                        <label for="floatingInputGrid">Nombre Red WIFI (SSID)</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="contraseña" name="contraseña">
                                        <label for="floatingInputGrid">Contraseña WIFI</label>
                                    </div>
                                </div>

                                <div class="form-group col-6">
                                    <label for="" class="label-span">Acceso a Panel Admin</label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="usuario_acceso" name="usuario_acceso">
                                        <label for="floatingInputGrid">Usuario</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="contraseña_acceso" name="contraseña_acceso">
                                        <label for="floatingInputGrid">Contraseña</label>
                                    </div>
                                </div>

                            </div>

                            <hr>

                            <div class="form-row mb-0 mt-2">
                                <div class="form-group col-9">
                                    <div class="form-group col">
                                        <label for="uso" class="label-span mayus">Uso: </label>
                                        <textarea type="text" name="uso" id="uso" class="form-control"></textarea>
                                    </div>
                                </div>



                                <div class="form-group col-2 mt-4">

                                    <div class="form-check text-end">
                                        <input class="form-check-input" type="checkbox" value="No" id="filtro_mac">
                                        <label class="form-check-label" for="filtro_mac"> Filtro MAC</label>
                                    </div>

                                    <div class="form-check form-switch text-end">
                                        <input class="form-check-input" type="checkbox" id="visibilidad" value="Visible">
                                        <label class="form-check-label" for="visibilidad">Visible</label>
                                    </div>

                                    <!-- Campos ocultos para almacenar los valores actualizados de los checkboxes -->
                                    <input type="hidden" id="filtro_mac_hidden" name="filtro_mac" value="No">
                                    <input type="hidden" id="visibilidad_hidden" name="visibilidad" value="Oculto">

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var filtroMacCheckbox = document.getElementById("filtro_mac");
                                            var visibilidadCheckbox = document.getElementById("visibilidad");
                                            var filtroMacHidden = document.getElementById("filtro_mac_hidden");
                                            var visibilidadHidden = document.getElementById("visibilidad_hidden");

                                            filtroMacCheckbox.addEventListener("change", function() {
                                                var valor = this.checked ? "Sí" : "No";
                                                filtroMacHidden.value = valor;
                                            });

                                            visibilidadCheckbox.addEventListener("change", function() {
                                                var valor = this.checked ? "Visible" : "Oculto";
                                                visibilidadHidden.value = valor;
                                            });
                                        });
                                    </script>

                                </div>

                            </div>

                            <div class="form-row mb-0 mt-2">
                                <div class="form-group col-12">
                                    <div class="form-group col">
                                        <label for="ubicacion" class="label-span mayus">Ubicación: </label>
                                        <textarea type="text" name="ubicacion" id="ubicacion" class="form-control"></textarea>
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
                    <input type="hidden" name="accion" value="insert_accesoRouter">

                    <div class="modal-footer d-flex justify-content-center">

                        <button type="submit" id="register" name="registrar" class="btn btn-agg mayus mr-2">Registrar Router</button>

                        <a href="acceso_routers.php" class="btn btn-delete mayus ml-2">Cancelar</a>


                    </div>


                </form>


            </div>
        </div>

    </div>
</div>

</div>
</div>