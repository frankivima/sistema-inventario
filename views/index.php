<?php
// Seguridad de sesiones
session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion == '') {
    header("Location: ../includes/_sesion/login.php");
    die();
}

include '../includes/header.php';

// Asegúrate de que los datos del usuario estén disponibles en la sesión
if (isset($_SESSION['nombre']) && isset($_SESSION['apellido'])) {
    $nombreUsuario = $_SESSION['nombre'];
    $apellidoUsuario = $_SESSION['apellido'];
} else {
    // Si no están disponibles, puedes mostrar el nombre de usuario
    $nombreUsuario = $_SESSION['username'];
    $apellidoUsuario = ''; // Debes adaptar esto según la estructura de tu sesión
}
?>

<!-- Estilos modernos -->
<style>
    .dashboard-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .dashboard-icon {
        font-size: 2rem;
        padding: 12px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dashboard-count {
        font-size: 1.6rem;
        font-weight: 600;
        margin-top: 5px;
    }

    .dashboard-title {
        font-size: 0.95rem;
        font-weight: 500;
        color: #6c757d;
        text-decoration: none;
    }

    .dashboard-title:hover {
        color: #4e73df;
    }

    /* Línea de tiempo estilo moderno */


    .timeline li {
        position: relative;
        padding-left: 25px;
    }

    .timeline li::before {
        content: "";
        position: absolute;
        left: 8px;
        top: 0;
        width: 6px;
        height: 100%;
        background-color: #dee2e6;
        border-radius: 3px;
    }

    .timeline li:last-child::before {
        height: 10px;
    }

    .timeline .event-card {
        background-color: #f8f9fc;
        padding: 12px 15px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease-in-out;
    }

    .timeline .event-card:hover {
        background-color: #eef2ff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
</style>

<?php
// ===============================
// Datos para gráfico: equipos por unidad
// ===============================
include "../includes/db.php";

// ===============================
// Función para contar registros
// ===============================
function contar($conexion, $tabla)
{
    $sql = "SELECT COUNT(*) AS total FROM $tabla";
    $res = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_assoc($res);
    return $fila['total'];
}

// ===============================
// Datos gráficos: Estados y Tipos
// ===============================
$sqlEstados = "SELECT estado, COUNT(*) AS total FROM equipos GROUP BY estado";
$resEstados = mysqli_query($conexion, $sqlEstados);
$labelsEstados = [];
$valuesEstados = [];
while ($row = mysqli_fetch_assoc($resEstados)) {
    $labelsEstados[] = ucfirst($row['estado']);
    $valuesEstados[] = $row['total'];
}

$sqlTipos = "SELECT DISTINCT tipo_equipo FROM equipos";
$resTipos = mysqli_query($conexion, $sqlTipos);
$labelsTipos = [];
while ($row = mysqli_fetch_assoc($resTipos)) {
    $labelsTipos[] = $row['tipo_equipo'];
}

// Matriz tipo vs estado
$tipoEstadoData = [];
foreach ($labelsTipos as $tipo) {
    $tipoEstadoData[$tipo] = [];
    foreach ($labelsEstados as $estado) {
        $sql = "SELECT COUNT(*) AS total FROM equipos WHERE tipo_equipo='$tipo' AND estado='" . strtolower($estado) . "'";
        $res = mysqli_query($conexion, $sql);
        $fila = mysqli_fetch_assoc($res);
        $tipoEstadoData[$tipo][$estado] = (int)$fila['total'];
    }
}

// ===============================
// Historial de cambios (solo nota, tipo_evento, modo, fecha)
// ===============================
$sqlHistorial = "
SELECT 
    h.tipo_evento,
    h.modo,
    h.notas,
    h.fecha,
    h.usuario_id,
    h.equipo_id,
    u.nombre AS nombre,
    u.apellido AS apellido,
    e.tipo_equipo,
    e.modelo,
    e.marca,
    e.codigo_bienes
FROM historial_cambios h
LEFT JOIN usuarios_responsables u ON h.usuario_id = u.id
LEFT JOIN equipos e ON h.equipo_id = e.id
ORDER BY h.fecha DESC
LIMIT 5
";

$resultHistorial = mysqli_query($conexion, $sqlHistorial);


$historial = [];
while ($row = mysqli_fetch_assoc($resultHistorial)) {
    $historial[] = $row;
}

?>



<!-- Begin Page Content -->
<div class="container-fluid px-5">
    <h1 class="mt-4 font-primary">¡Bienvenido <?php echo $nombreUsuario . ' ' . $apellidoUsuario; ?>!</h1>
    <br>

    <!-- Panel Administrativo -->
    <div class="row">

        <!-- Usuarios -->
        <?php if ($_SESSION['rol'] == 1): ?>
            <div class="col-xl-3 col-md-6 col-12 mb-4">
                <div class="card dashboard-card p-3">
                    <div class="d-flex align-items-center">
                        <div class="dashboard-icon me-3">
                            <i class="fa-solid fa-user-lock"></i>
                        </div>
                        <div>
                            <a href="usuarios.php" class="dashboard-title d-block">Usuarios</a>
                            <div class="dashboard-count"><?= contar($conexion, 'usuarios') ?></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Unidades -->
        <div class="col-xl-3 col-md-6 col-12 mb-4">
            <div class="card dashboard-card p-3">
                <div class="d-flex align-items-center">
                    <div class="dashboard-icon me-3 bg-success bg-opacity-10 font-infor">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div>
                        <a href="unidades.php" class="dashboard-title d-block">Unidades</a>
                        <div class="dashboard-count"><?= contar($conexion, 'unidades') ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipos -->
        <div class="col-xl-3 col-md-6 col-12 mb-4">
            <div class="card dashboard-card p-3">
                <div class="d-flex align-items-center">
                    <div class="dashboard-icon me-3 bg-info bg-opacity-10 font-primary">
                        <i class="fa-solid fa-computer"></i>
                    </div>
                    <div>
                        <a href="equipos.php" class="dashboard-title d-block">Equipos</a>
                        <div class="dashboard-count"><?= contar($conexion, 'equipos') ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Puntos de Red -->
        <div class="col-xl-3 col-md-6 col-12 mb-4">
            <div class="card dashboard-card p-3">
                <div class="d-flex align-items-center">
                    <div class="dashboard-icon me-3 bg-primary bg-opacity-10 font-delete">
                        <i class="fa-solid fa-network-wired"></i>
                    </div>
                    <div>
                        <a href="actas_revision.php" class="dashboard-title d-block">Actas de Revisión</a>
                        <div class="dashboard-count"><?= contar($conexion, 'acta_revision') ?></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Distribución compacta con sparklines + Historial -->
    <!-- Gráficos y Historial -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card dashboard-card p-3">
                <h6>Distribución de Equipos por Tipo y Estado</h6>
                <div class="row mb-3">
                    <div class="col-12">
                        <canvas id="tipoEstadoChart" style="height:100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card dashboard-card p-3" style="height:100%;">
                <h6>Historial Reciente</h6>
                <ul class="timeline list-unstyled" style="max-height:400px; overflow-y:auto;">
                    <?php foreach ($historial as $h): ?>
                        <li class="mb-3">
                            <div class="event-card">
                                <div class="mb-1 d-flex justify-content-between align-items-center">
                                    <strong><?= htmlspecialchars($h['tipo_evento']) ?></strong>
                                    <span class="badge bg-secondary"><?= htmlspecialchars($h['modo']) ?></span>
                                </div>
                                <small class="text-muted d-block mb-1">
                                    <?= date('d-m-Y h:i A', strtotime($h['fecha'])) ?> | <?= htmlspecialchars($h['nombre'] . ' ' . $h['apellido']) ?>
                                </small>
                                <div class="mb-1">
                                    <i class="fa-solid fa-desktop me-1"></i>
                                    <?= htmlspecialchars($h['tipo_equipo'] . ' ' . $h['marca'] . ' ' . $h['modelo'] . ' (' . end(explode('-', $h['codigo_bienes'])) . ')') ?>
                                </div>
                                <p class="mb-0"><i class="fa fa-pen text-secondary me-1"></i><?= nl2br(htmlspecialchars($h['notas'])) ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Page Content -->

<!-- Chart.js para sparklines -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Stacked Bar Chart - Tipos x Estado
    const estados = <?= json_encode($labelsEstados) ?>;

    // Mapa de colores fijos por estado
    const estadoColorsMap = {
        "Operativo": "#28a745", // verde
        "En préstamo": "#ffc107", // amarillo
        "Dañado": "#dc3545", // rojo
        "Disponible": "#007bff", // azul
        "Otro": "#6c757d" // gris por defecto
    };

    // Convertimos los estados en colores según el mapa
    const estadoColors = estados.map(e => estadoColorsMap[e] || estadoColorsMap["Otro"]);

    const tipos = <?= json_encode($labelsTipos) ?>;
    const tipoEstadoData = <?= json_encode($tipoEstadoData) ?>;

    const datasets = estados.map((estado, i) => ({
        label: estado,
        data: tipos.map(t => tipoEstadoData[t][estado]),
        backgroundColor: estadoColors[i]
    }));

    new Chart(document.getElementById('tipoEstadoChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: tipos,
            datasets: datasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true,
                    beginAtZero: true
                }
            }
        }
    });
</script>


<!-- End of Content Wrapper -->

</div>

<!-- End of Page Wrapper -->

<?php include '../includes/footer.php'; ?>

</html>