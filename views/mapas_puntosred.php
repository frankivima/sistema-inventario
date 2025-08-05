<?php
session_start();
error_reporting(E_ALL);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion = '') {
    header("Location: ../includes/_sesion/login.php");
    die();
}

include("../includes/db.php");

$patchPanel1 = array_fill(1, 24, '');
$patchPanel2 = array_fill(1, 24, '');
$switches1 = array_fill(1, 24, '');
$switches2 = array_fill(1, 24, '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : '';
    $show_all_ports = isset($_POST['show_all_ports']) && $_POST['show_all_ports'] == 'on' ? true : false;

    if ($show_all_ports) {
        $query_patch_panel_1 = "SELECT puerto_pp FROM puntos_red WHERE patch_panel = 1";
        $query_patch_panel_2 = "SELECT puerto_pp FROM puntos_red WHERE patch_panel = 2";
        $query_switches_1 = "SELECT puerto_sw FROM puntos_red WHERE switches = 1";
        $query_switches_2 = "SELECT puerto_sw FROM puntos_red WHERE switches = 2";
    } else {
        $query_patch_panel_1 = "SELECT puerto_pp FROM puntos_red WHERE patch_panel = 1 AND departamento = '$departamento'";
        $query_patch_panel_2 = "SELECT puerto_pp FROM puntos_red WHERE patch_panel = 2 AND departamento = '$departamento'";
        $query_switches_1 = "SELECT puerto_sw FROM puntos_red WHERE switches = 1 AND departamento = '$departamento'";
        $query_switches_2 = "SELECT puerto_sw FROM puntos_red WHERE switches = 2 AND departamento = '$departamento'";
    }

    $result_patch_panel_1 = mysqli_query($conexion, $query_patch_panel_1);
    $result_patch_panel_2 = mysqli_query($conexion, $query_patch_panel_2);
    $result_switches_1 = mysqli_query($conexion, $query_switches_1);
    $result_switches_2 = mysqli_query($conexion, $query_switches_2);

    $patchPanel1 = array_fill(1, 24, '');
    $patchPanel2 = array_fill(1, 24, '');
    $switches1 = array_fill(1, 24, '');
    $switches2 = array_fill(1, 24, '');

    while ($row = mysqli_fetch_assoc($result_patch_panel_1)) {
        $patchPanel1[$row['puerto_pp']] = 'X';
    }

    while ($row = mysqli_fetch_assoc($result_patch_panel_2)) {
        $patchPanel2[$row['puerto_pp']] = 'X';
    }

    while ($row = mysqli_fetch_assoc($result_switches_1)) {
        $switches1[$row['puerto_sw']] = 'X';
    }

    while ($row = mysqli_fetch_assoc($result_switches_2)) {
        $switches2[$row['puerto_sw']] = 'X';
    }

    mysqli_close($conexion);
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
                    <h4 class="m-0 font-primary mayus col-xl-12 col-md-12 col-sm-12 col-12">Identificadores del servidor</h4>
                </div>
            </div>

            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-row align-items-center">
                        <div class="form-group col-xl-6 col-md-6 col-sm-6 col-6">
                            <label for="departamento" class="label-span mayus">Departamento: </label>
                            <select class="form-select" id="departamento" name="departamento">
                                <option value="">--Selecciona un departamento--</option>
                                <?php
                                include("../includes/db.php");
                                $sql = "SELECT * FROM departamentos ORDER BY nombre_departamento ASC";
                                $resultado = mysqli_query($conexion, $sql);
                                while ($consulta = mysqli_fetch_array($resultado)) {
                                    echo '<option value="' . $consulta['nombre_departamento'] . '">' . $consulta['nombre_departamento'] . '</option>';
                                }
                                ?>

                            </select>

                        </div>

                        <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                            <input type="checkbox" id="show_all_ports" name="show_all_ports">
                            <label for="show_all_ports">Mostrar Todos los Puertos</label>
                            <button type="submit" id="generarReporteBtn" class="btn btn-agg mayus mx-3">Ver Puertos en Mapa</button>
                        </div>

                    </div>
                </form>
            </div>


            <hr>

            <div id="cardView" class="card-body">
                <div class="table-responsive">
                    <table class="table-sm table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table table-comp">
                            <tr>
                                <th></th> <!-- Celda vacía para el encabezado -->
                                <?php for ($i = 1; $i <= 24; $i++) : ?>
                                    <th> <?php echo $i; ?></th> <!-- Columnas de puertos -->
                                <?php endfor; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="table-comp bold mayus">Patch Panel 1</td>
                                <?php foreach ($patchPanel1 as $puerto) : ?>
                                    <td class="text-center bold mayus <?php echo $puerto === 'X' ? 'cell-red' : ''; ?>"><?php echo $puerto; ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="table-comp bold mayus">Patch Panel 2</td>
                                <?php foreach ($patchPanel2 as $puerto) : ?>
                                    <td class="text-center bold mayus <?php echo $puerto === 'X' ? 'cell-red' : ''; ?>"><?php echo $puerto; ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="table-comp bold mayus">Switches 1</td>
                                <?php foreach ($switches1 as $puerto) : ?>
                                    <td class="text-center bold mayus <?php echo $puerto === 'X' ? 'cell-red' : ''; ?>"><?php echo $puerto; ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="table-comp bold mayus">Switches 2</td>
                                <?php foreach ($switches2 as $puerto) : ?>
                                    <td class="text-center bold mayus <?php echo $puerto === 'X' ? 'cell-red' : ''; ?>"><?php echo $puerto; ?></td>
                                <?php endforeach; ?>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>

            <hr>


        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php include "../includes/footer.php"; ?>

</body>

</html>