<?php
// Seguridad de sesiones
session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion = '') {

    header("Location: ../includes/_sesion/login.php");
    die();
}
?>

<?php include "../includes/header.php"; ?>

<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4 mt-5">
            <div class="card-header py-3">
                <div class="row">
                    <h4 class="m-0 font-primary mayus col-xl-6 col-md-6 col-sm-12 col-12">Identificación de puntos de red</h4>
                    <div class="text-right col-xl-6 col-md-6 col-sm-12 col-12">
                        <?php
                        // Verifica el rol del usuario
                        if ($_SESSION['rol'] == 1) {
                        ?>

                            <button type="button" class="btn btn-agg btn-md bold mayus" title="Asignar Punto de Red" data-toggle="modal" data-target="#insert_puntored">
                                <i class="fa fa-plus bold"></i> Agregar Punto de Red
                            </button>

                            <a href="../views/generar_reportes_puntoRed.php" class="btn btn-md btn-infor mayus" title="Generar Reportes">
                                <i class="fa-solid fa-print "></i> Generar Reportes en PDF
                            </a>

                            <!-- Botón para abrir la página de reporte -->
                            <a href="mapas_puntosred.php" class="btn btn-delete btn-md bold mayus" title="Ver en Mapa">
                                <i class="fa fa-file-lines bold"></i> Ver Mapa
                            </a>

                        <?php
                        };
                        ?>
                    </div>
                </div>
            </div>


            <ul class="list-group" id="listView" style="display: none;">
                <?php
                include "../includes/db.php";
                $result = mysqli_query($conexion, "SELECT * FROM puntos_red ORDER BY patch_panel ASC, puerto_pp ASC");
                while ($fila = mysqli_fetch_assoc($result)) :
                ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 font-primary mayus"><?php echo $fila['departamento'] ?: 'N/T'; ?></h5>
                            <p class="mb-1">

                                <strong>Patch Panel:</strong> <?php echo $fila['patch_panel'] ?: 'N/T'; ?> <strong>Puerto:</strong> <?php echo $fila['puerto_pp'] ?: 'N/T'; ?> <br>
                                <strong>Switches:</strong> <?php echo $fila['switches'] ?: 'N/T'; ?> <strong>Puerto:</strong> <?php echo $fila['puerto_sw'] ?: 'N/T'; ?> <br>
                                <strong>Estado:</strong> <span class="badge <?php
                                                                            if ($fila['estado'] == 'Activo') {
                                                                                echo 'bg-verde text-white';
                                                                            } else {
                                                                                echo 'bg-secondary text-white'; // Puedes establecer un color predeterminado para otros estados
                                                                            }
                                                                            ?> rounded">
                                    <?php echo $fila['estado']; ?>
                                </span>
                            </p>
                        </div>
                        <div class="btn-group">
                            <a href="../includes/_puntosred/editar_puntored.php?id=<?php echo $fila['id'] ?>" class="btn btn-edit btn-sm" title="Editar Registro">
                                <i class="fa fa-edit "></i>
                            </a>

                            <a href="../includes/_puntosred/eliminar_puntored.php?id=<?php echo $fila['id'] ?> " data-nombre=" <?php echo $fila['tipo_equipo'] ?> " data-apellido=" <?php echo $fila['departamento'] ?> " class="btn btn-delete btn-del btn-sm" title="Eliminar Registro">
                                <i class="fa fa-trash "></i>
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
                                <th class="mayus">Departamento</th>
                                <th class="mayus text-center">Patch Panel</th>
                                <th class="mayus text-center">PP</th>
                                <th class="mayus text-center">Switch</th>
                                <th class="mayus text-center">Sw</th>
                                <th class="text-center mayus">Estado</th>
                                <?php
                                // Verifica el rol del usuario
                                if ($_SESSION['rol'] == 1) {
                                ?>
                                    <th class="text-center mayus">Acciones</th>
                                <?php
                                };
                                ?>
                            </tr>
                        </thead>

                        <?php

                        include "../includes/db.php";
                        $result = mysqli_query($conexion, "SELECT * FROM puntos_red ORDER BY patch_panel ASC, puerto_pp ASC");

                        while ($fila = mysqli_fetch_assoc($result)) :

                        ?>
                            <tr>
                                <td width="20%"><?php echo $fila['departamento']; ?></td>
                                <td width="12%" class="text-center"><?php echo $fila['patch_panel'] ?: 'N/T';  ?></td>
                                <td width="5%" class="text-center"><?php echo $fila['puerto_pp'] ?: 'N/T';  ?></td>
                                <td width="10%" class="text-center"><?php echo $fila['switches'] ?: 'N/T';  ?></td>
                                <td width="5%" class="text-center"><?php echo $fila['puerto_sw'] ?: 'N/T';  ?></td>
                                <td class="text-center" width="15%">
                                    <span class="badge <?php
                                                        if ($fila['estado'] == 'Activo') {
                                                            echo 'bg-verde text-white';
                                                        } else {
                                                            echo 'bg-secondary text-white'; // Puedes establecer un color predeterminado para otros estados
                                                        }
                                                        ?> rounded">
                                        <?php echo $fila['estado']; ?>
                                    </span>
                                </td>
                                <?php
                                // Verifica el rol del usuario
                                if ($_SESSION['rol'] == 1) {
                                ?>
                                    <td class="text-center" width="15%">

                                        <button type="button" class="btn btn-infor btn-sm" title="Ver Registro" data-toggle="modal" data-target="#verPuntoRedModal<?php echo $fila['id']; ?>">
                                            <i class="fa fa-eye"></i>
                                        </button>

                                        <?php include "../includes/_puntosred/ver_puntored.php"; ?>


                                        <a href="../includes/_puntosred/editar_puntored.php?id=<?php echo $fila['id'] ?>" class="btn btn-edit btn-sm" title="Editar Registro">
                                            <i class="fa fa-edit "></i>
                                        </a>

                                        <a href="../includes/_puntosred/eliminar_puntored.php?id=<?php echo $fila['id'] ?> " data-nombre=" <?php echo $fila['tipo_equipo'] ?> " data-apellido=" <?php echo $fila['departamento'] ?> " class="btn btn-delete btn-del btn-sm" title="Eliminar Registro">
                                            <i class="fa fa-trash "></i>
                                        </a>

                                    </td>
                                <?php
                                };
                                ?>
                            </tr>
                        <?php endwhile; ?>

                        </tbody>
                    </table>


                    <script>
                        $('.btn-del').on('click', async function(e) {
                            e.preventDefault();

                            const href = $(this).attr('href');
                            const departamentoNombre = $(this).data('apellido');
                            const equipoNombre = $(this).data('nombre');

                            try {
                                const result = await Swal.fire({
                                    title: '¿Estás seguro?',
                                    html: `¿Deseas eliminar el Punto de Red seleccioando perteneciente a el Departamento de <span class="bold mayus" style="color: red;">${departamentoNombre}</span>?`,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#034D81',
                                    cancelButtonColor: '#8A021B',
                                    confirmButtonText: 'Si, eliminar!',
                                    cancelButtonText: 'Cancelar!',
                                });

                                if (result.isConfirmed) {
                                    await Swal.fire({
                                        title: 'Eliminado!',
                                        text: 'Punto de Red fue eliminado correctamente.',
                                        confirmButtonColor: '#034D81',
                                        icon: 'success',
                                        timer: 2000,
                                    });

                                    document.location.href = href;
                                }
                            } catch (error) {
                                console.error('Error al mostrar el cuadro de diálogo:', error);
                            }
                        });
                    </script>


                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php include "../includes/footer.php"; ?>

    <?php include "../includes/_puntosred/insert_puntored.php"; ?>

</body>

</html>