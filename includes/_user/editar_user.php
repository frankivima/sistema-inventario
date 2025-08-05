<?php


session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion = '') {
    header("Location: ../_sesion/login.php");
}

////////////////// CONEXION A LA BASE DE DATOS ////////////////////////////////////
$id = $_GET['id'];
include "../db.php";
$consulta = "SELECT * FROM usuarios WHERE id = $id";
$resultado = mysqli_query($conexion, $consulta);
$usuario = mysqli_fetch_assoc($resultado);
?>
<?php include_once "header.php"; ?>

<body>

    <form action="../functions.php" id="form" method="POST">

        <div class="container">

            <!-- DataTales Example -->
            <div class="card shadow my-5">

                <div class="card-header py-3">
                    <div class="row">
                        <h4 class="m-0 font-primary mayus bold col-8">Modificar Usuarios</h4>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div id="login-row" class="row justify-content-center align-items-center mx-5">

                        <div class="form-row">
                            <div class="form-group col">
                                <label for="nombre" class="label-span">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $usuario['nombre']; ?>">
                            </div>
                            <div class="form-group col">
                                <label for="apellido" class="label-span">Apellido</label>
                                <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo $usuario['apellido']; ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label for="username" class="label-span">Usuario</label><br>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Debe ser Unico" value="<?php echo $usuario['username']; ?>">
                            </div>
                            <div class="form-group col">
                                <label for="password" class="label-span">Contraseña</label><br>
                                <input type="text" name="password" id="password" class="form-control" value="<?php echo $usuario['password']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="rol" class="label-span">Rol de usuario:</label>
                            <select name="rol" id="rol" class="form-select" required>
                                <option <?php echo $usuario['rol'] === '1' ? "selected='selected' " : "" ?> value="1">Administrador</option>

                                <input type="hidden" name="accion" value="editar_user">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                            </select>
                        </div>

                    </div>
                </div>

                <div class="card-footer">

                    <div class="my-2 d-flex justify-content-center">

                        <button type="submit" id="form" name="form" class="btn btn-agg mr-2 mayus">
                            <i class="fa-regular fa-floppy-disk"></i> Guardar Cambios
                        </button>
                        <a href="../../views/usuarios.php" class="btn btn-delete ml-2 mayus">
                            <i class="fa-solid fa-x"></i> Cancelar
                        </a>

                    </div>
                </div>

            </div>
        </div>
        </div>

        </div>
        </div>

    </form>

    </div>


    <?php include_once "footer.php"; ?>
</body>

</html>