<?php
include "../db.php";

$user_id = intval($_GET['id']);
$result = mysqli_query($conexion, "SELECT * FROM usuarios_responsables WHERE id = $user_id");

if ($user = mysqli_fetch_assoc($result)) {
?>
    <form action="../includes/_usuariosRes/actualizar_usuarioRes.php" method="POST" id="formEditarUsuario">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($user['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Apellido</label>
            <input type="text" name="apellido" class="form-control" value="<?= htmlspecialchars($user['apellido']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Cargo</label>
            <input type="text" name="cargo" class="form-control" value="<?= htmlspecialchars($user['cargo']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Unidad</label>
            <select name="unidad_id" class="form-select" required>
                <?php
                $unidades = mysqli_query($conexion, "SELECT * FROM unidades ORDER BY nombre_unidad ASC");
                while ($u = mysqli_fetch_assoc($unidades)) {
                    $selected = ($u['id'] == $user['unidad_id']) ? 'selected' : '';
                    echo "<option value='{$u['id']}' $selected>{$u['nombre_unidad']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3 text-end">
            <button type="submit" class="btn btn-agg">Guardar Cambios</button>
        </div>
    </form>
<?php
} else {
    echo "<p class='text-danger'>Usuario no encontrado.</p>";
}
?>