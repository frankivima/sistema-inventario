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
$query = "SELECT * FROM equipos WHERE id = $id LIMIT 1";

/* $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "
SELECT e.*, u.nombre AS nombre_unidad
    FROM equipos e
    LEFT JOIN unidades u ON e.unidad_id = u.id
    WHERE e.id = $id
    LIMIT 1
";
 */

$resultado = mysqli_query($conexion, $query);
$fila = mysqli_fetch_assoc($resultado);

if (!$fila) {
    echo "<p class='text-danger text-center py-5'>Equipo no encontrado</p>";
    exit;
}

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
        <h5 class="fw-bold text-primary">Detalles del Equipo Tecnológico</h5>
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
            <h6 class="text-primary mb-3"><i class="fa fa-info-circle"></i> Datos Generales</h6>

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
            <h6 class="text-primary mb-3"><i class="fa fa-cogs"></i> Especificaciones Técnicas</h6>

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



    <!-- Registro y Modificación Compacto -->
    <div class="card card-section shadow-sm">
        <div class="card-body">
            <h6 class="text-primary mb-3"><i class="fa fa-user-edit"></i> Registro y Modificación</h6>

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