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
                    <h4 class="m-0 font-primary mayus col-xl-6 col-md-6 col-sm-12 col-12">Asignación de ip fijas</h4>
                    <div class="text-right col-xl-6 col-md-6 col-sm-12 col-12">
                        <?php
                        // Verifica el rol del usuario
                        if ($_SESSION['rol'] == 1) {
                        ?>

                            <button type="button" class="btn btn-agg btn-md bold mayus" title="Asignar Punto de Red" data-toggle="modal" data-target="#insert_ip_fija">
                                <i class="fa fa-plus bold"></i> Asignar IP
                            </button>
                        <?php
                        };
                        ?>

                        <button class="btn btn-infor mayus" id="btn-generar-reporte" type="button" title="Generar Reporte en PDF">
                            <i class="fa-solid fa-print"></i> Generar Reporte en PDF
                        </button>

                    </div>
                </div>
            </div>

            <ul class="list-group" id="listView" style="display: none;">
                <?php
                include "../includes/db.php";
                $result = mysqli_query($conexion, "SELECT ip_fijas.*, equipos.tipo_equipo, equipos.marca 
                FROM ip_fijas 
                LEFT JOIN equipos 
                ON ip_fijas.id_equipo = equipos.id");
                while ($fila = mysqli_fetch_assoc($result)) :
                ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 font-primary mayus"><?php echo $fila['departamento']; ?></h5>
                            <h5 class="mb-1 font-delete mayus"><?php echo $fila['ip']; ?></h5>
                            <p class="mb-1">

                                <strong>Equipo:</strong> <?php echo $fila['tipo_equipo'] . ' - ' . $fila['marca'] ?: 'N/T';  ?> <br>
                                <strong>Descripción:</strong> <?php echo $fila['descripcion'] ?: 'N/T'; ?> <br>
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
                            <a href="../includes/_ipFijas/editar_ipFija.php?id=<?php echo $fila['id'] ?>" class="btn btn-edit btn-sm" title="Editar Registro">
                                <i class="fa fa-edit "></i>
                            </a>

                            <a href="../includes/_ipFijas/eliminar_ipFija.php?id=<?php echo $fila['id'] ?> " data-nombre=" <?php echo $fila['tipo_equipo'] ?> " class="btn btn-delete btn-del btn-sm" title="Eliminar Registro">
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
                                <th class="mayus">IP</th>
                                <th class="mayus">Departamento</th>
                                <th class="mayus">Equipo</th>
                                <th class="mayus">Descripción</th>
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

                        $result = mysqli_query($conexion, "SELECT ip_fijas.*, equipos.tipo_equipo, equipos.marca 
                        FROM ip_fijas 
                        LEFT JOIN equipos 
                        ON ip_fijas.id_equipo = equipos.id");

                        while ($fila = mysqli_fetch_assoc($result)) :

                        ?>
                            <tr>
                                <td class="bold"><?php echo $fila['ip'] ?: 'N/T'; ?></td>
                                <td><?php echo $fila['departamento'] ?: 'N/T'; ?></td>
                                <td><?php echo $fila['tipo_equipo'] . ' - ' . $fila['marca'] ?: 'N/T'; ?></td>
                                <td><?php echo $fila['descripcion'] ?: 'N/T';  ?></td>
                                <td class="text-center">
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
                                    <td class="text-center">

                                        <button type="button" class="btn btn-infor btn-sm" title="Ver Registro" data-toggle="modal" data-target="#verIpFijaModal<?php echo $fila['id']; ?>">
                                            <i class="fa fa-eye"></i>
                                        </button>

                                        <?php include "../includes/_ipFijas/ver_ipFija.php"; ?>


                                        <a href="../includes/_ipFijas/editar_ipFija.php?id=<?php echo $fila['id'] ?>" class="btn btn-edit btn-sm" title="Editar Registro">
                                            <i class="fa fa-edit "></i>
                                        </a>

                                        <a href="../includes/_ipFijas/eliminar_ipFija.php?id=<?php echo $fila['id'] ?> " data-nombre=" <?php echo $fila['tipo_equipo'] ?> " class="btn btn-delete btn-del btn-sm" title="Eliminar Registro">
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
                        $(document).on("click", "#btn-generar-reporte", function() {
                            window.open("../includes/_reportes/IP_Fijas.php");
                        });
                    </script>


                    <script>
                        $('.btn-del').on('click', async function(e) {
                            e.preventDefault();

                            const href = $(this).attr('href');
                            const departamentoNombre = $(this).data('apellido');
                            const equipoNombre = $(this).data('nombre');

                            try {
                                const result = await Swal.fire({
                                    title: '¿Estás seguro?',
                                    html: `¿Deseas eliminar esta Dirección IP?`,
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
                                        text: 'La Dirección IP fue eliminado correctamente.',
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

    <?php include "../includes/_ipFijas/insert_ipFija.php"; ?>

</body>

</html>