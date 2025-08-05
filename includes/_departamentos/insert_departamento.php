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

<div class="modal fade" id="insert_departamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title mayus bold" id="exampleModalLabel">Agregar Departamento</h3>
                <button type="button" class="btn btn-black" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>

            <div class="modal-body">

                <form action="../includes/functions.php" method="POST">

                    <div class="form-row mb-0 mt-2">
                        <div class="form-group col">
                            <label for="nombre_departamento" class="label-span">Nombre del Departamento (Unidad de Trabajo)</label>
                            <input type="text" id="nombre_departamento" name="nombre_departamento" class="form-control" required>
                        </div>
                    </div>


                    <input type="hidden" id="fecha_registro" name="fecha_registro" value="<?php echo date('Y-m-d H:i:s'); ?>">
                    <input type="hidden" id="encargado_registro" name="encargado_registro" value="<?php echo $idUsuario; ?>">


                    <input type="hidden" name="estado" value="Activo">
                    <input type="hidden" name="accion" value="insert_departamento">
                    <br>

                    <div class="modal-footer d-flex justify-content-center">

                        <button type="submit" id="register" name="registrar" class="btn btn-agg mr-2 bold mayus">Agregar Departamento</button>
                        <a href="departamentos.php" class="btn btn-delete ml-2 bold mayus">Cancelar</a>

                    </div>
            </div>
        </div>

        </form>
    </div>
</div>