<?php


session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion == '') {
    header("Location: ../includes/_sesion/login.php");
}

$id = $_GET['id'];
include "../db.php";
$consulta = "SELECT * FROM departamentos WHERE id = $id";
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
                    <h4 class="m-0 font-primary mayus bold col-8">Editar Departamento (Unidad de Trabajo)</h4>
                    <div class="col-4 text-right">
                    </div>
                </div>
            </div>

            <div class="card-body">

                <form action="../functions.php" id="form" method="POST">

                    <div class="form-row">
                        <div class="form-group col">
                            <label for="nombre_departamento" class="form-label label-span left">Nombre del Departamento (Unidad de Trabajo):</label>
                            <input type="text" id="nombre_departamento" name="nombre_departamento" class="form-control" value="<?php echo $usuario['nombre_departamento']; ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-4">
                            <label for="estado" class="form-label label-span left">Estado:</label>
                            <select name="estado" id="estado" class="form-select" required>
                                <option value="">--Selecciona una opción--</option>
                                <option <?php echo $usuario['estado'] === 'Activo' ? "selected='selected' " : "" ?> value="Activo">Activo</option>
                                <option <?php echo $usuario['estado'] === 'Inactivo' ? "selected='selected' " : "" ?> value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="accion" value="editar_departamento">
                    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

                    <br>

                    <div class="card-footer">
                        <div class="my-2 d-flex justify-content-center">
                            <button type="submit" id="form" name="form" class="btn btn-agg mr-2 mayus">
                                <i class="fa-regular fa-floppy-disk"></i> Guardar Cambios</button>
                            <a href="../../views/departamentos.php" class="btn btn-delete ml-2 mayus">
                                <i class="fa-solid fa-x"></i> Cancelar
                            </a>
                        </div>
                    </div>

                </form>
            </div>

        </div>

    </div>
    </div>

    <?php include_once "footer.php"; ?>

</body>

</html>