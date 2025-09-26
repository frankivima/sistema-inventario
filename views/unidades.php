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

    <style>
        #dataTableEquipos tbody td {
            vertical-align: middle;
            padding: 2px 0px;
        }

        #dataTableEquipos thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        #dataTableEquipos tbody tr:hover {
            background-color: #f1f3f5;
            cursor: pointer;
        }
    </style>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4 mt-5 mx-3">
            <div class="card-header py-3">
                <div class="row">
                    <h4 class="m-0 font-primary mayus col-xl-6 col-md-6 col-sm-12 col-12">Lista de Unidades de Trabajo</h4>
                    <div class="text-right col-xl-6 col-md-6 col-sm-12 col-12">
                        <button type="button" class="btn btn-agg btn-md bold mayus" data-toggle="modal" data-target="#insert_unidad">
                            <i class="fa fa-plus bold"></i> Agregar Unidad
                        </button>
                    </div>
                </div>
            </div>


            <ul class="list-group" id="listView" style="display: none;">
                <?php
                include "../includes/db.php";
                $result = mysqli_query($conexion, "SELECT * FROM unidades");
                while ($fila = mysqli_fetch_assoc($result)) :
                ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 font-primary mayus"><?php echo $fila['nombre_unidad'] ?: 'N/T';  ?></h5>
                            <p class="mb-1">

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

                            <a href="../includes/_departamentos/editar_departamento.php?id=<?php echo $fila['id'] ?>" class="btn btn-edit btn-sm" title="Editar Registro">
                                <i class="fa fa-edit "></i>
                            </a>

                            <a href="../includes/_departamentos/eliminar_departamento.php?id=<?php echo $fila['id'] ?> " data-nombre=" <?php echo $fila['nombre_departamento'] ?> " class="btn btn-delete btn-del btn-sm">
                                <i class="fa fa-trash "></i>
                            </a>

                            <a href="usuarios_por_unidad.php?unidad_id=<?= $fila['id'] ?>" class="btn btn-sm btn-info">
                                <i class="fa fa-users"></i> Ver Usuarios
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
                                <th class="mayus">Unidad de Trabajo</th>
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
                        $result = mysqli_query($conexion, "SELECT * FROM unidades ORDER BY nombre_unidad ASC");
                        while ($fila = mysqli_fetch_assoc($result)) :

                        ?>
                            <tr>
                                <td>
                                    <div>
                                        <strong><?php echo $fila['nombre_unidad']; ?></strong><br>
                                        <small class="text-muted"></small><br>
                                        <span class="badge <?php
                                                            if ($fila['estado'] == 'Activo') {
                                                                echo 'bg-verde text-white';
                                                            } else {
                                                                echo 'bg-secondary text-white'; // Puedes establecer un color predeterminado para otros estados
                                                            }
                                                            ?> rounded">
                                            <?php echo $fila['estado']; ?>
                                        </span>
                                    </div>
                                </td>
                                <?php
                                // Verifica el rol del usuario
                                if ($_SESSION['rol'] == 1) {
                                ?>
                                    <td class="text-center">

                                        <button class="btn btn-sm btn-infor" data-bs-toggle="offcanvas" data-bs-target="#offcanvasUsuarios" data-unidad-id="<?= $fila['id'] ?>" data-unidad-nombre="<?= $fila['nombre_unidad'] ?>">
                                            <i class="fa fa-users"></i>
                                        </button>

                                        <a href="../includes/_unidades/editar_unidad.php?id=<?php echo $fila['id'] ?>" class="btn btn-edit btn-sm" title="Editar Registro">
                                            <i class="fa fa-edit "></i>
                                        </a>

                                        <a href="../includes/_unidades/eliminar_unidad.php?id=<?php echo $fila['id'] ?> " data-nombre=" <?php echo $fila['nombre_unidad'] ?> " class="btn btn-delete btn-del btn-sm">
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

                    <!-- Offcanvas Usuarios -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasUsuarios" aria-labelledby="offcanvasUsuariosLabel">
                        <div class="offcanvas-header">
                            <h5 id="offcanvasUsuariosLabel" class="mb-0">Usuarios Responsables</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 id="offcanvasUnidadNombre" class="mayus bold mb-0">Unidad: </h6>
                                <button class="btn btn-sm btn-agg" id="btnAgregarUsuario">
                                    <i class="fa fa-plus"></i> Agregar Usuario
                                </button>
                            </div>
                            <div id="offcanvasBodyUsuarios">
                                <p class="text-center text-muted">Cargando...</p>
                            </div>
                        </div>
                    </div>

                    <style>
                        /* Responsive width */
                        #offcanvasUsuarios {
                            width: 30%;
                        }

                        @media (max-width: 992px) {
                            #offcanvasUsuarios {
                                width: 60%;
                            }
                        }

                        @media (max-width: 768px) {
                            #offcanvasUsuarios {
                                width: 100%;
                            }
                        }

                        /* Scroll interno */
                        #offcanvasUsuarios .offcanvas-body {
                            overflow-y: auto;
                            max-height: 100vh;
                            padding: 1rem;
                        }
                    </style>

                    <!-- Modal Agregar Usuario -->
                    <div class="modal fade" id="modalAgregarUsuario" tabindex="-1" aria-labelledby="modalAgregarUsuarioLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="formAgregarUsuario">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalAgregarUsuarioLabel">Agregar Usuario Responsable</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="unidad_id" id="unidad_id_modal">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="label-span" for="nombre">Nombre:</label>
                                                    <input type="text" name="nombre" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="label-span" for="apellido">Apellido:</label>
                                                    <input type="text" name="apellido" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="label-span" for="cargo">Cargo:</label>
                                            <input type="text" name="cargo" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-agg mayus bold">Agregar</button>
                                        <button type="button" class="btn btn-delete mayus bold" data-bs-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <!-- Modal Editar Usuario -->
                    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mayus" id="modalEditarUsuarioLabel">Editar Usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body" id="modalBodyEditarUsuario">
                                    <!-- Aquí cargaremos el formulario vía AJAX -->
                                    <p>Cargando...</p>
                                </div>
                            </div>
                        </div>
                    </div>



                    <script>
                        const body = document.getElementById('offcanvasBodyUsuarios');

                        body.addEventListener('click', async function(e) {
                            // Eliminar usuario
                            if (e.target.closest('.btn-outline-danger')) {
                                const btn = e.target.closest('.btn-outline-danger');
                                const row = btn.closest('.list-group-item');
                                const nombreUsuario = row.querySelector('strong').textContent;
                                const userId = row.dataset.userId;
                                const unidadId = row.dataset.unidadId;

                                const result = await Swal.fire({
                                    title: '¿Estás seguro?',
                                    html: `¿Deseas eliminar al usuario: <span class="bold mayus" style="color: red;">${nombreUsuario}</span>?`,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#034D81',
                                    cancelButtonColor: '#8A021B',
                                    confirmButtonText: 'Sí, eliminar!',
                                    cancelButtonText: 'Cancelar',
                                });

                                if (result.isConfirmed) {
                                    window.location.href = `../includes/_usuariosRes/eliminar_usuarioRes.php?id=${userId}&unidad_id=${unidadId}`;
                                }
                            }

                            // Editar usuario
                            if (e.target.closest('.btn-outline-primary')) {
                                const btn = e.target.closest('.btn-outline-primary');
                                const row = btn.closest('.list-group-item');
                                const userId = row.dataset.userId;

                                fetch(`../includes/_usuariosRes/editar_usuarioRes.php?id=${userId}`)
                                    .then(res => res.text())
                                    .then(html => {
                                        document.getElementById('modalBodyEditarUsuario').innerHTML = html;
                                        var modal = new bootstrap.Modal(document.getElementById('modalEditarUsuario'));
                                        modal.show();
                                    })
                                    .catch(err => console.error('Error cargando formulario:', err));
                            }
                        });
                    </script>




                    <script>
                        // Cargar usuarios en el offcanvas
                        document.querySelectorAll('[data-bs-toggle="offcanvas"]').forEach(btn => {
                            btn.addEventListener('click', function() {
                                const unidadId = this.dataset.unidadId;
                                const unidadNombre = this.dataset.unidadNombre;
                                document.getElementById('offcanvasUnidadNombre').innerText = `Unidad: ${unidadNombre}`;
                                document.getElementById('unidad_id_modal').value = unidadId;

                                const body = document.getElementById('offcanvasBodyUsuarios');
                                body.innerHTML = '<p>Cargando...</p>';

                                fetch(`../includes/_usuariosRes/usuarios_server.php?unidad_id=${unidadId}`)
                                    .then(res => res.text())
                                    .then(html => body.innerHTML = html)
                                    .catch(err => body.innerHTML = `<p class="text-danger">Error cargando usuarios.</p>`);
                            });
                        });

                        // Abrir modal Agregar Usuario
                        document.getElementById('btnAgregarUsuario').addEventListener('click', function() {
                            const modal = new bootstrap.Modal(document.getElementById('modalAgregarUsuario'));
                            modal.show();
                        });

                        // Guardar usuario vía AJAX
                        document.getElementById('formAgregarUsuario').addEventListener('submit', function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);

                            fetch('../includes/_usuariosRes/insert_usuarioRes.php', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Usuario agregado correctamente');
                                        // Recargar usuarios
                                        const unidadId = document.getElementById('unidad_id_modal').value;
                                        fetch(`../includes/_usuariosRes/usuarios_server.php?unidad_id=${unidadId}`)
                                            .then(res => res.text())
                                            .then(html => document.getElementById('offcanvasBodyUsuarios').innerHTML = html);
                                        // Cerrar modal
                                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregarUsuario'));
                                        modal.hide();
                                        this.reset();
                                    } else {
                                        alert('Error: ' + data.message);
                                    }
                                })
                                .catch(err => alert('Error al agregar usuario'));
                        });
                    </script>

                    <script>
                        $('.btn-del').on('click', async function(e) {
                            e.preventDefault();

                            const href = $(this).attr('href');
                            const unidadNombre = $(this).data('nombre');

                            try {
                                const result = await Swal.fire({
                                    title: '¿Estás seguro?',
                                    html: `¿Deseas eliminar la Unidad: <span class="bold mayus" style="color: red;">${unidadNombre}</span>?`,
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
                                        text: 'La Unidad de Trabajo fue eliminada correctamente.',
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

    <?php include "../includes/_unidades/insert_unidad.php"; ?>

</body>

</html>