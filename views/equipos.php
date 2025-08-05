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
                    <h4 class="m-0 font-primary mayus col-xl-6 col-md-6 col-sm-12 col-12">Inventario de Equipos Tecnológicos</h4>
                    <div class="text-right col-xl-6 col-md-6 col-sm-12 col-12">
                        <?php
                        // Verifica el rol del usuario
                        if ($_SESSION['rol'] == 1) {
                        ?>

                            <button type="button" class="btn btn-agg btn-md bold mayus" title="Insertar Nuevo Equipo al Inventario" data-toggle="modal" data-target="#insert_equipo">
                                <i class="fa fa-plus bold"></i> Agregar Equipo
                            </button>

                            <a href="../views/generar_reportes_inventario.php" class="btn btn-infor mayus" title="Generar Reportes">
                                <i class="fa-solid fa-print "></i> Generar Reportes en PDF
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
                $result = mysqli_query($conexion, "SELECT * FROM equipos ORDER BY codigo_bienes ASC");
                while ($fila = mysqli_fetch_assoc($result)) :

                    // Obtener los últimos segmentos después del quinto guion
                    $codigo_bienes = '';
                    if (isset($fila['codigo_bienes'])) {
                        $codigo_partes = explode('-', $fila['codigo_bienes']);
                        if (count($codigo_partes) > 1) {
                            $codigo_bienes = implode('-', array_slice($codigo_partes, -3));
                        }
                    }

                ?>
                    <li class="list-group-item">
                        <div class="container mt-3">
                            <h5 class="mb-1 font-primary mayus"><?php echo $fila['departamento'] ?: 'N/T'; ?></h5>
                            <h4 class="mb-1 font-delete mayus" style="font-size: 12pt;"><?php echo $codigo_bienes ?: 'Sin Codigo de Bienes'; ?></h4>
                            <p class="mb-1">
                                <strong>Responsable:</strong> <?php echo $fila['usuario_responsable'] ?: 'N/T'; ?> <br>
                                <strong>Tipo Equipo:</strong> <?php echo $fila['tipo_equipo'] ?: 'N/T'; ?> <br>
                                <!-- Mostrar solo hasta aquí inicialmente -->
                            </p>

                            <!-- Botón para mostrar más detalles -->
                            <button class="btn btn-infor btn-sm mt-2 toggle-details">
                                <i class="fa fa-plus bold"></i> Ver más detalles
                            </button>

                            <!-- Contenedor oculto para detalles adicionales -->
                            <div class="additional-info" style="display: none;">
                                <hr>
                                <p>
                                    <strong>Marca:</strong> <?php echo $fila['marca'] ?: 'N/T'; ?> <br>
                                    <strong>Modelo:</strong> <?php echo $fila['modelo'] ?: 'N/T'; ?> <br>
                                    <strong>Serial:</strong> <?php echo $fila['serial'] ?: 'N/T'; ?> <br>

                                    <!-- Mostrar campos específicos para Laptop y CPU -->
                                
                                    <?php if ($fila['tipo_equipo'] == 'Laptop' || $fila['tipo_equipo'] == 'CPU') : ?>
                                        <strong>Procesador:</strong> <?php echo $fila['procesador'] ?: 'N/T'; ?> <br>
                                        <strong>Sistema Operativo:</strong> <?php echo $fila['sistema_operativo'] ?: 'N/T'; ?> <br>
                                        <strong>Memoria RAM:</strong> <?php echo $fila['cant_memoria'] ?: 'N/T'; ?> GB <?php echo $fila['tipo_ram'] ?: 'N/T'; ?> <br>
                                        <strong>Almacenamiento:</strong> <?php echo $fila['almacenamiento'] ?: 'N/T'; ?> GB. <?php echo $fila['tipo_disco'] ?: 'N/T'; ?> <br>

                                    <?php endif; ?>
                                


                                <strong>Ubicación:</strong> <?php echo $fila['ubicacion'] ?: 'N/T'; ?> <br>
                                <strong>Observación:</strong> <?php echo $fila['observacion'] ?: 'N/T'; ?> <br>
                                </p>
                            </div>

                            <hr>
                            <!-- Estado y botones de acción siempre visibles -->
                            <div class="row mb-3">
                                <div class="col-8">
                                    <strong>Estado:</strong>
                                    <span class="badge <?php echo $fila['estado'] == 'Activo' ? 'bg-verde text-white' : 'bg-secondary text-white'; ?> rounded">
                                        <?php echo $fila['estado']; ?>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="btn-group">
                                        <a href="../includes/_equipos/editar_equipo.php?id=<?php echo $fila['id'] ?>" class="btn btn-edit btn-sm" title="Editar Registro">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="../includes/_equipos/eliminar_equipo.php?id=<?php echo $fila['id'] ?>" data-nombre="<?php echo $fila['tipo_equipo'] ?>" data-apellido="<?php echo $fila['departamento'] ?>" class="btn btn-delete btn-del btn-sm" title="Eliminar Registro">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>

            <script>
                $(document).ready(function() {
                    // Mostrar/ocultar detalles al hacer clic en el botón
                    $('.toggle-details').click(function() {
                        var $details = $(this).siblings('.additional-info');
                        $details.slideToggle();
                    });
                });
            </script>




            <div id="cardView" class="card-body">
                <div class="table-responsive">
                    <table class="table-sm table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table table-comp">
                            <tr>
                                <th class="mayus">Cod Bienes</th>
                                <th class="mayus">Departamento</th>
                                <th class="mayus">Responsable</th>
                                <th class="mayus text-center">Tipo de Equipo</th>
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
                        $result = mysqli_query($conexion, "SELECT * FROM equipos ORDER BY codigo_bienes ASC");
                        while ($fila = mysqli_fetch_assoc($result)) :

                            // Obtener los últimos segmentos después del quinto guion
                            $codigo_bienes = '';
                            if (isset($fila['codigo_bienes'])) {
                                $codigo_partes = explode('-', $fila['codigo_bienes']);
                                if (count($codigo_partes) > 1) {
                                    $codigo_bienes = implode('-', array_slice($codigo_partes, -3));
                                }
                            }
                        ?>
                            <tr>
                                <td class="bold" width="15%"><?php echo $codigo_bienes ?: 'N/T'; ?></td>
                                <td width="20%"><?php echo $fila['departamento'] ?: 'N/T'; ?></td>
                                <td width="20%"><?php echo $fila['usuario_responsable'] ?: 'N/T'; ?></td>
                                <td class="text-center" width="15%"><?php echo $fila['tipo_equipo'] ?: 'N/T'; ?></td>
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
                                    <td class="text-center">

                                        <button type="button" class="btn btn-infor btn-sm" title="Ver Registro" data-toggle="modal" data-target="#verEquipoModal<?php echo $fila['id']; ?>">
                                            <i class="fa fa-eye"></i>
                                        </button>

                                        <?php include "../includes/_equipos/ver_equipo.php"; ?>


                                        <a href="../includes/_equipos/editar_equipo.php?id=<?php echo $fila['id'] ?>" class="btn btn-edit btn-sm" title="Editar Registro">
                                            <i class="fa fa-edit "></i>
                                        </a>

                                        <a href="../includes/_equipos/eliminar_equipo.php?id=<?php echo $fila['id'] ?> " data-nombre=" <?php echo $fila['tipo_equipo'] ?> " data-apellido=" <?php echo $fila['departamento'] ?> " class="btn btn-delete btn-del btn-sm" title="Eliminar Registro">
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
                            window.open("../includes/_reportes/Inventario_Equipos.php");
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
                                    html: `¿Deseas eliminar <span class="bold mayus" style="color: red;">${equipoNombre}</span> seleccionado, perteneciente al Departamento de <span class="bold mayus" style="color: red;">${departamentoNombre}</span>?`,
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
                                        text: 'El Equipo fue eliminado correctamente.',
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

    <?php include "../includes/_equipos/insert_equipo.php"; ?>

</body>

</html>