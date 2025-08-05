<?php
// Seguridad de sesiones
session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion = '') {

    header("Location: ../includes/_sesion/login.php");
    die();
}

// Asegúrate de que los datos del usuario estén disponibles en la sesión
if (isset($_SESSION['user_id'])) {
    $idUsuario = $_SESSION['user_id'];
} else {
    // Si no están disponibles, puedes mostrar el nombre de usuario
    $nombreUsuario = $_SESSION['username'];
}


?>

<?php include "../includes/header.php"; ?>

<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4 mt-5 mx-3">
            <div class="card-header py-3">
                <div class="row">
                    <h4 class="m-0 font-primary mayus col-xl-6 col-md-6 col-sm-12 col-12">ACTA DE REVISIÓN DE EQUIPOS</h4>
                    <div class="text-right col-xl-6 col-md-6 col-sm-12 col-12">
                        <button type="button" class="btn btn-agg btn-md bold mayus" data-toggle="modal" data-target="#insert_actaRevision">
                            <i class="fa fa-plus bold"></i> Realizar Acta de Revisión
                        </button>
                    </div>
                </div>
            </div>


            <ul class="list-group" id="listView" style="display: none;">
                <?php
                include "../includes/db.php";
                $result = mysqli_query($conexion, "SELECT * FROM acta_revision");
                while ($fila = mysqli_fetch_assoc($result)) :

                    $fecha_revision_formateada = date('d/m/Y', strtotime($fila['fecha_revision']));
                ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 font-primary mayus">FORMATO REVISIóN DE EQUIPOS Nº<?php echo $fila['id_acta'] ?: 'N/T';  ?></h5>

                            <h5 class="mb-1 font-delete mayus" style="font-size: 12pt;"><?php echo $fila['unidad_trabajo'] . ' - ' . $fecha_revision_formateada;  ?></h5>

                            <p><?php echo $fila['descripcion_equipo'] ?: 'N/T';  ?> </p>
 
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-infor btn-sm" title="VER ACTA DE REVISIÓN" onclick="window.open('../includes/_acta_revision/Acta de Revision.php?id_acta=<?php echo $fila['id_acta']; ?>')"><i class="fa-solid fa-print"></i></button>

                            <a href="../includes/_acta_revision/editar_actaRevision.php?id_acta=<?php echo $fila['id_acta'] ?>" class="btn btn-edit btn-sm" title="EDITAR REGISTRO">
                                <i class="fa fa-edit "></i>
                            </a>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>


            <div id="cardView" class="card-body">
                <div class="table-responsive">
                    <table class="table-sm table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table table-comp">
                            <tr>
                                <th class="mayus">Nº</th>
                                <th class="mayus">Fecha</th>
                                <th class="mayus">Unidad de Trabajo</th>
                                <th class="mayus">Responsable(s) de Uso</th>

                                <?php
                                // Verifica el rol del usuario
                                if ($_SESSION['rol'] == 1) {
                                ?>
                                    <th class="text-center mayus" width="20%">Acciones</th>
                                <?php
                                };
                                ?>
                            </tr>
                        </thead>

                        <?php

                        include "../includes/db.php";
                        $result = mysqli_query($conexion, "SELECT * FROM acta_revision ");
                        while ($fila = mysqli_fetch_assoc($result)) :

                            $fecha_formateada = date("d/m/Y", strtotime($fila['fecha_revision']));

                        ?>
                            <tr>
                                <td><?php echo $fila['id_acta']; ?></td>
                                <td><?php echo $fecha_formateada; ?></td>
                                <td><?php echo $fila['unidad_trabajo']; ?></td>
                                <td><?php echo $fila['responsable_uso']; ?></td>

                                <?php
                                // Verifica el rol del usuario
                                if ($_SESSION['rol'] == 1) {
                                ?>
                                    <td class="text-center" width="20%">
                                        <button class="btn btn-infor btn-sm" title="VER ACTA DE REVISIÓN" onclick="window.open('../includes/_acta_revision/Acta de Revision.php?id_acta=<?php echo $fila['id_acta']; ?>')"><i class="fa-solid fa-print"></i></button>

                                        <a href="../includes/_acta_revision/editar_actaRevision.php?id_acta=<?php echo $fila['id_acta'] ?>" class="btn btn-edit btn-sm" title="EDITAR REGISTRO">
                                            <i class="fa fa-edit "></i>
                                        </a>

                                    </td>

                                <?php
                                };
                                ?>
                            </tr>
                        <?php endwhile; ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php include "../includes/footer.php"; ?>

    <?php include "../includes/_acta_revision/insert_actaRevision.php"; ?>

</body>

</html>