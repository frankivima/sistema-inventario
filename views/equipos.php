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
                    <table class="table-sm table-hover" id="dataTableEquipos" width="100%" cellspacing="0">
                        <thead class="table table-comp">
                            <tr class="mayus">
                                <th>Cod Bienes</th>
                                <th>Unidad</th>
                                <th>Responsable</th>
                                <th class="text-center">Tipo de Equipo</th>
                                <th class="text-center">Estado</th>
                                <?php if ($_SESSION['rol'] == 1) { ?>
                                    <th class="text-center">Acciones</th>
                                <?php } ?>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>


            <script>
                $(document).ready(function() {
                    $('#dataTableEquipos').DataTable({
                        "processing": true,
                        "serverSide": true,
                        pageLength: 20, // Cantidad de registros por página
                        lengthMenu: [5, 10, 15, 20, 50], // Opciones que puede elegir el usuario
                        language: {
                            processing: "Tratamiento en curso...",
                            search: "Buscar:",
                            lengthMenu: "Mostrar _MENU_ registros",
                            info: "Mostrando del registro _START_ al _END_ de un total de _TOTAL_ registros",
                            infoEmpty: "No existen registros",
                            infoFiltered: "(filtrados de un total de _MAX_ registros)",
                            loadingRecords: "Cargando registros...",
                            zeroRecords: "No se encontraron registros",
                            emptyTable: "No hay registros disponibles",
                            paginate: {
                                first: "Primero",
                                previous: "Anterior",
                                next: "Siguiente",
                                last: "Último"
                            },
                            aria: {
                                sortAscending: ": Activar para ordenar ascendente",
                                sortDescending: ": Activar para ordenar descendente"
                            }
                        },
                        "ajax": {
                            "url": "../includes/_equipos/equipos_server.php",
                            "type": "POST",
                            "dataSrc": function(json) {
                                console.log("JSON recibido desde el servidor:", json);
                                if (!json || typeof json !== "object") {
                                    console.error("Respuesta inválida del servidor:", json);
                                    Swal.fire({
                                        title: 'Error',
                                        text: json.error || 'El servidor devolvió una respuesta inválida.',
                                        icon: 'error',
                                        confirmButtonText: 'Aceptar'
                                    });
                                    return [];
                                }
                                return json.data;
                            },
                            "error": function(xhr, error, thrown) {
                                console.error("Error al obtener los datos:", error, xhr.responseText);
                                Swal.fire({
                                    title: 'Error de conexión',
                                    text: 'No se pudo obtener la respuesta del servidor.',
                                    icon: 'error',
                                    confirmButtonText: 'Aceptar'
                                });
                            }
                        },
                        "columns": [{
                                "data": "codigo_bienes"
                            },
                            {
                                "data": "nombre_unidad"
                            },
                            {
                                "data": "usuario_responsable"
                            },
                            {
                                "data": "tipo_equipo",
                                "className": "text-center"
                            },
                            {
                                "data": "estado",
                                "className": "text-center"
                            },
                            {
                                "data": "acciones",
                                "className": "text-center",
                                "orderable": false
                            }
                        ]
                    });
                });
            </script>


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