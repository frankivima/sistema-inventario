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
$query = "SELECT e.*, u.nombre_unidad 
          FROM equipos e
          LEFT JOIN unidades u ON e.unidad_id = u.id
          WHERE e.id = $id
          LIMIT 1";
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
                <dd class="col-6 col-md-8"><?= mostrarInfo($fila['usuario_responsable'], 'usuario_responsable'); ?></dd>

                <dt class="col-6 col-md-4">Ubicación:</dt>
                <dd class="col-6 col-md-8"><?= mostrarInfo($fila['ubicacion'], 'ubicacion'); ?></dd>

                <dt class="col-6 col-md-4">Observaciones:</dt>
                <dd class="col-6 col-md-8"><?= mostrarInfo($fila['observaciones'], 'observaciones'); ?></dd>

                <dt class="col-6 col-md-4">Estado:</dt>
                <dd class="col-6 col-md-8">
                    <?php
                    $estado = strtolower($fila['estado']);
                    $badgeClass = ($estado == 'activo') ? 'bg-verde text-white' : 'bg-secondary text-white';
                    ?>
                    <span class="badge <?= $badgeClass ?> rounded custom-badge">
                        <?= mostrarInfo($fila['estado'], 'estado'); ?>
                    </span>
                </dd>
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


    <!-- Actas de Revisión - Vista Documentos -->
    <div class="card card-section shadow-sm mb-3">
        <div class="card-body">
            <h6 class="font-primary mb-3"><i class="fa fa-file-alt"></i> Actas de Revisión</h6>

            <?php if ($actasResult && mysqli_num_rows($actasResult) > 0): ?>
                <div class="row g-3">
                    <?php while ($acta = mysqli_fetch_assoc($actasResult)): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 bor-primary">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <i class="fa fa-file-pdf fa-2x text-danger mb-2"></i>
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
                                        <p class="text-muted small mb-1">
                                            <i class="fa fa-stethoscope"></i> <?= htmlspecialchars($resultadoLinea) ?>
                                        </p>
                                        <p class="text-muted small mb-0">
                                            <i class="fa fa-lightbulb"></i> <?= htmlspecialchars($conclusionLinea) ?>
                                        </p>

                                    </div>
                                    <div class="mt-2">
                                        <button class="btn btn-infor btn-sm" 
                                                title="VER ACTA DE REVISIÓN" 
                                                onclick="window.open('../includes/_acta_revision/Acta de Revision.php?id_acta=<?php echo $acta['id_acta']; ?>')">
                                                <i class="fa fa-eye"></i> Ver PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="text-muted mb-0">No hay actas de revisión registradas para este equipo.</p>
            <?php endif; ?>
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


</div>