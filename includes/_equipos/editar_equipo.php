<?php


session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion == '') {
    header("Location: ../includes/_sesion/login.php");
}

$id = $_GET['id'];
include "../db.php";
$consulta = "SELECT * FROM equipos WHERE id = $id";
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
                    <h4 class="m-0 font-primary mayus bold col-8">Editar Equipo</h4>
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
                                    <label for="usuario_responsable" class="label-span left mayus">Usuario Responsable:</label>
                                    <input type="text" id="usuario_responsable" name="usuario_responsable" class="form-control" value="<?php echo $usuario['usuario_responsable']; ?>" required>
                                </div>

                            </div>

                            <hr>

                            <div class="form-row mb-0 mt-2">

                                <div class="form-group col">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="ubicacion" name="ubicacion"><?php echo $usuario['ubicacion']; ?></textarea>
                                        <label for="floatingTextarea2" class="label-span">Ubicación Física del Equipo:</label>
                                    </div>
                                </div>

                            </div>
                            <div class="form-row mb-0 mt-2">

                                <div class="form-group col">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="observaciones" name="observaciones"><?php echo $usuario['observaciones']; ?></textarea>
                                        <label for="floatingTextarea2" class="label-span">Observaciones del Equipo:</label>
                                    </div>
                                </div>

                            </div>

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

                                <div class="form-group col">
                                    <label for="tipo_equipo" class="label-span mayus">Tipo de Equipo</label>
                                    <select class="form-select" id="tipo_equipo" name="tipo_equipo" disabled>
                                        <option selected>--Selecciona el tipo de equipo--</option>
                                        <option <?php echo $usuario['tipo_equipo'] === 'CPU' ? "selected='selected' " : "" ?> value="CPU">CPU</option>
                                        <option <?php echo $usuario['tipo_equipo'] === 'Laptop' ? "selected='selected' " : "" ?> value="Laptop">Laptop</option>
                                        <option <?php echo $usuario['tipo_equipo'] === 'Cargador de Laptop' ? "selected='selected' " : "" ?> value="Cargador de Laptop">Cargador de Laptop</option>
                                        <option <?php echo $usuario['tipo_equipo'] === 'Mouse' ? "selected='selected' " : "" ?> value="Mouse">Mouse</option>
                                        <option <?php echo $usuario['tipo_equipo'] === 'Teclado' ? "selected='selected' " : "" ?> value="Teclado">Teclado</option>
                                        <option <?php echo $usuario['tipo_equipo'] === 'Monitor' ? "selected='selected' " : "" ?> value="Monitor">Monitor</option>
                                        <option <?php echo $usuario['tipo_equipo'] === 'Regulador de Voltaje' ? "selected='selected' " : "" ?> value="Regulador de Voltaje">Regulador de Voltaje</option>
                                        <option <?php echo $usuario['tipo_equipo'] === 'Impresora' ? "selected='selected' " : "" ?> value="Impresora">Impresora</option>
                                        <option <?php echo $usuario['tipo_equipo'] === 'Switch de Red' ? "selected='selected' " : "" ?> value="Switch de Red">Switch de Red</option>
                                        <option <?php echo $usuario['tipo_equipo'] === 'Router' ? "selected='selected' " : "" ?> value="Router">Router</option>
                                        <option <?php echo $usuario['tipo_equipo'] === 'Telefono' ? "selected='selected' " : "" ?> value="Telefono">Telefono</option>
                                        <option <?php echo $usuario['tipo_equipo'] === 'Televisor' ? "selected='selected' " : "" ?> value="Televisor">Televisor</option>
                                    </select>
                                </div>

                            </div>



                            <!-- Campos comunes -->
                            <div id="campos-comunes">
                                <!-- Campos comunes para todos los tipos de equipo -->

                                <div class="form-row mb-0 mt-1">
                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $usuario['marca']; ?>" required>
                                            <label for="floatingInputGrid" class="label-span">Marca:</label>
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo $usuario['modelo']; ?>" required>
                                            <label for="floatingInputGrid" class="label-span">Modelo:</label>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-row mb-0 mt-1">

                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="serial" name="serial" value="<?php echo $usuario['serial']; ?>" required>
                                            <label for="floatingInputGrid" class="label-span">Serial:</label>
                                        </div>
                                    </div>

                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="codigo_bienes" name="codigo_bienes" value="<?php echo $usuario['codigo_bienes']; ?>">
                                            <label for="floatingInputGrid" class="label-span">Código de Bienes:</label>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <!-- Campos específicos -->
                            <div id="campos-especificos">

                                <div class="form-row mb-0 mt-1">
                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="procesador" name="procesador" value="<?php echo $usuario['procesador']; ?>">
                                            <label for="floatingInputGrid" class="label-span">Procesador:</label>
                                        </div>
                                    </div>

                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="sistema_operativo" name="sistema_operativo" value="<?php echo $usuario['sistema_operativo']; ?>">
                                            <label for="floatingInputGrid" class="label-span">Sistema Operativo:</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mb-0 mt-1">

                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <select class="form-select" id="tipo_ram" name="tipo_ram">
                                                <option selected>Selecciona una Opcion</option>
                                                <option <?php echo $usuario['tipo_ram'] === 'DDR' ? "selected='selected' " : "" ?> value="DDR">DDR</option>
                                                <option <?php echo $usuario['tipo_ram'] === 'DDR2' ? "selected='selected' " : "" ?> value="DDR2">DDR2</option>
                                                <option <?php echo $usuario['tipo_ram'] === 'DDR3' ? "selected='selected' " : "" ?> value="DDR3">DDR3</option>
                                                <option <?php echo $usuario['tipo_ram'] === 'DDR4' ? "selected='selected' " : "" ?> value="DDR4">DDR4</option>
                                                <option <?php echo $usuario['tipo_ram'] === 'DDR5' ? "selected='selected' " : "" ?> value="DDR5">DDR5</option>
                                            </select>
                                            <label for="floatingSelectGrid" class="label-span">Tipo de Memoria RAM:</label>
                                        </div>
                                    </div>

                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="cant_memoria" name="cant_memoria" value="<?php echo $usuario['cant_memoria']; ?>">
                                            <label for="floatingInputGrid" class="label-span">Cantidad de Memoria RAM:</label>
                                        </div>
                                    </div>

                                </div>


                                <div class="form-row mb-0 mt-1">

                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <select class="form-select" id="tipo_disco" name="tipo_disco">
                                                <option selected>Selecciona una Opcion</option>
                                                <option <?php echo $usuario['tipo_disco'] === 'HDD / SATA' ? "selected='selected' " : "" ?> value="HDD / SATA">HDD / SATA</option>
                                                <option <?php echo $usuario['tipo_disco'] === 'SSD' ? "selected='selected' " : "" ?> value="SSD">SSD</option>
                                                <option <?php echo $usuario['tipo_disco'] === 'PATA / IDE' ? "selected='selected' " : "" ?> value="PATA / IDE">PATA / IDE</option>
                                            </select>
                                            <label for="floatingSelectGrid" class="label-span">Tipo de Disco Duro:</label>
                                        </div>
                                    </div>

                                    <div class="form-group col">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="almacenamiento" name="almacenamiento" value="<?php echo $usuario['almacenamiento']; ?>">
                                            <label for="floatingInputGrid" class="label-span">Cantidad de Almacenamiento:</label>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- Campo de entrada oculto para enviar el valor seleccionado -->
                        <input type="hidden" name="tipo_equipo" value="<?php echo $usuario['tipo_equipo']; ?>">


                        <?php
                        date_default_timezone_set('America/Caracas');
                        ?>
                        <input type="hidden" id="fecha_ultima_modificacion" name="fecha_ultima_modificacion" value="<?php echo date('Y-m-d H:i:s'); ?>">
                        <input type="hidden" id="encargado_modificacion" name="encargado_modificacion" value="<?php echo $idUsuario; ?>">

                        <input type="hidden" name="accion" value="editar_equipo">
                        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">


                        <div class="card-footer">

                            <div class="my-2 d-flex justify-content-center">
                                <button type="submit" id="form" name="form" class="btn btn-agg mr-2 mayus bold">
                                    <i class="fa-regular fa-floppy-disk"></i> Guardar Cambios</button>

                                <a href="../../views/equipos.php" class="btn btn-delete ml-2 mayus bold">
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
        document.addEventListener("DOMContentLoaded", function() {
            // Obtener el elemento select del tipo de equipo
            var tipoEquipoSelect = document.getElementById("tipo_equipo");

            // Obtener los elementos de los campos específicos
            var camposEspecificos = document.getElementById("campos-especificos");

            // Mostrar u ocultar campos específicos al cargar la página
            toggleCamposEspecificos();

            // Agregar un evento de cambio al campo de tipo de equipo
            tipoEquipoSelect.addEventListener("change", function() {
                toggleCamposEspecificos();
            });

            function toggleCamposEspecificos() {
                // Obtener el valor seleccionado en el campo de tipo de equipo
                var tipoEquipoValue = tipoEquipoSelect.value;

                // Mostrar u ocultar campos específicos según el tipo de equipo seleccionado
                camposEspecificos.style.display = (tipoEquipoValue === 'Laptop' || tipoEquipoValue === 'CPU') ? 'block' : 'none';
            }
        });
    </script>



    <?php include_once "footer.php"; ?>



</body>

</html>