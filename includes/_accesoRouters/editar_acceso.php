<?php


session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion == '') {
    header("Location: ../includes/_sesion/login.php");
}

$id = $_GET['id'];
include "../db.php";
$consulta = "SELECT * FROM acceso_routers WHERE id = $id";
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
                    <h4 class="m-0 font-primary mayus bold col-8">Modificar Acceso a Router</h4>
                    <div class="col-4 text-right">
                    </div>
                </div>
            </div>

            <div class="card-body">

                <form action="../functions.php" id="form" method="POST">

                    <div class="row mt-4">

                        <div class="col-md-2"></div>

                        <div class="col-md-8">

                            <div class="form-row mb-0 mt-2">

                                <div class="form-group col-6">
                                    <label for="id_equipo" class="label-span mayus">Equipo Router: </label>
                                    <select class="form-select" id="id_equipo" name="id_equipo">
                                        <option value="">--Selecciona un equipo--</option>
                                        <?php
                                        include("../db.php");

                                        // Obtener el equipo actual del usuario
                                        $equipo_actual = $usuario['id_equipo'];

                                        // Consultar los equipos que sean routers
                                        $sql = "SELECT * FROM equipos WHERE tipo_equipo = 'Router'";
                                        $resultado = mysqli_query($conexion, $sql);

                                        // Iterar sobre los resultados y crear las opciones del select
                                        while ($consulta = mysqli_fetch_array($resultado)) {
                                            // Marcar como seleccionado el equipo actual del usuario
                                            $selected = ($equipo_actual == $consulta['id']) ? 'selected' : '';

                                            echo '<option value="' . $consulta['id'] . '" ' . $selected . '>' . $consulta['marca'] . ' - ' . $consulta['modelo'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="form-row mb-0 mt-2">

                                <div class="form-group col-6">
                                    <label for="direccion_ip" class="label-span">Dirección IP (Puerta de Enlace): </label>
                                    <input type="text" name="direccion_ip" id="direccion_ip" class="form-control text-center" value="<?php echo $usuario['direccion_ip']; ?>">
                                </div>

                                <div class="form-group col-6">
                                    <label for="wan_ip" class="label-span">Dirección WAN IP: </label>
                                    <input type="text" name="wan_ip" id="wan_ip" class="form-control text-center" value="<?php echo $usuario['wan_ip']; ?>">
                                </div>

                            </div>

                            <hr>

                            <div class="form-row mb-0 mt-2">
                                <div class="form-group col-6">
                                    <label for="" class="label-span">Acceso a Red WIFI</label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>">
                                        <label for="floatingInputGrid">Nombre Red WIFI (SSID)</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="contraseña" name="contraseña" value="<?php echo $usuario['contraseña']; ?>">
                                        <label for="floatingInputGrid">Contraseña WIFI</label>
                                    </div>
                                </div>

                                <div class="form-group col-6">
                                    <label for="" class="label-span">Acceso a Panel Admin</label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="usuario_acceso" name="usuario_acceso" value="<?php echo $usuario['usuario_acceso']; ?>">
                                        <label for="floatingInputGrid">Usuario</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="contraseña_acceso" name="contraseña_acceso" value="<?php echo $usuario['contraseña_acceso']; ?>">
                                        <label for="floatingInputGrid">Contraseña</label>
                                    </div>
                                </div>

                            </div>

                            <div class="form-row mb-0 mt-2">
                                <div class="form-group col-9">
                                    <div class="form-group col">
                                        <label for="uso" class="label-span mayus">Uso: </label>
                                        <textarea type="text" name="uso" id="uso" class="form-control"><?php echo $usuario['uso']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group col-2 mt-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="filtro_mac" name="filtro_mac" <?php echo $usuario['filtro_mac'] === 'Sí' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="filtro_mac"> Filtro MAC</label>
                                    </div>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="visibilidad" name="visibilidad" <?php echo $usuario['visibilidad'] === 'Visible' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="visibilidad">Visible</label>
                                    </div>
                                </div>

                                <!-- Campos ocultos para almacenar los valores actualizados de los checkboxes -->
                                <input type="hidden" id="filtro_mac_hidden" name="filtro_mac" value="<?php echo !empty($usuario['filtro_mac']) ? $usuario['filtro_mac'] : 'No'; ?>">
                                <input type="hidden" id="visibilidad_hidden" name="visibilidad" value="<?php echo !empty($usuario['visibilidad']) ? $usuario['visibilidad'] : 'Oculto'; ?>">

                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        var filtroMacCheckbox = document.getElementById("filtro_mac");
                                        var visibilidadCheckbox = document.getElementById("visibilidad");
                                        var filtroMacHidden = document.getElementById("filtro_mac_hidden");
                                        var visibilidadHidden = document.getElementById("visibilidad_hidden");

                                        filtroMacCheckbox.addEventListener("change", function() {
                                            filtroMacHidden.value = this.checked ? "Sí" : "No";
                                        });

                                        visibilidadCheckbox.addEventListener("change", function() {
                                            visibilidadHidden.value = this.checked ? "Visible" : "Oculto";
                                        });
                                    });
                                </script>

                            </div>

                            <div class="form-row mb-0 mt-2">
                                <div class="form-group col-12">
                                    <div class="form-group col">
                                        <label for="ubicacion" class="label-span mayus">Ubicación: </label>
                                        <textarea type="text" name="ubicacion" id="ubicacion" class="form-control"><?php echo $usuario['ubicacion']; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <hr>

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

                        <div class="col-md-2"></div>

                        <?php
                        date_default_timezone_set('America/Caracas');
                        ?>
                        <input type="hidden" id="fecha_modificacion" name="fecha_modificacion" value="<?php echo date('Y-m-d H:i:s'); ?>">

                        <input type="hidden" id="encargado_modificacion" name="encargado_modificacion" value="<?php echo $idUsuario; ?>">

                        <input type="hidden" name="accion" value="editar_accesoRouter">

                        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

                        <div class="card-footer">

                            <div class="my-2 d-flex justify-content-center">
                                <button type="submit" id="form" name="form" class="btn btn-agg mr-2 mayus bold">
                                    <i class="fa-regular fa-floppy-disk"></i> Guardar Cambios</button>

                                <a href="../../views/acceso_routers.php" class="btn btn-delete ml-2 mayus bold">
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