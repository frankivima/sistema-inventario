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
                    <h4 class="m-0 font-primary mayus col-xl-6 col-md-6 col-sm-12 col-12">Lista de Departamentos (Unidades de Trabajo)</h4>
                    <div class="text-right col-xl-6 col-md-6 col-sm-12 col-12">
                        <button type="button" class="btn btn-agg btn-md bold mayus" data-toggle="modal" data-target="#insert_departamento">
                            <i class="fa fa-plus bold"></i> Agregar Departamento
                        </button>
                    </div>
                </div>
            </div>


            <ul class="list-group" id="listView" style="display: none;">
                <?php
                include "../includes/db.php";
                $result = mysqli_query($conexion, "SELECT * FROM departamentos");
                while ($fila = mysqli_fetch_assoc($result)) :
                ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 font-primary mayus"><?php echo $fila['nombre_departamento'] ?: 'N/T';  ?></h5>
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
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>


            <div id="cardView" class="card-body">
                <div class="table-responsive">
                    <table class="table-sm table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table table-comp">
                            <tr>
                                <th class="mayus" width="5%">#</th>
                                <th class="mayus" width="50%">Nombre (Unidad de Trabajo)</th>
                                <th class="mayus text-center" width="25%">Estado</th>
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
                        $result = mysqli_query($conexion, "SELECT * FROM departamentos ");
                        while ($fila = mysqli_fetch_assoc($result)) :

                        ?>
                            <tr>
                                <td width="5%"><?php echo $fila['id']; ?></td>
                                <td width="50%"><?php echo $fila['nombre_departamento']; ?></td>
                                <td class="text-center" width="25%">
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
                                    <td class="text-center" width="20%">

                                        <a href="../includes/_departamentos/editar_departamento.php?id=<?php echo $fila['id'] ?>" class="btn btn-edit btn-sm" title="Editar Registro">
                                            <i class="fa fa-edit "></i>
                                        </a>

                                        <a href="../includes/_departamentos/eliminar_departamento.php?id=<?php echo $fila['id'] ?> " data-nombre=" <?php echo $fila['nombre_departamento'] ?> " class="btn btn-delete btn-del btn-sm">
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
                            const departamentoNombre = $(this).data('nombre');

                            try {
                                const result = await Swal.fire({
                                    title: '¿Estás seguro?',
                                    html: `¿Deseas eliminar el Departamento: <span class="bold mayus" style="color: red;">${departamentoNombre}</span>?`,
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
                                        text: 'El Departamento fue eliminado correctamente.',
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

    <?php include "../includes/_departamentos/insert_departamento.php"; ?>

</body>

</html>