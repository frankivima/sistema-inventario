<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Gestion de Inventario - FASGANZ</title>

    <script src="../vendor/SweetAlert2/js/sweetalert2.all.min.js"></script>
    <script src="../vendor/JQuery/jquery-3.7.1.min.js"></script>

    <link rel="icon" href="../assets/img/logo1.png" type="image/x-icon" />

</head>

<body>

</body>

</html>

<?php

require_once("db.php");

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        //casos de registros

        case 'acceso_user';
            acceso_user();
            break;

        case 'editar_user':
            editar_user();
            break;

        case 'insert_unidad':
            insert_unidad();
            break;

        case 'editar_unidad':
            editar_unidad();
            break;

        case 'insert_equipo':
            insert_equipo();
            break;

        case 'editar_equipo':
            editar_equipo();
            break;

        case 'insert_puntored':
            insert_puntored();
            break;

        case 'editar_puntored':
            editar_puntored();
            break;

        case 'insert_ip_fija':
            insert_ip_fija();
            break;

        case 'editar_ip_fija':
            editar_ip_fija();
            break;

        case 'insert_accesoRouter':
            insert_accesoRouter();
            break;

        case 'editar_accesoRouter':
            editar_accesoRouter();
            break;

        case 'insert_actaRevision':
            insert_actaRevision();
            break;

        case 'editar_actaRevision':
            editar_actaRevision();
            break;
    }
}


function acceso_user()
{
    include("db.php");
    extract($_POST);

    // Verifica si los campos de usuario y contraseña no están vacíos
    if (empty($username) || empty($password)) {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, completa todos los campos',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#034D81',
        }).then(function() {
            location.assign('./_sesion/login.php');
        });
        </script>";
        return;
    }

    $username = $conexion->real_escape_string($username);
    $password = $conexion->real_escape_string($password);
    session_start();
    $_SESSION['username'] = $username;

    $consulta = "SELECT id, nombre, apellido, rol FROM usuarios WHERE username='$username' AND password='$password'";
    $resultado = mysqli_query($conexion, $consulta);
    $filas = mysqli_fetch_array($resultado);

    if (isset($filas['rol'])) {

        $_SESSION['user_id'] = $filas['id'];
        $_SESSION['nombre'] = $filas['nombre'];
        $_SESSION['apellido'] = $filas['apellido'];
        $_SESSION['rol'] = $filas['rol'];

        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: 'Inicio de sesión exitoso. Redirigiendo...',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#034D81',
            timer: 3000,
        }).then(function() {
            location.assign('../views/index.php');
        });
        </script>";
    } else {
        if (empty($filas['id'])) {
            $mensaje = "Usuario o contraseña incorrectos. Por favor, verifica tus credenciales.";
        } elseif (empty($filas['rol'])) {
            $mensaje = "Usuario sin rol asignado. Comunícate con el administrador del sistema.";
        } else {
            $mensaje = "Contraseña incorrecta. Por favor, verifica tu contraseña.";
        }

        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '$mensaje',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#034D81',
        }).then(function() {
            location.assign('./_sesion/login.php');
        });
        </script>";
        session_destroy();
    }
}


function editar_user()
{
    include "db.php";
    extract($_POST);
    $consulta = "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido', username = '$username', password = '$password',
     rol ='$rol' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo "<script>
                 Swal.fire({
                     icon: 'success',
                     title: 'Éxito',
                     text: 'El registro fue actualizado correctamente.',
                     confirmButtonText: 'Aceptar',
            confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/usuarios.php');
                 });
                 </script>";
    } else {
        echo "<script>
                 Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'Error al realizar la modificación. Por favor, verifique los datos e inténtelo nuevamente.',
                     confirmButtonText: 'Aceptar',
            confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/departamentos.php');
                 });
                 </script>";
    }
}



function insert_unidad()
{
    include "db.php";
    extract($_POST);

    // Verificar si la cédula ya existe en la tabla 'pacientes'
    $consulta_verificar = "SELECT * FROM unidades WHERE nombre_unidad = '$nombre_unidad'";
    $resultado_verificar = mysqli_query($conexion, $consulta_verificar);

    if (mysqli_num_rows($resultado_verificar) > 0) {
        // La cédula ya existe, muestra un mensaje de error con SweetAlert
        echo "<script>
             Swal.fire({
                 icon: 'error',
                 title: 'Error',
                 text: 'Esta Unidad de Trabajo ya se encuentra registrada. No se puede realizar la inserción.',
                 confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
             }).then(function() {
                 location.assign('../views/unidades.php');
             });
             </script>";
    } else {

        $consulta = "INSERT INTO unidades (nombre_unidad, estado, fecha_registro, encargado_registro)
                     VALUES ('$nombre_unidad', '$estado', '$fecha_registro', '$encargado_registro')";
        $resultado = mysqli_query($conexion, $consulta);

        if ($resultado) {
            // Éxito: la inserción se realizó correctamente con SweetAlert
            echo "<script>
                 Swal.fire({
                     icon: 'success',
                     title: 'Éxito',
                     text: 'El registro fue actualizado correctamente.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/unidades.php');
                 });
                 </script>";
        } else {
            // Error en la inserción con SweetAlert
            echo "<script>
                 Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'Error al realizar la inserción. Por favor, verifique los datos e inténtelo nuevamente.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/unidades.php');
                 });
                 </script>";
        }
    }
}

function editar_unidad()
{
    include "db.php";
    extract($_POST);

    // Verificar si la cédula ya existe en la tabla 'pacientes'
    $consulta_verificar = "SELECT * FROM unidades WHERE nombre_unidad = '$nombre_unidad' AND id != $id";
    $resultado_verificar = mysqli_query($conexion, $consulta_verificar);

    if (mysqli_num_rows($resultado_verificar) > 0) {
        // La cédula ya existe, muestra un mensaje de error con SweetAlert
        echo "<script>
             Swal.fire({
                 icon: 'error',
                 title: 'Error',
                 text: 'Esta Unidad de Trabajo ya se encuentra registrada. No se puede realizar la inserción.',
                 confirmButtonText: 'Aceptar',
            confirmButtonColor: '#034D81',
             }).then(function() {
                 location.assign('../views/unidades.php');
             });
             </script>";
    } else {

        // Construye la consulta SQL
        $consulta = "UPDATE unidades SET nombre_unidad = '$nombre_unidad', estado = '$estado' WHERE id = '$id' ";

        // Ejecuta la consulta SQL
        $resultado = mysqli_query($conexion, $consulta);

        // Verifica si la consulta se ejecutó correctamente
        if ($resultado) {
            echo "<script>
                 Swal.fire({
                title: 'Éxito',
                text: 'La unidad de ($nombre_unidad) fue actualizada correctamente.',
                icon: 'success',
                closeOnClickOutside: false,
                closeOnEsc: false,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
                content: {
                    element: 'p',
                    attributes: {
                        innerHTML: 'La Unidad de ($nombre_unidad) fue actualizada correctamente.'
                    }
                }
            }).then(function() {
                location.assign('../views/unidades.php');
            });
        </script>";
        } else {
            echo "<script>
                 Swal.fire({
                title: 'Error',
                text: 'Hubo un error al actualizar el registro',
                icon: 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
            }).then(function() {
                location.assign('../views/unidades.php');
            });
        </script>";
        }
    }
}



function insert_equipo()
{
    include "db.php";
    extract($_POST);

    // Verificar si el código_bien ya existe en la tabla
    $consulta_verificacion = "SELECT codigo_bienes FROM equipos WHERE (codigo_bienes = '$codigo_bienes' AND codigo_bienes IS NOT NULL AND codigo_bienes <> '') OR (codigo_bienes IS NULL AND '$codigo_bienes' IS NULL)";
    $resultado_verificacion = mysqli_query($conexion, $consulta_verificacion);

    // Si se encontró un equipo con el mismo código_bien, mostrar un mensaje de error y detener la inserción
    if (mysqli_num_rows($resultado_verificacion) > 0) {
        echo "<script>
             Swal.fire({
                 icon: 'error',
                 title: 'Error',
                 text: 'El código de bien ya existe en la base de datos. Por favor, verifique los datos.',
                 confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
             }).then(function() {
                 location.assign('../views/equipos.php');
             });
             </script>";
        return; // Detener la ejecución de la función
    }

    // Si no se encontró un equipo con el mismo código_bien, proceder con la inserción
    $consulta = "INSERT INTO equipos (unidad_id, usuarioRes_id, ubicacion, tipo_equipo, marca, modelo, serial, codigo_bienes, procesador, tipo_ram, cant_memoria, tipo_disco, almacenamiento, sistema_operativo, observaciones, estado, prestamo_unidad, prestamo_usuario, fecha_registro, encargado_registro)
                 VALUES ('$unidad_id', '$usuarioRes_id', '$ubicacion', '$tipo_equipo', '$marca', '$modelo', '$serial', '$codigo_bienes', '$procesador', '$tipo_ram', '$cant_memoria', '$tipo_disco', '$almacenamiento', '$sistema_operativo', '$observaciones', '$estado', '$prestamo_unidad', '$prestamo_usuario', '$fecha_registro', '$encargado_registro')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        // Éxito: la inserción se realizó correctamente con SweetAlert
        echo "<script>
             Swal.fire({
                 icon: 'success',
                 title: 'Éxito',
                 text: 'El Equipo ha sido registrado en el inventario correctamente.',
                 confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
             }).then(function() {
                 location.assign('../views/equipos.php');
             });
             </script>";
    } else {
        // Error en la inserción con SweetAlert
        echo "<script>
             Swal.fire({
                 icon: 'error',
                 title: 'Error',
                 text: 'Error al realizar la inserción. Por favor, verifique los datos e inténtelo nuevamente.',
                 confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
             }).then(function() {
                 location.assign('../views/equipos.php');
             });
             </script>";
    }
}

/* function editar_equipo()
{
    include "db.php";
    extract($_POST);

    // Verificar si el código_bien ya existe en la tabla
    $consulta_verificacion = "SELECT COUNT(*) AS cantidad FROM equipos WHERE codigo_bienes = '$codigo_bienes' AND id != '$id'";
    $resultado_verificacion = mysqli_query($conexion, $consulta_verificacion);

    // Obtener el número de filas con el mismo código_bien
    $fila_verificacion = mysqli_fetch_assoc($resultado_verificacion);
    $cantidad = $fila_verificacion['cantidad'];

    // Si ya existe al menos un registro con el mismo código_bien y éste no está vacío, mostrar un mensaje de error y detener la inserción
    if ($cantidad > 0 && !empty($codigo_bienes)) {
        echo "<script>
         Swal.fire({
             icon: 'error',
             title: 'Error',
             text: 'El código de bien ya existe en la base de datos. Por favor, verifique los datos.',
             confirmButtonText: 'Aceptar',
            confirmButtonColor: '#034D81',
         }).then(function() {
             location.assign('../views/equipos.php');
         });
         </script>";
        return; // Detener la ejecución de la función
    }



    $consulta = "UPDATE equipos SET unidad_id = '$unidad_id', usuarioRes_id = '$usuarioRes_id', ubicacion = '$ubicacion', observaciones = '$observaciones', tipo_equipo = '$tipo_equipo', marca = '$marca', modelo = '$modelo', serial = '$serial', codigo_bienes = '$codigo_bienes', procesador = '$procesador', tipo_ram = '$tipo_ram', cant_memoria = '$cant_memoria', tipo_disco = '$tipo_disco', almacenamiento = '$almacenamiento', fecha_ultima_modificacion = '$fecha_ultima_modificacion', encargado_modificacion = '$encargado_modificacion', estado = '$estado', prestamo_unidad = '$prestamo_unidad', prestamo_usuario = '$prestamo_usuario'  WHERE id = '$id' ";

    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo "<script>
                 Swal.fire({
                title: 'Éxito',
                text: 'El Equipo fue actualizado correctamente.',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
                icon: 'success',
                closeOnClickOutside: false,
                closeOnEsc: false,
                content: {
                    element: 'p',
                    attributes: {
                        innerHTML: 'El Equipo fue actualizado correctamente.'
                    }
                }
            }).then(function() {
                location.assign('../views/equipos.php');
            });
        </script>";
    } else {
        echo "<script>
                 Swal.fire({
                title: 'Error',
                text: 'Hubo un error al actualizar el registro',
                icon: 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
            }).then(function() {
                location.assign('../views/equipos.php');
            });
        </script>";
    }
} */


/* function editar_equipo()
{
    include "db.php";
    session_start();

    extract($_POST);
    $idUsuario = $_SESSION['user_id'] ?? 0;

    // Obtener datos actuales del equipo
    $sql_actual = "SELECT * FROM equipos WHERE id = '$id'";
    $res_actual = mysqli_query($conexion, $sql_actual);
    $equipo_actual = mysqli_fetch_assoc($res_actual);

    // Verificar si el código_bienes ya existe en otro registro
    $consulta_verificacion = "SELECT COUNT(*) AS cantidad FROM equipos WHERE codigo_bienes = '$codigo_bienes' AND id != '$id'";
    $resultado_verificacion = mysqli_query($conexion, $consulta_verificacion);
    $fila_verificacion = mysqli_fetch_assoc($resultado_verificacion);
    if ($fila_verificacion['cantidad'] > 0 && !empty($codigo_bienes)) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El código de bien ya existe en la base de datos.',
                confirmButtonText: 'Aceptar'
            }).then(()=>{ location.assign('../views/equipos.php'); });
        </script>";
        return;
    }

    // Detectar cambios comparando valores actuales con los enviados
    $campos = ['unidad_id', 'usuarioRes_id', 'ubicacion', 'observaciones', 'tipo_equipo', 'marca', 'modelo', 'serial', 'codigo_bienes', 'procesador', 'tipo_ram', 'cant_memoria', 'tipo_disco', 'almacenamiento', 'sistema_operativo', 'estado', 'prestamo_unidad', 'prestamo_usuario'];
    $cambios = [];
    foreach ($campos as $campo) {

        // Ignorar prestamo_unidad y prestamo_usuario si estado != En préstamo
        if (in_array($campo, ['prestamo_unidad', 'prestamo_usuario']) && $estado != 'En préstamo') continue;

        // Ignorar usuarioRes_id si no cambió realmente
        if ($campo == 'usuarioRes_id') {
            $valor_actual = intval($equipo_actual['usuarioRes_id']);
            $valor_nuevo   = intval($usuarioRes_id);
            if ($valor_actual === $valor_nuevo) continue;
        }


        if (isset($$campo) && $equipo_actual[$campo] != $$campo) {
            $cambios[$campo] = [
                'anterior' => $equipo_actual[$campo],
                'nuevo' => $$campo
            ];
        }
    }

    // Asignar tipo_evento según los campos modificados
    $hardwareCampos = ['tipo_equipo', 'marca', 'modelo', 'serial', 'procesador', 'tipo_ram', 'cant_memoria', 'tipo_disco', 'almacenamiento'];
    $softwareCampos = ['sistema_operativo'];
    $prestamoCampos = ['estado', 'prestamo_unidad', 'prestamo_usuario'];
    $tipo_evento = "Otros";

    foreach ($cambios as $campo => $valores) {
        if (in_array($campo, $hardwareCampos)) {
            $tipo_evento = "Hardware";
            break;
        }
        if (in_array($campo, $softwareCampos)) {
            $tipo_evento = "Software";
            break;
        }
        if (in_array($campo, $prestamoCampos)) {
            $tipo_evento = "Préstamo / Asignación";
            break;
        }
    }

    if (empty($cambios)) $tipo_evento = "Mantenimiento";

    // Actualizar datos en la tabla equipos
    $sql_update = "UPDATE equipos SET 
        unidad_id='$unidad_id',
        usuarioRes_id='$usuarioRes_id',
        ubicacion='$ubicacion',
        observaciones='$observaciones',
        tipo_equipo='$tipo_equipo',
        marca='$marca',
        modelo='$modelo',
        serial='$serial',
        codigo_bienes='$codigo_bienes',
        procesador='$procesador',
        tipo_ram='$tipo_ram',
        cant_memoria='$cant_memoria',
        tipo_disco='$tipo_disco',
        almacenamiento='$almacenamiento',
        sistema_operativo='$sistema_operativo',
        fecha_ultima_modificacion='$fecha_ultima_modificacion',
        encargado_modificacion='$encargado_modificacion',
        estado='$estado',
        prestamo_unidad='$prestamo_unidad',
        prestamo_usuario='$prestamo_usuario'
        WHERE id='$id'";

    $res_update = mysqli_query($conexion, $sql_update);

    if ($res_update) {
        if (!empty($cambios)) {
            // Insertar en historial_cambios
            $notas = "Campos modificados: " . implode(", ", array_keys($cambios));
            mysqli_query($conexion, "INSERT INTO historial_cambios (equipo_id, usuario_id, fecha, tipo_evento, modo, notas)
                VALUES ('$id','$idUsuario',NOW(),'$tipo_evento','Automático','$notas')");
            $historial_id = mysqli_insert_id($conexion);

            // Insertar en historial_detalle
            foreach ($cambios as $campo => $valores) {
                mysqli_query($conexion, "INSERT INTO historial_detalle (historial_id, campo_modificado, valor_anterior, valor_nuevo)
                    VALUES ('$historial_id','$campo','" . addslashes($valores['anterior']) . "','" . addslashes($valores['nuevo']) . "')");
            }
        }

        echo "<script>
            Swal.fire({
                title: 'Éxito',
                text: 'El equipo fue actualizado correctamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(()=>{ location.assign('../views/equipos.php'); });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Hubo un error al actualizar el registro.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            }).then(()=>{ location.assign('../views/equipos.php'); });
        </script>";
    }
}
 */

function editar_equipo()
{
    include "db.php";
    session_start();
    extract($_POST);
    $idUsuario = $_SESSION['user_id'] ?? 0;

    // --- Obtener datos actuales
    $sql_actual = "SELECT * FROM equipos WHERE id='" . mysqli_real_escape_string($conexion, $id) . "'";
    $res_actual = mysqli_query($conexion, $sql_actual);
    $equipo_actual = mysqli_fetch_assoc($res_actual);

    // --- Validación de código de bienes
    $codigo_bienes_esc = mysqli_real_escape_string($conexion, $codigo_bienes);
    $consulta_verificacion = "SELECT COUNT(*) AS cantidad FROM equipos WHERE codigo_bienes = '$codigo_bienes_esc' AND id != '" . mysqli_real_escape_string($conexion, $id) . "'";
    $resultado_verificacion = mysqli_query($conexion, $consulta_verificacion);
    $fila_verificacion = mysqli_fetch_assoc($resultado_verificacion);
    if ($fila_verificacion['cantidad'] > 0 && !empty($codigo_bienes)) {
        echo "<script>Swal.fire({icon:'error',title:'Error',text:'El código de bien ya existe en la base de datos.',confirmButtonText:'Aceptar'}).then(()=>{ location.assign('../views/equipos.php'); });</script>";
        return;
    }

    // --- Campos y mapeos
    $campos = [
        'unidad_id',
        'usuarioRes_id',
        'ubicacion',
        'observaciones',
        'tipo_equipo',
        'marca',
        'modelo',
        'serial',
        'codigo_bienes',
        'procesador',
        'tipo_ram',
        'cant_memoria',
        'tipo_disco',
        'almacenamiento',
        'sistema_operativo',
        'estado',
        'prestamo_unidad',
        'prestamo_usuario'
    ];

    $mapa_tipo = [
        'Hardware' => ['tipo_equipo', 'marca', 'modelo', 'serial', 'procesador', 'tipo_ram', 'cant_memoria', 'tipo_disco', 'almacenamiento'],
        'Software' => ['sistema_operativo'],
        'Préstamo / Asignación' => ['prestamo_unidad', 'prestamo_usuario']
    ];

    $labels = [
        'unidad_id' => 'Unidad',
        'usuarioRes_id' => 'Usuario responsable',
        'ubicacion' => 'Ubicación',
        'observaciones' => 'Observaciones',
        'tipo_equipo' => 'Tipo de equipo',
        'marca' => 'Marca',
        'modelo' => 'Modelo',
        'serial' => 'Serial',
        'codigo_bienes' => 'Código de bienes',
        'procesador' => 'Procesador',
        'tipo_ram' => 'Tipo de RAM',
        'cant_memoria' => 'Memoria RAM (GB)',
        'tipo_disco' => 'Tipo de disco',
        'almacenamiento' => 'Almacenamiento (GB)',
        'sistema_operativo' => 'Sistema operativo',
        'estado' => 'Estado',
        'prestamo_unidad' => 'Unidad de préstamo',
        'prestamo_usuario' => 'Usuario de préstamo'
    ];

    // --- helpers para mostrar nombres legibles
    $getUserName = function ($uid) use ($conexion) {
        $uid = intval($uid);
        if ($uid <= 0) return 'Ninguno';
        $q = "SELECT nombre, apellido FROM usuarios WHERE id='$uid' LIMIT 1";
        $r = mysqli_query($conexion, $q);
        if ($row = mysqli_fetch_assoc($r)) return trim($row['nombre'] . ' ' . $row['apellido']);
        return "[Eliminado] (ID:$uid)";
    };
    $getUnidadName = function ($uid) use ($conexion) {
        $uid = intval($uid);
        if ($uid <= 0) return 'Ninguno';
        $q = "SELECT nombre_unidad FROM unidades WHERE id='$uid' LIMIT 1";
        $r = mysqli_query($conexion, $q);
        if ($row = mysqli_fetch_assoc($r)) return $row['nombre_unidad'];
        return "[Eliminada] (ID:$uid)";
    };

    // --- detectar cambios
    $numericFields = ['unidad_id', 'usuarioRes_id', 'prestamo_unidad', 'prestamo_usuario', 'cant_memoria', 'almacenamiento'];
    $cambios_por_tipo = ['Hardware' => [], 'Software' => [], 'Préstamo / Asignación' => [], 'Otros' => []];

    $estado_anterior = $equipo_actual['estado'] ?? '';
    $estado_nuevo = array_key_exists('estado', $_POST) ? trim($_POST['estado']) : $estado_anterior;

    // --- liberar unidad y usuario si se pasa de "En préstamo"
    if ($estado_anterior === 'En préstamo' && $estado_nuevo !== 'En préstamo') {
        $act_unidad = intval($equipo_actual['prestamo_unidad'] ?? 0);
        if ($act_unidad !== 0) {
            $cambios_por_tipo['Préstamo / Asignación']['prestamo_unidad'] = [
                'anterior_raw' => $act_unidad,
                'nuevo_raw' => 0,
                'anterior_label' => $getUnidadName($act_unidad),
                'nuevo_label' => '[liberado]'
            ];
        }
        $act_user = intval($equipo_actual['prestamo_usuario'] ?? 0);
        if ($act_user !== 0) {
            $cambios_por_tipo['Préstamo / Asignación']['prestamo_usuario'] = [
                'anterior_raw' => $act_user,
                'nuevo_raw' => 0,
                'anterior_label' => $getUserName($act_user),
                'nuevo_label' => '[liberado]'
            ];
        }
        $_POST['prestamo_unidad'] = 0;
        $_POST['prestamo_usuario'] = 0;
    }

    // --- validar si se pasa a "En préstamo"
    if ($estado_anterior !== 'En préstamo' && $estado_nuevo === 'En préstamo') {
        $pu = intval($_POST['prestamo_unidad'] ?? 0);
        $puu = intval($_POST['prestamo_usuario'] ?? 0);
        if ($pu <= 0 || $puu <= 0) {
            echo "<script>Swal.fire({icon:'error',title:'Error',text:'Si cambia a \"En préstamo\" debe seleccionar unidad y usuario de préstamo.',confirmButtonText:'Aceptar'}).then(()=>{ history.back(); });</script>";
            return;
        }
    }

    // --- iterar campos y detectar cambios
    foreach ($campos as $campo) {
        if (
            !array_key_exists($campo, $_POST) &&
            !isset($cambios_por_tipo['Préstamo / Asignación'][$campo]) &&
            !isset($cambios_por_tipo['Hardware'][$campo]) &&
            !isset($cambios_por_tipo['Software'][$campo]) &&
            !isset($cambios_por_tipo['Otros'][$campo])
        ) continue;

        if (
            isset($cambios_por_tipo['Préstamo / Asignación'][$campo]) ||
            isset($cambios_por_tipo['Hardware'][$campo]) ||
            isset($cambios_por_tipo['Software'][$campo]) ||
            isset($cambios_por_tipo['Otros'][$campo])
        ) continue;

        $actual_raw = $equipo_actual[$campo] ?? '';
        $nuevo_raw = array_key_exists($campo, $_POST) ? $_POST[$campo] : $actual_raw;

        if (in_array($campo, $numericFields)) {
            $actual = intval($actual_raw);
            $nuevo = intval($nuevo_raw);
            if ($actual === $nuevo) continue;
            if ($campo === 'usuarioRes_id' || $campo === 'prestamo_usuario') {
                $label_anterior = $getUserName($actual);
                $label_nuevo = $getUserName($nuevo);
            } elseif ($campo === 'prestamo_unidad' || $campo === 'unidad_id') {
                $label_anterior = $getUnidadName($actual);
                $label_nuevo = $getUnidadName($nuevo);
            } else {
                $label_anterior = (string)$actual_raw;
                $label_nuevo = (string)$nuevo_raw;
            }
        } else {
            $actual = trim((string)$actual_raw);
            $nuevo = trim((string)$nuevo_raw);
            if ($actual === $nuevo) continue;
            $label_anterior = $actual === '' ? 'Vacío' : $actual;
            $label_nuevo = $nuevo === '' ? 'Vacío' : $nuevo;
        }

        $tipo = 'Otros';
        foreach ($mapa_tipo as $key => $lista_campos) if (in_array($campo, $lista_campos)) {
            $tipo = $key;
            break;
        }

        $cambios_por_tipo[$tipo][$campo] = [
            'anterior_raw' => $actual_raw,
            'nuevo_raw' => $nuevo_raw,
            'anterior_label' => $label_anterior,
            'nuevo_label' => $label_nuevo
        ];
    }

    // --- separar cambio de estado como tipo_evento independiente
    if (isset($cambios_por_tipo['Préstamo / Asignación']['estado'])) {
        $estado_change = $cambios_por_tipo['Préstamo / Asignación']['estado'];
        $cambios_por_tipo['Estado'] = ['estado' => $estado_change]; // tipo_evento nuevo
        unset($cambios_por_tipo['Préstamo / Asignación']['estado']);
    } elseif (isset($cambios_por_tipo['Otros']['estado'])) {
        $estado_change = $cambios_por_tipo['Otros']['estado'];
        $cambios_por_tipo['Estado'] = ['estado' => $estado_change]; // tipo_evento nuevo
        unset($cambios_por_tipo['Otros']['estado']);
    }

    // --- UPDATE
    $fields_to_escape = [
        'unidad_id',
        'usuarioRes_id',
        'ubicacion',
        'observaciones',
        'tipo_equipo',
        'marca',
        'modelo',
        'serial',
        'codigo_bienes',
        'procesador',
        'tipo_ram',
        'cant_memoria',
        'tipo_disco',
        'almacenamiento',
        'sistema_operativo',
        'fecha_ultima_modificacion',
        'encargado_modificacion',
        'estado',
        'prestamo_unidad',
        'prestamo_usuario'
    ];

    $set_parts = [];
    foreach ($fields_to_escape as $f) {
        $val = array_key_exists($f, $_POST) ? $_POST[$f] : $equipo_actual[$f];
        $val_esc = mysqli_real_escape_string($conexion, $val);
        $set_parts[] = "$f='$val_esc'";
    }
    $sql_update = "UPDATE equipos SET " . implode(", ", $set_parts) . " WHERE id='" . mysqli_real_escape_string($conexion, $id) . "'";
    $res_update = mysqli_query($conexion, $sql_update);

    if ($res_update) {
        // --- insertar historial con redacción fluida y natural
        foreach ($cambios_por_tipo as $tipo_evento => $campos_tipo) {
            if (empty($campos_tipo)) continue;

            $partes = [];

            if ($tipo_evento === 'Préstamo / Asignación') {
                $liberado_unidad = isset($campos_tipo['prestamo_unidad']) && $campos_tipo['prestamo_unidad']['nuevo_label'] === '[liberado]';
                $liberado_usuario = isset($campos_tipo['prestamo_usuario']) && $campos_tipo['prestamo_usuario']['nuevo_label'] === '[liberado]';
                $asignado = isset($campos_tipo['prestamo_usuario'], $campos_tipo['prestamo_unidad'])
                    && $campos_tipo['prestamo_usuario']['nuevo_label'] !== '[liberado]';

                if ($liberado_unidad || $liberado_usuario) {
                    $unidad = $campos_tipo['prestamo_unidad']['anterior_label'] ?? '';
                    $usuario = $campos_tipo['prestamo_usuario']['anterior_label'] ?? '';
                    $unidad_txt = $unidad ? " de la unidad $unidad" : "";
                    $usuario_txt = $usuario ? " y del usuario $usuario" : "";
                    $partes[] = "El equipo fue liberado$unidad_txt$usuario_txt debido a cambio de estado.";
                } elseif ($asignado) {
                    $usuario = $campos_tipo['prestamo_usuario']['nuevo_label'];
                    $unidad = $campos_tipo['prestamo_unidad']['nuevo_label'];
                    $partes[] = "El equipo fue asignado a $usuario en la unidad $unidad.";
                }
            } elseif ($tipo_evento === 'Estado') {
                $v = $campos_tipo['estado'];
                $partes[] = "El estado del equipo cambió de {$v['anterior_label']} a {$v['nuevo_label']}.";
            } else {
                foreach ($campos_tipo as $campo => $v) {
                    $label = $labels[$campo] ?? $campo;
                    if ($tipo_evento === 'Hardware' || $tipo_evento === 'Software') {
                        $partes[] = "Se actualizó {$label} de {$v['anterior_label']} a {$v['nuevo_label']}.";
                    } else {
                        $partes[] = "{$label} modificado: {$v['anterior_label']} → {$v['nuevo_label']}";
                    }
                }
            }

            $notas = implode("; ", $partes);
            $notas_sql = mysqli_real_escape_string($conexion, $notas);

            mysqli_query($conexion, "INSERT INTO historial_cambios (equipo_id, usuario_id, fecha, tipo_evento, modo, notas)
                VALUES ('" . mysqli_real_escape_string($conexion, $id) . "','" . mysqli_real_escape_string($conexion, $idUsuario) . "',
                NOW(),'" . mysqli_real_escape_string($conexion, $tipo_evento) . "','Automático','$notas_sql')");

            $historial_id = mysqli_insert_id($conexion);

            foreach ($campos_tipo as $campo => $v) {
                $campo_sql = mysqli_real_escape_string($conexion, $campo);
                $va = mysqli_real_escape_string($conexion, $v['anterior_label']);
                $vn = mysqli_real_escape_string($conexion, $v['nuevo_label']);
                mysqli_query($conexion, "INSERT INTO historial_detalle (historial_id, campo_modificado, valor_anterior, valor_nuevo)
                    VALUES ('$historial_id','$campo_sql','$va','$vn')");
            }
        }

        echo "<script>
        Swal.fire({
        title:'Éxito',
        text:'El equipo fue actualizado correctamente.',
        icon:'success',
        confirmButtonText:'Aceptar',
        confirmButtonColor: '#034D81'
        })
        .then(()=>{ 
        location.assign('../views/equipos.php'); 
        });
        </script>";
    } else {
        echo "<script>Swal.fire({title:'Error',text:'Hubo un error al actualizar el registro.',icon:'error',confirmButtonText:'Aceptar', confirmButtonColor: '#034D81'}).then(()=>{ location.assign('../views/equipos.php'); });</script>";
    }
}


function insert_puntored()
{
    include "db.php";
    extract($_POST);
    $consulta = "INSERT INTO puntos_red (departamento, descripcion, patch_panel, puerto_pp, switches, puerto_sw, estado, fecha_registro, encargado_registro)
                     VALUES ('$departamento', '$descripcion', '$patch_panel', '$puerto_pp', '$switches', '$puerto_sw', '$estado', '$fecha_registro', '$encargado_registro')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo "<script>
                 Swal.fire({
                     icon: 'success',
                     title: 'Éxito',
                     text: 'El Punto de Red ha sido registrado correctamente.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/puntos_red.php');
                 });
                 </script>";
    } else {
        echo "<script>
                 Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'Error al realizar la inserción. Por favor, verifique los datos e inténtelo nuevamente.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/puntos_red.php');
                 });
                 </script>";
    }
}

function editar_puntored()
{
    include "db.php";
    extract($_POST);


    // Inicializa la parte de la consulta que actualizará los campos
    $set_clause = '';

    // Verifica y agrega los campos que se desean actualizar
    if (isset($departamento)) {
        $set_clause .= "departamento = '$departamento', ";
    }
    if (isset($descripcion)) {
        $set_clause .= "descripcion = '$descripcion', ";
    }
    if (isset($patch_panel)) {
        $set_clause .= "patch_panel = '$patch_panel', ";
    }
    if (isset($puerto_pp)) {
        $set_clause .= "puerto_pp = '$puerto_pp', ";
    }
    if (isset($switches)) {
        $set_clause .= "switches = '$switches', ";
    }
    if (isset($puerto_sw)) {
        $set_clause .= "puerto_sw = '$puerto_sw', ";
    }
    if (isset($estado)) {
        $set_clause .= "estado = '$estado', ";
    }


    // Elimina la coma extra al final de la lista de campos a actualizar
    $set_clause = rtrim($set_clause, ', ');

    // Construye la consulta SQL completa
    $consulta = "UPDATE puntos_red SET $set_clause, fecha_ultima_modificacion = '$fecha_ultima_modificacion', encargado_modificacion = '$encargado_modificacion' WHERE id = '$id'";

    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo "<script>
                 Swal.fire({
                title: 'Éxito',
                text: 'El Punto de Red Seleccionado fue actualizado correctamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
                closeOnClickOutside: false,
                closeOnEsc: false,
                content: {
                    element: 'p',
                    attributes: {
                        innerHTML: 'El Punto de Red Seleccionado fue actualizado correctamente.'
                    }
                }
            }).then(function() {
                location.assign('../views/puntos_red.php');
            });
        </script>";
    } else {
        echo "<script>
                 Swal.fire({
                title: 'Error',
                text: 'Hubo un error al actualizar el registro',
                icon: 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
            }).then(function() {
                location.assign('../views/puntos_red.php');
            });
        </script>";
    }
}



function insert_ip_fija()
{
    include "db.php";
    extract($_POST);

    // Verificar si la dirección IP ya existe en la tabla
    $sql_ip_existente = "SELECT COUNT(*) AS total FROM ip_fijas WHERE ip = '$ip'";
    $resultado_ip = mysqli_query($conexion, $sql_ip_existente);
    $fila_ip = mysqli_fetch_assoc($resultado_ip);
    $ip_existente = $fila_ip['total'];

    // Verificar si el ID del equipo ya existe en la tabla
    $sql_equipo_existente = "SELECT COUNT(*) AS total FROM ip_fijas WHERE id_equipo = '$id_equipo'";
    $resultado_equipo = mysqli_query($conexion, $sql_equipo_existente);
    $fila_equipo = mysqli_fetch_assoc($resultado_equipo);
    $equipo_existente = $fila_equipo['total'];

    // Si la dirección IP o el ID del equipo ya existen, mostrar un mensaje de error y detener la inserción
    if ($ip_existente > 0) {
        echo "<script>
                 Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'La dirección IP ingresada ya existe. Por favor, elige otra.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/ip_fijas.php');
                 });
              </script>";
        return; // Detener la ejecución de la función
    } elseif ($equipo_existente > 0) {
        echo "<script>
                 Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'El Equipo Seleccionado ya tiene IP Fija Asignada. Por favor, elige otro.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/ip_fijas.php');
                 });
              </script>";
        return; // Detener la ejecución de la función
    }

    // Si la dirección IP y el ID del equipo son únicos, realizar la inserción
    $consulta = "INSERT INTO ip_fijas (departamento, id_equipo, descripcion, ip, estado, fecha_registro, encargado_registro)
                 VALUES ('$departamento', '$id_equipo', '$descripcion', '$ip', '$estado', '$fecha_registro', '$encargado_registro')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo "<script>
                 Swal.fire({
                     icon: 'success',
                     title: 'Éxito',
                     text: 'La dirección IP ha sido asignada correctamente.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/ip_fijas.php');
                 });
              </script>";
    } else {
        echo "<script>
                 Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'Error al realizar la inserción. Por favor, verifique los datos e inténtelo nuevamente.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/ip_fijas.php');
                 });
              </script>";
    }
}

function editar_ip_fija()
{
    include "db.php";
    extract($_POST);
    $id = mysqli_real_escape_string($conexion, $id); // Evitar inyección SQL

    // Verificar si la dirección IP ya existe en la tabla, excluyendo la entrada actual
    $sql_ip_existente = "SELECT COUNT(*) AS total FROM ip_fijas WHERE ip = '$ip' AND id != '$id'";
    $resultado_ip = mysqli_query($conexion, $sql_ip_existente);
    $fila_ip = mysqli_fetch_assoc($resultado_ip);
    $ip_existente = $fila_ip['total'];

    // Verificar si el ID del equipo ya existe en la tabla, excluyendo la entrada actual
    $sql_equipo_existente = "SELECT COUNT(*) AS total FROM ip_fijas WHERE id_equipo = '$id_equipo' AND id != '$id'";
    $resultado_equipo = mysqli_query($conexion, $sql_equipo_existente);
    $fila_equipo = mysqli_fetch_assoc($resultado_equipo);
    $equipo_existente = $fila_equipo['total'];

    // Si la dirección IP o el ID del equipo ya existen (excepto la entrada actual), mostrar un mensaje de error y detener la edición
    if ($ip_existente > 0) {
        echo "<script>
                 Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'La dirección IP ingresada ya se encuentra asignada. Por favor, elige otra.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                    window.history.back(); // Volver a la página anterior
                 });
              </script>";
        return; // Detener la ejecución de la función
    } elseif ($equipo_existente > 0) {
        echo "<script>
                 Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'El Equipo Seleccionado ya tiene IP Fija Asignada. Por favor, elige otro.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                    window.history.back(); // Volver a la página anterior
                 });
              </script>";
        return; // Detener la ejecución de la función
    }

    // Si la dirección IP y el ID del equipo son únicos, continuar con la actualización
    $consulta = "UPDATE ip_fijas 
                 SET departamento = '$departamento', id_equipo = '$id_equipo', descripcion = '$descripcion', ip = '$ip', estado = '$estado', fecha_modificacion = '$fecha_modificacion', encargado_modificacion = '$encargado_modificacion' 
                 WHERE id = '$id'";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo "<script>
                 Swal.fire({
                     icon: 'success',
                     title: 'Éxito',
                     text: 'La dirección IP ha sido actualizada correctamente.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/ip_fijas.php');
                 });
              </script>";
    } else {
        echo "<script>
                 Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'Error al realizar la actualización. Por favor, verifique los datos e inténtelo nuevamente.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/ip_fijas.php');
                 });
              </script>";
    }
}



function insert_accesoRouter()
{
    include "db.php";
    extract($_POST);

    $consulta = "INSERT INTO acceso_routers (id_equipo, direccion_ip, wan_ip, nombre, contraseña, usuario_acceso, contraseña_acceso, visibilidad, filtro_mac, uso, ubicacion, estado, fecha_registro, encargado_registro)
                     VALUES ('$id_equipo', '$direccion_ip', '$wan_ip', '$nombre', '$contraseña', '$usuario_acceso', '$contraseña_acceso', '$visibilidad', '$filtro_mac', '$uso', '$ubicacion',  '$estado', '$fecha_registro', '$encargado_registro')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo "<script>
                 Swal.fire({
                     icon: 'success',
                     title: 'Éxito',
                     text: 'Routers ha sido registrado correctamente.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/acceso_routers.php');
                 });
                 </script>";
    } else {
        echo "<script>
                 Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'Error al realizar la inserción. Por favor, verifique los datos e inténtelo nuevamente.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/acceso_routers.php');
                 });
                 </script>";
    }
}

function editar_accesoRouter()
{
    include "db.php";
    extract($_POST);

    $consulta_verificacion = "SELECT direccion_ip FROM acceso_routers WHERE direccion_ip = '$direccion_ip' AND id <> '$id'";
    $resultado_verificacion = mysqli_query($conexion, $consulta_verificacion);

    if (mysqli_num_rows($resultado_verificacion) > 0) {
        echo "<script>
         Swal.fire({
             icon: 'error',
             title: 'Error',
             text: 'Este Router ocupa una dirección IP ya existente',
             confirmButtonText: 'Aceptar',
            confirmButtonColor: '#034D81',
         }).then(function() {
             location.assign('../views/acceso_routers.php');
         });
         </script>";
        return; // Detener la ejecución de la función
    }


    $consulta = "UPDATE acceso_routers SET id_equipo = '$id_equipo', direccion_ip = '$direccion_ip', wan_ip = '$wan_ip', nombre = '$nombre', contraseña = '$contraseña', usuario_acceso = '$usuario_acceso', contraseña_acceso = '$contraseña_acceso', uso = '$uso', ubicacion = '$ubicacion', filtro_mac = '$filtro_mac', visibilidad = '$visibilidad', fecha_modificacion = '$fecha_modificacion', encargado_modificacion = '$encargado_modificacion', estado = '$estado' WHERE id = '$id' ";

    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo "<script>
                 Swal.fire({
                title: 'Éxito',
                text: 'El Registro fue actualizado correctamente.',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
                icon: 'success',
                button: 'Aceptar',
                closeOnClickOutside: false,
                closeOnEsc: false,
                content: {
                    element: 'p',
                    attributes: {
                        innerHTML: 'El Registro fue actualizado correctamente.'
                    }
                }
            }).then(function() {
                location.assign('../views/acceso_routers.php');
            });
        </script>";
    } else {
        echo "<script>
                 Swal.fire({
                title: 'Error',
                text: 'Hubo un error al actualizar el registro',
                icon: 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
            }).then(function() {
                location.assign('../views/acceso_routers.php');
            });
        </script>";
    }
}



function insert_actaRevision()
{
    include "db.php";
    extract($_POST);

    $consulta = "INSERT INTO acta_revision (id_acta, fecha_revision, unidad_trabajo, responsable_uso, descripcion_equipo, serial, codigo_bienes, estado_equipo, operatividad, accesorios_perifericos, resultado_revision, conclusion_revision, user_elaboracion, user_revision)
                     VALUES ('$id_acta', '$fecha_revision', '$unidad_trabajo', '$responsable_uso', '$descripcion_equipo', '$serial', '$codigo_bienes', '$estado_equipo', '$operatividad', '$accesorios_perifericos', '$resultado_revision',  '$conclusion_revision', '$user_elaboracion', '$user_revision')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo "<script>
                 Swal.fire({
                     icon: 'success',
                     title: 'Éxito',
                     text: 'Acta de Revisión de Equipo registrada correctamente.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/acta_revision.php');
                 });
                 </script>";
    } else {
        echo "<script>
                 Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'Error al realizar la inserción. Por favor, verifique los datos e inténtelo nuevamente.',
                     confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#034D81',
                 }).then(function() {
                     location.assign('../views/acta_revision.php');
                 });
                 </script>";
    }
}

function editar_actaRevision()
{
    include "db.php";
    extract($_POST);

    // Construye la consulta SQL
    $consulta = "UPDATE acta_revision SET fecha_revision = '$fecha_revision', unidad_trabajo = '$unidad_trabajo', responsable_uso = '$responsable_uso', descripcion_equipo = '$descripcion_equipo', serial = '$serial', codigo_bienes = '$codigo_bienes', estado_equipo = '$estado_equipo', operatividad = '$operatividad', accesorios_perifericos = '$accesorios_perifericos', resultado_revision = '$resultado_revision', conclusion_revision = '$conclusion_revision', user_elaboracion = '$user_elaboracion', user_revision = '$user_revision' WHERE id_acta = '$id_acta' ";

    // Ejecuta la consulta SQL
    $resultado = mysqli_query($conexion, $consulta);

    // Verifica si la consulta se ejecutó correctamente
    if ($resultado) {
        echo "<script>
                 Swal.fire({
                title: 'Éxito',
                text: 'Acta de Revisión de Equipo Nº($id_acta) fue actualizado correctamente.',
                icon: 'success',
                closeOnClickOutside: false,
                closeOnEsc: false,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
                content: {
                    element: 'p',
                    attributes: {
                        innerHTML: 'Acta de Revisión de Equipo Nº($id_acta) fue actualizado correctamente.'
                    }
                }
            }).then(function() {
                location.assign('../views/acta_revision.php');
            });
        </script>";
    } else {
        echo "<script>
                 Swal.fire({
                title: 'Error',
                text: 'Hubo un error al actualizar el registro',
                icon: 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
            }).then(function() {
                location.assign('../views/acta_revision.php');
            });
        </script>";
    }
}
