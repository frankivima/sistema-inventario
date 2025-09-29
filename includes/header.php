<?php
error_reporting(0);
session_start();
$actualsesion = $_SESSION['username'];

if ($actualsesion == null || $actualsesion == '') {
    header("Location: ./_sesion/login.php");
}

$current = basename($_SERVER['PHP_SELF']);
?>



<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistema Gestión de IT - FASGANZ</title>


    <link rel="stylesheet" href="../css/style.css">

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="../vendor/fontawesome-free/css/all.min.css" type="text/css">
    <script src="../vendor/fontawesome-free/js/all.min.js"></script>

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link rel="stylesheet" href="../vendor/DataTables-1.13.6/css/dataTables.bootstrap5.min.css">

    <script src="../js/jquery.min.js"></script>

    <link rel="stylesheet" href="../vendor/bootstrap-5.3.2-dist/css/bootstrap.min.css">

    <link rel="icon" href="../assets/img/logo1.png" type="image/x-icon" />

    <script>
        $(document).ready(function() {
            // Inicializar tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // Abrir modal al hacer click
            $('#btnRegistrarCambio').click(function() {
                $('#modalCambioManual').modal('show');
            });

            // Atajo de teclado (opcional)
            $(document).keydown(function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'm') {
                    $('#modalCambioManual').modal('show');
                }
            });
        });
    </script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">



        <!-- Sidebar -->
        <ul class="navbar-nav custom-navbar sidebar accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-1">
                    <img src="../assets/img/logo1.png" style="max-height: 80px; padding:10px;" alt="Logo Clinica">
                </div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- INICIO -->
            <li class="nav-item <?= ($current === 'index.php') ? 'active' : '' ?>">
                <a class="nav-link" href="../views/index.php">
                    <i class="fa-solid fa-home"></i>
                    <span>Inicio</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">Interface</div>

            <!-- ACTAS DE REVISIÓN (solo un link) -->
            <li class="nav-item <?= ($current === 'acta_revision.php') ? 'active' : '' ?>">
                <a class="nav-link" href="../views/acta_revision.php">
                    <i class="fa-solid fa-file-circle-plus"></i>
                    <span>Actas de Revisión</span>
                </a>
            </li>

            <!-- INVENTARIO DE EQUIPOS (solo un link) -->
            <?php if ($_SESSION['rol'] == 1): ?>
                <li class="nav-item <?= ($current === 'equipos.php') ? 'active' : '' ?>">
                    <a class="nav-link" href="../views/equipos.php">
                        <i class="fa-solid fa-computer"></i>
                        <span>Inventario de Equipos</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- REDES (varios links → mantener collapse) -->
            <li class="nav-item <?= $isRedes ? 'active' : '' ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <i class="fa-solid fa-network-wired"></i>
                    <span>Redes</span>
                </a>
                <div id="collapsePages" class="collapse <?= $isRedes ? 'show' : '' ?>" data-parent="#accordionSidebar">
                    <div class="custom-collapse-inner py-2 rounded">
                        <a class="collapse-item <?= ($current === 'acceso_routers.php') ? 'active' : '' ?>" href="../views/acceso_routers.php">Acceso a Routers</a>
                        <a class="collapse-item <?= ($current === 'ip_fijas.php') ? 'active' : '' ?>" href="../views/ip_fijas.php">Asignación de IP</a>
                        <a class="collapse-item <?= ($current === 'puntos_red.php') ? 'active' : '' ?>" href="../views/puntos_red.php">Puntos de Red</a>
                    </div>
                </div>
            </li>


            <hr class="sidebar-divider">

            <div class="sidebar-heading">Otros</div>

            <!-- CONFIGURACIÓN (solo rol 1) -->
            <?php if ($_SESSION['rol'] == 1):
                $isConfig = in_array($current, ['usuarios.php', 'unidades.php']);
            ?>
                <li class="nav-item <?= $isConfig ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings">
                        <i class="fa-solid fa-gears"></i>
                        <span>Configuración</span>
                    </a>
                    <div id="collapseSettings" class="collapse" data-parent="#accordionSidebar">
                        <div class="custom-collapse-inner py-2 rounded">
                            <a class="collapse-item <?= ($current === 'usuarios.php') ? 'active' : '' ?>" href="../views/usuarios.php">
                                Usuarios
                            </a>
                            <a class="collapse-item <?= ($current === 'unidades.php') ? 'active' : '' ?>" href="../views/unidades.php">
                                Unidades
                            </a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>

            <!-- ACERCA DE -->
            <li class="nav-item <?= ($current === 'acerca.php') ? 'active' : '' ?>">
                <a class="nav-link" href="../views/acerca.php">
                    <i class="fa fa-question-circle"></i>
                    <span>Acerca de</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->



        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">


            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-light topbar mb-4 static-top shadow">

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Botón dinámico para registrar cambio -->
                        <!-- Botón flotante -->
                        <li class="nav-item d-flex align-items-center mr-3">
                            <button class="btn btn-gradient btn-circle" id="btnRegistrarCambio"
                                data-toggle="tooltip" data-placement="bottom" title="Registrar cambio"
                                data-target="#modalCambioManual">
                                <i class="fas fa-plus"></i>
                            </button>
                        </li>


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">

                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <img class="img-profile rounded-circle mr-2" src="../assets/img/profile.png">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo $_SESSION['username']; ?></span>

                            </a>

                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right text-light shadow" aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                    Salir
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>


                <!-- End of Topbar -->
                <?php  //endwhile;
                ?>

                <?php include "salir.php"; ?>

                <?php include "../includes/_equipos/modal_cambioManual.php"; ?>


                <script>
                    // Opcional: cerrar el collapse al seleccionar un link
                    function closeSidebarCollapse(selector) {
                        const collapse = document.querySelector(selector);
                        if (collapse && collapse.classList.contains('show')) {
                            $(collapse).collapse('hide');
                        }
                    }
                </script>



</body>

</html>