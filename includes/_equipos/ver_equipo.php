<?php
session_start();
error_reporting(0);
include "../db.php";

$varsesion = $_SESSION['username'];
if ($varsesion == null || $varsesion == '') {
    header("Location: ../_sesion/login.php");
    exit;
}

$id = $_GET['id'] ?? 0;
$id = intval($id); // siempre conviene sanear

$query = "
    SELECT e.*, 
           u.nombre_unidad,
           ur.nombre AS res_nombre,
           ur.apellido AS res_apellido
    FROM equipos e
    LEFT JOIN unidades u ON e.unidad_id = u.id
    LEFT JOIN usuarios_responsables ur ON e.usuarioRes_id = ur.id
    WHERE e.id = $id
    LIMIT 1
";
$resultado = mysqli_query($conexion, $query);
$fila = mysqli_fetch_assoc($resultado);

if (!$fila) {
    echo "<p class='text-danger text-center py-5'>Equipo no encontrado</p>";
    exit;
}


// Obtener actas de revisión de este equipo
$actasQuery = "SELECT * 
               FROM acta_revision 
               WHERE equipo_id = {$fila['id']}
               ORDER BY fecha_revision ASC";
$actasResult = mysqli_query($conexion, $actasQuery);


// Obtener historial de cambios del equipo
$historialQuery = "
    SELECT hc.*, u.nombre, u.apellido
    FROM historial_cambios hc
    LEFT JOIN usuarios u ON hc.usuario_id = u.id
    WHERE hc.equipo_id = {$fila['id']}
    ORDER BY hc.fecha DESC
";
$historialResult = mysqli_query($conexion, $historialQuery);



// Encargado de registro
$idEncargado = $fila['encargado_registro'];
$resEnc = mysqli_query($conexion, "SELECT nombre, apellido FROM usuarios WHERE id = $idEncargado");
$fEnc = $resEnc ? mysqli_fetch_assoc($resEnc) : null;
$nombreEncargado = $fEnc['nombre'] ?? "No disponible";
$apellidoEncargado = $fEnc['apellido'] ?? "";

// Encargado de modificación
$idEncMod = $fila['encargado_modificacion'];
$resEncMod = mysqli_query($conexion, "SELECT nombre, apellido FROM usuarios WHERE id = $idEncMod");
$fEncMod = $resEncMod ? mysqli_fetch_assoc($resEncMod) : null;
$nombreEncMod = $fEncMod['nombre'] ?? "No disponible";
$apellidoEncMod = $fEncMod['apellido'] ?? "";

?>

<style>
    .custom-badge {
        font-size: 14px;
        padding: 0.35em 0.65em;
    }

    .card-section {
        margin-bottom: 15px;
    }

    .card-section h6 {
        font-size: 14px;
    }

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
</style>

<!-- Contenido Offcanvas -->
<div class="container-fluid p-0">

    <!-- Header con Logo -->
    <div class="text-center mb-3">
        <img src="../assets/img/logo1.png" alt="Logo" class="img-fluid mb-2" style="max-height: 60px;">
        <h5 class="fw-bold font-primary">Detalles del Equipo Tecnológico</h5>
    </div>

    <?php
    function mostrarInfo($valor, $campo = 'general')
    {
        $mensajes = [
            'tipo_equipo' => 'No registrado',
            'marca' => 'No registrada',
            'modelo' => 'No registrado',
            'serial' => 'No registrado',
            'codigo_bienes' => 'No asignado',
            'procesador' => 'No especificado',
            'sistema_operativo' => 'No instalado',
            'cant_memoria' => 'No registrada',
            'almacenamiento' => 'No registrado',
            'nombre_unidad' => 'Sin información',
            'usuario_responsable' => 'Sin información',
            'ubicacion' => 'No especificada',
            'observaciones' => 'Sin observaciones',
            'estado' => 'Sin información',
            'general' => 'Sin información'
        ];

        if (empty($valor)) {
            return '<span class="badge bg-secondary text-white rounded">' . ($mensajes[$campo] ?? $mensajes['general']) . '</span>';
        }

        return $valor;
    }
    ?>

    <!-- Datos Generales -->
    <div class="card card-section shadow-sm mb-3">
        <div class="card-body">
            <h6 class="font-primary mb-3"><i class="fa fa-info-circle"></i> Datos Generales</h6>

            <dl class="row mb-0">
                <dt class="col-6 col-md-4">Unidad de Trabajo:</dt>
                <dd class="col-6 col-md-8"><?= mostrarInfo($fila['nombre_unidad'], 'nombre_unidad'); ?></dd>

                <dt class="col-6 col-md-4">Usuario Responsable:</dt>
                <dd class="col-6 col-md-8">
                    <?= mostrarInfo(
                        !empty($fila['res_nombre']) || !empty($fila['res_apellido'])
                            ? trim($fila['res_nombre'] . ' ' . $fila['res_apellido'])
                            : null,
                        'usuario_responsable'
                    ); ?>
                </dd>


                <dt class="col-6 col-md-4">Ubicación:</dt>
                <dd class="col-6 col-md-8"><?= mostrarInfo($fila['ubicacion'], 'ubicacion'); ?></dd>

                <dt class="col-6 col-md-4">Observaciones:</dt>
                <dd class="col-6 col-md-8"><?= mostrarInfo($fila['observaciones'], 'observaciones'); ?></dd>

                <dt class="col-6 col-md-4">Estado:</dt>
                <dd class="col-6 col-md-8">
                    <?php
                    $estado = $fila['estado']; // Mantener mayúsculas/minúsculas como viene
                    $estados = [
                        "Operativo" => "bg-verde text-white",
                        "En préstamo" => "bg-warning text-dark",
                        "Pendiente de revisión" => "bg-info text-dark",
                        "En reparación" => "bg-info text-dark",
                        "Dañado" => "bg-danger text-white",
                        "De baja" => "bg-secondary text-white",
                        "Disponible" => "bg-primary text-white",
                        "Inactivo" => "bg-dark text-white"
                    ];

                    $badgeClass = $estados[$estado] ?? 'bg-secondary text-white';
                    ?>
                    <span class="badge <?= $badgeClass ?> rounded custom-badge">
                        <?= mostrarInfo($estado, 'estado'); ?>
                    </span>
                </dd>

                <!-- Campos adicionales si el equipo está en préstamo -->
                <?php if ($estado === 'En préstamo'): ?>
                    <?php
                    // Obtener nombre de la unidad de destino
                    $prestamoUnidad = 'Sin información';
                    if (!empty($fila['prestamo_unidad'])) {
                        $resUnidad = mysqli_query($conexion, "SELECT nombre_unidad FROM unidades WHERE id={$fila['prestamo_unidad']}");
                        $filaUnidad = $resUnidad ? mysqli_fetch_assoc($resUnidad) : null;
                        $prestamoUnidad = $filaUnidad['nombre_unidad'] ?? 'Sin información';
                    }

                    // Obtener nombre del usuario responsable de destino
                    $prestamoUsuario = 'Sin información';
                    if (!empty($fila['prestamo_usuario'])) {
                        $resUsuario = mysqli_query($conexion, "SELECT nombre, apellido FROM usuarios_responsables WHERE id={$fila['prestamo_usuario']}");
                        $filaUsuario = $resUsuario ? mysqli_fetch_assoc($resUsuario) : null;
                        $prestamoUsuario = trim(($filaUsuario['nombre'] ?? '') . ' ' . ($filaUsuario['apellido'] ?? '')) ?: 'Sin información';
                    }
                    ?>

                    <div class="mb-2 p-3 border rounded bg-light shadow-sm d-inline-block w-100">
                        <h6 class="mb-2"><i class="fa fa-exchange-alt text-warning"></i> Equipo en Préstamo</h6>
                        <div class="d-flex align-items-center gap-4 flex-wrap">
                            <div>
                                <small class="text-muted">Unidad Destino:</small>
                                <span class="fw-bold"><?= $prestamoUnidad ?></span>
                            </div>
                            <div>
                                <small class="text-muted">Usuario Responsable:</small>
                                <span class="fw-bold"><?= $prestamoUsuario ?></span>
                            </div>
                        </div>
                    </div>


                <?php endif; ?>


            </dl>
        </div>
    </div>


    <!-- Especificaciones Técnicas -->
    <div class="card card-section shadow-sm mb-3">
        <div class="card-body">
            <h6 class="font-primary mb-3"><i class="fa fa-cogs"></i> Especificaciones Técnicas</h6>

            <dl class="row mb-0">
                <?php
                $campos = [
                    'Tipo' => 'tipo_equipo',
                    'Marca' => 'marca',
                    'Modelo' => 'modelo',
                    'Serial' => 'serial',
                    'Código de Bienes' => 'codigo_bienes'
                ];

                foreach ($campos as $label => $campo): ?>
                    <dt class="col-6 col-md-4"><?= $label ?>:</dt>
                    <dd class="col-6 col-md-8"><?= mostrarInfo($fila[$campo], $campo); ?></dd>
                <?php endforeach; ?>

                <?php if (in_array($fila['tipo_equipo'], ['Laptop', 'CPU'])): ?>
                    <hr>
                    <?php
                    $tecnicos = [
                        'Procesador' => 'procesador',
                        'Sistema Operativo' => 'sistema_operativo',
                        'Memoria RAM' => 'cant_memoria',
                        'Almacenamiento' => 'almacenamiento'
                    ];

                    foreach ($tecnicos as $label => $campo):
                        $valor = $fila[$campo] ?: '';
                        if ($campo == 'cant_memoria' && !empty($valor)) $valor .= ' GB ' . ($fila['tipo_ram'] ?: '');
                        if ($campo == 'almacenamiento' && !empty($valor)) $valor .= ' GB ' . ($fila['tipo_disco'] ?: '');
                    ?>
                        <dt class="col-6 col-md-4"><?= $label ?>:</dt>
                        <dd class="col-6 col-md-8"><?= mostrarInfo($valor, $campo); ?></dd>
                    <?php endforeach; ?>
                <?php endif; ?>
            </dl>
        </div>
    </div>


    <!-- Actas de Revisión - Vista Documentos - Colapsable -->
    <div class="card card-section shadow-sm mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="font-primary mb-0"><i class="fa fa-file-alt"></i> Actas de Revisión</h6>
            <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#actasCollapse" aria-expanded="false" aria-controls="actasCollapse">
                <i class="fa fa-chevron-down"></i>
            </button>
        </div>

        <div class="collapse" id="actasCollapse">
            <div class="card-body">
                <?php if ($actasResult && mysqli_num_rows($actasResult) > 0): ?>
                    <div class="row g-3"> <?php while ($acta = mysqli_fetch_assoc($actasResult)): ?> <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 bor-primary">
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <div> <i class="fa fa-file-pdf fa-2x text-danger mb-2"></i>
                                            <h6 class="bold mayus">Acta: #<?= $acta['id_acta'] ?></h6>
                                            <p class="mb-1"><strong>Fecha:</strong> <?= date('d-m-Y', strtotime($acta['fecha_revision'])) ?></p>
                                            <p class="mb-0"><strong>Descripción:</strong> </p>
                                            <?php
                                                $resultadoLinea = strtok($acta['resultado_revision'], "\n");
                                                $conclusionLinea = strtok($acta['conclusion_revision'], "\n");
                                                if (strlen($resultadoLinea) > 80) {
                                                    $resultadoLinea = substr($resultadoLinea, 0, 80) . '...';
                                                }
                                                if (strlen($conclusionLinea) > 80) {
                                                    $conclusionLinea = substr($conclusionLinea, 0, 80) . '...';
                                                }
                                            ?>
                                            <p class="text-muted small mb-1"> <i class="fa fa-stethoscope"></i> <?= htmlspecialchars($resultadoLinea) ?> </p>
                                            <p class="text-muted small mb-0"> <i class="fa fa-lightbulb"></i> <?= htmlspecialchars($conclusionLinea) ?> </p>
                                        </div>
                                        <div class="mt-2"> <button class="btn btn-infor btn-sm" title="VER ACTA DE REVISIÓN" onclick="window.open('../includes/_acta_revision/Acta de Revision.php?id_acta=<?php echo $acta['id_acta']; ?>')"> <i class="fa fa-eye"></i> Ver PDF </button> </div>
                                    </div>
                                </div>
                            </div> <?php endwhile; ?> </div> <?php else: ?> <p class="text-muted mb-0">No hay actas de revisión registradas para este equipo.</p> <?php endif; ?>
            </div>
        </div>
    </div>


    <!-- Historial de Cambios con Sección Colapsable -->
    <div class="card card-section shadow-sm mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="font-primary mb-0">
                <i class="fa fa-history"></i> Historial de Cambios
            </h6>
            <button class="btn btn-sm btn-outline-primary"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#historialCollapse"
                aria-expanded="false"
                aria-controls="historialCollapse">
                <i class="fa fa-chevron-down"></i>
            </button>
        </div>

        <div class="collapse" id="historialCollapse">
            <div class="card-body">
                <?php if ($historialResult && mysqli_num_rows($historialResult) > 0): ?>
                    <ul class="timeline list-unstyled">
                        <?php while ($h = mysqli_fetch_assoc($historialResult)): ?>
                            <li class="mb-4">
                                <div class="d-flex align-items-start">
                                    <span class="badge bg-primary me-2"><i class="fa fa-clock"></i></span>
                                    <div>
                                        <strong class="text-primary"><?= htmlspecialchars($h['tipo_evento']) ?></strong>
                                        <small class="text-muted d-block">
                                            <?= date('d-m-Y h:i A', strtotime($h['fecha'])) ?>
                                            | Por: <?= htmlspecialchars($h['nombre'] . ' ' . $h['apellido']) ?>
                                        </small>

                                        <?php if (!empty($h['notas'])): ?>
                                            <p class="mt-2 mb-0">
                                                <i class="fa fa-pen text-secondary"></i>
                                                <?= nl2br(htmlspecialchars($h['notas'])) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted mb-0">No hay historial de cambios registrado para este equipo.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Registro y Modificación Compacto -->
    <div class="card card-section shadow-sm">
        <div class="card-body">
            <h6 class="font-primary mb-3"><i class="fa fa-user-edit"></i> Registro y Modificación</h6>

            <dl class="row mb-0">
                <dt class="col-12 col-md-3">Registro:</dt>
                <dd class="col-12 col-md-9">
                    <?php echo $nombreEncargado . ' ' . $apellidoEncargado; ?> (<?php echo date('d-m-Y h:i A', strtotime($fila['fecha_registro'])); ?>)
                </dd>

                <dt class="col-12 col-md-3">Última Modificación:</dt>
                <dd class="col-12 col-md-9">
                    <?php if (!empty($fila['fecha_ultima_modificacion']) && $fila['fecha_ultima_modificacion'] != '0000-00-00 00:00:00'): ?>
                        <?php echo !empty($nombreEncMod) ? $nombreEncMod . ' ' . $apellidoEncMod : "-"; ?> (<?php echo date('d-m-Y h:i A', strtotime($fila['fecha_ultima_modificacion'])); ?>)
                    <?php else: ?>
                        <span class="badge bg-secondary text-white">No ha sido modificado</span>
                    <?php endif; ?>
                </dd>
            </dl>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const btnActas = document.querySelector('[data-bs-target="#actasCollapse"]');
            const iconActas = btnActas.querySelector("i");

            document.getElementById("actasCollapse").addEventListener("show.bs.collapse", () => {
                iconActas.classList.remove("fa-chevron-down");
                iconActas.classList.add("fa-chevron-up");
            });

            document.getElementById("actasCollapse").addEventListener("hide.bs.collapse", () => {
                iconActas.classList.remove("fa-chevron-up");
                iconActas.classList.add("fa-chevron-down");
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const btn = document.querySelector('[data-bs-target="#historialCollapse"]');
            const icon = btn.querySelector("i");

            document.getElementById("historialCollapse").addEventListener("show.bs.collapse", () => {
                icon.classList.remove("fa-chevron-down");
                icon.classList.add("fa-chevron-up");
            });

            document.getElementById("historialCollapse").addEventListener("hide.bs.collapse", () => {
                icon.classList.remove("fa-chevron-up");
                icon.classList.add("fa-chevron-down");
            });
        });
    </script>




</div>