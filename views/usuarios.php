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
        <div class="card shadow mb-4 mt-5 mx-3">
            <div class="card-header py-3">

                <div class="row">
                    <h4 class="m-0 font-primary mayus col-xl-6 col-md-6 col-sm-12 col-12">Lista de Usuarios</h4>
                    <div class="text-right col-xl-6 col-md-6 col-sm-12 col-12">
                        <button type="button" class="btn btn-agg btn-md bold mayus" data-toggle="modal" data-target="#user">
                            <i class="fa fa-user-plus"></i> Agregar Usuario
                        </button>
                    </div>
                </div>

            </div>


            <!-- Vista Modo Lista - Para Celulares -->

            <ul class="list-group" id="listView" style="display: none;">
                <?php
                include "../includes/db.php";
                $result = mysqli_query($conexion, "SELECT * FROM usuarios");
                while ($fila = mysqli_fetch_assoc($result)) :
                ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 font-primary mayus"><?php echo $fila['nombre'] . ' ' . $fila['apellido'] ?: 'N/T'; ?></h5>
                            <p class="mb-1">

                                <strong>Usuario:</strong> <?php echo $fila['username'] ?: 'N/T';  ?> <br>
                                <strong>Rol:</strong> <?php echo $fila['rol'] ?: 'N/T';  ?>
                            </p>
                        </div>
                        <div class="btn-group">
                            <a class="btn btn-edit btn-sm mx-2" href="../includes/_user/editar_user.php?id=<?php echo $fila['id'] ?>">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="../includes/_user/eliminar_user.php?id=<?php echo $fila['id'] ?>" class="btn btn-delete btn-sm btn-del">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>



            <!-- Vista Modo Tabla - Para Dispositivos mas grandes -->

            <div id="cardView" class="card-body">
                <div class="table-responsive">
                    <table class="table-sm table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table table-comp">
                            <tr>
                                <th class="mayus">Nombre / Apellido</th>
                                <th class="mayus text-center">Usuario</th>
                                <th class="mayus text-center">Rol</th>
                                <th class="text-center mayus">Acciones</th>
                            </tr>
                        </thead>

                        <?php

                        include "../includes/db.php";
                        $result = mysqli_query($conexion, "SELECT  * FROM usuarios");
                        while ($fila = mysqli_fetch_assoc($result)) :

                        ?>
                            <tr>
                                <td><?php echo $fila['nombre'] . ' ' . $fila['apellido'] ?: 'N/T'; ?></td>
                                <td class="text-center"><?php echo $fila['username'] ?: 'N/T'; ?></td>
                                <td class="text-center"><?php echo $fila['rol'] ?: 'N/T'; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-edit btn-sm" href="../includes/_user/editar_user.php?id=<?php echo $fila['id'] ?> ">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="../includes/eliminar_user.php?id=<?php echo $fila['id'] ?> " class="btn btn-delete btn-sm btn-del">
                                        <i class="fa fa-trash "></i>
                                    </a>
                                </td>
                            </tr>


                        <?php endwhile; ?>
                        <?php
                        //}

                        ?>
                        </tbody>
                    </table>



                    <script>
                        $('.btn-del').on('click', function(e) {
                            e.preventDefault();
                            const href = $(this).attr('href')

                            Swal.fire({
                                title: 'Estas seguro de eliminar este usuario?',
                                text: "¡No podrás revertir esto!!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#034D81',
                                cancelButtonColor: '#8A021B',
                                confirmButtonText: 'Si, eliminar!',
                                cancelButtonText: 'Cancelar!',
                            }).then((result) => {
                                if (result.value) {
                                    if (result.isConfirmed) {
                                        Swal.fire(
                                            'Eliminado!',
                                            'El usuario fue eliminado.',
                                            '#034D81',
                                            'success'
                                        )
                                    }

                                    document.location.href = href;
                                }
                            })

                        })
                    </script>

                </div>
            </div>
        </div>


    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php include "../includes/footer.php"; ?>

    <?php include "../includes/_user/insert_user.php"; ?>

</body>

</html>