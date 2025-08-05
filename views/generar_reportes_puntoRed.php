<?php
// Seguridad de sesiones
session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

?>

<?php include "../includes/header.php"; ?>

<body id="page-top">

    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <h4 class="m-0 font-primary mayus col-xl-12 col-md-12 col-sm-12 col-12"><i class="fa-solid fa-print"></i> Generar Reporte en PDF</h4>
                </div>
            </div>

            <div class="card-body">
                <!-- Formulario para selección de reporte -->
                <form id="reportForm" method="POST" target="_blank">

                    <div class="form-row align-items-center">

                        <div class="col-md-2"></div>

                        <div class="form-group col-md-3 mx-4">
                            <label for="departamento" class="label-span mayus">Departamento: </label>
                            <select class="form-select" id="departamento" name="departamento" onchange="checkFormValidity()">
                                <option value="">--Selecciona un departamento--</option>
                                <option value="TODAS">Todos los Departamentos</option>
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

                        <div class="col-md-3">
                            <div class="card-deck">
                                <div class="card shadow">
                                    <button type="button" id="generateReportBtn" class="btn btn-infor mayus p-3" onclick="submitForm('../includes/_reportes/Puntos_Red.php')" disabled>
                                        <i class="fas fa-diagram-successor"></i> Generar Reporte en PDF
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2"></div>

                    </div>

                </form>

            </div>

            <script>
                // Función para enviar el formulario a la URL especificada
                function submitForm(url) {
                    // Obtener el formulario
                    var form = document.getElementById('reportForm');
                    // Establecer la URL de destino del formulario
                    form.action = url;
                    // Enviar el formulario
                    form.submit();
                }

                // Función para verificar la validez del formulario y habilitar el botón si es válido
                function checkFormValidity() {
                    var departamento = document.getElementById('departamento').value;
                    var generateReportBtn = document.getElementById('generateReportBtn');

                    // Habilitar el botón si ambos campos están seleccionados
                    if (departamento) {
                        generateReportBtn.removeAttribute('disabled');
                    } else {
                        generateReportBtn.setAttribute('disabled', 'disabled');
                    }
                }
            </script>

            <hr>

        </div>
    </div>

    </div>
    <!-- End of Main Content -->

    <?php include "../includes/footer.php"; ?>


</body>

</html>