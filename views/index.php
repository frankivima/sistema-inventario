<?php
// Seguridad de sesiones
session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion == '') {
    header("Location: ../includes/_sesion/login.php");
    die();
}

include '../includes/header.php';

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

<!-- Begin Page Content -->
<div class="container-fluid px-5">
    <h1 class="mt-4 font-primary">¡Bienvenido <?php echo $nombreUsuario . ' ' . $apellidoUsuario; ?>!</h1>
    <br>


    <div class="card">
        <div class="card-body">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 font-secundary mb-0">Panel Administrativo</h1>
                <hr>
            </div>


            <!-- Content Row -->
            <div class="row">

                <?php
                // Verifica el rol del usuario
                if ($_SESSION['rol'] == 1) {
                ?>

                    <!-- Pending Requests Card Example -->
                    <div class="col-xl-3 col-md-6 col-sm-6 col-12 mb-4">
                        <div class="card card-1 py-2 card-hover">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <a href="usuarios.php" class="text-xs font-card1 m-3">
                                            Usuarios con Acceso</a>
                                        <div class="h5 mx-3 font-h2">
                                            <?php
                                            include "../includes/db.php";

                                            $SQL = "SELECT id FROM usuarios ORDER BY id";
                                            $dato = mysqli_query($conexion, $SQL);
                                            $fila = mysqli_num_rows($dato);

                                            echo ($fila); ?>

                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa-solid fa-user-lock fa-3x text-gray-600 mx-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                };
                ?>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-4 col-sm-6 col-12 mb-4">
                    <div class="card card-1 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <a href="departamentos.php" class="text-xs font-card1 m-3">
                                        Departamentos</a>
                                    <div class="h5 mx-3 font-h2">
                                        <?php
                                        include "../includes/db.php";

                                        $SQL = "SELECT id FROM departamentos ORDER BY id";
                                        $dato = mysqli_query($conexion, $SQL);
                                        $fila = mysqli_num_rows($dato);

                                        echo ($fila); ?>

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-layer-group fa-3x text-gray-600 mx-3" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-4 col-sm-6 col-12 mb-4">
                    <div class="card card-1 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <a href="equipos.php" class="text-xs font-card1 m-3">
                                        Equipos en Inventario</a>
                                    <div class="h5 mx-3 font-h2">
                                        <?php
                                        include "../includes/db.php";

                                        $SQL = "SELECT id FROM equipos ORDER BY id";
                                        $dato = mysqli_query($conexion, $SQL);
                                        $fila = mysqli_num_rows($dato);

                                        echo ($fila); ?>

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-computer fa-3x text-gray-600 mx-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-4 col-sm-6 col-12 mb-4">
                    <div class="card card-1 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <a href="puntos_red.php" class="text-xs font-card1 m-3">
                                        Puntos de Red</a>
                                    <div class="h5 mx-3 font-h2">
                                        <?php
                                        include "../includes/db.php";

                                        $SQL = "SELECT id FROM puntos_red ORDER BY id";
                                        $dato = mysqli_query($conexion, $SQL);
                                        $fila = mysqli_num_rows($dato);

                                        echo ($fila); ?>

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-network-wired fa-3x text-gray-600 mx-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-4 col-sm-6 col-12 mb-4">
                    <div class="card card-1 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <a href="ip_fijas.php" class="text-xs font-card1 m-3">
                                        IP Fijas Asignadas</a>
                                    <div class="h5 mx-3 font-h2">
                                        <?php
                                        include "../includes/db.php";

                                        $SQL = "SELECT id FROM ip_fijas ORDER BY id";
                                        $dato = mysqli_query($conexion, $SQL);
                                        $fila = mysqli_num_rows($dato);

                                        echo ($fila); ?>

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-ethernet fa-3x text-gray-600 mx-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-4 col-sm-6 col-12 mb-4">
                    <div class="card card-1 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <a href="acceso_routers.php" class="text-xs font-card1 m-3">
                                        Acceso a Routers</a>
                                    <div class="h5 mx-3 font-h2">
                                        <?php
                                        include "../includes/db.php";

                                        $SQL = "SELECT id FROM acceso_routers ORDER BY id";
                                        $dato = mysqli_query($conexion, $SQL);
                                        $fila = mysqli_num_rows($dato);

                                        echo ($fila); ?>

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-wifi fa-3x text-gray-600 mx-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>

</div>

<!-- End of Content Wrapper -->

</div>

<!-- End of Page Wrapper -->

<?php include '../includes/footer.php'; ?>

</html>