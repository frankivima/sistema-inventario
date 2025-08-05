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

        case 'insert_departamento':
            insert_departamento();
            break;

        case 'editar_departamento':
            editar_departamento();
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



function insert_departamento()
{
    include "db.php";
    extract($_POST);

    // Verificar si la cédula ya existe en la tabla 'pacientes'
    $consulta_verificar = "SELECT * FROM departamentos WHERE nombre_departamento = '$nombre_departamento'";
    $resultado_verificar = mysqli_query($conexion, $consulta_verificar);

    if (mysqli_num_rows($resultado_verificar) > 0) {
        // La cédula ya existe, muestra un mensaje de error con SweetAlert
        echo "<script>
             Swal.fire({
                 icon: 'error',
                 title: 'Error',
                 text: 'Este Departamento ya se encuentra registrado. No se puede realizar la inserción.',
                 confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
             }).then(function() {
                 location.assign('../views/departamentos.php');
             });
             </script>";
    } else {
        // La cédula no existe, procede con la inserción
        $consulta = "INSERT INTO departamentos (nombre_departamento, estado, fecha_registro, encargado_registro)
                     VALUES ('$nombre_departamento', '$estado', '$fecha_registro', '$encargado_registro')";
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
                     location.assign('../views/departamentos.php');
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
                     location.assign('../views/departamentos.php');
                 });
                 </script>";
        }
    }
}

function editar_departamento()
{
    include "db.php";
    extract($_POST);

    // Verificar si la cédula ya existe en la tabla 'pacientes'
    $consulta_verificar = "SELECT * FROM departamentos WHERE nombre_departamento = '$nombre_departamento' AND id != $id";
    $resultado_verificar = mysqli_query($conexion, $consulta_verificar);

    if (mysqli_num_rows($resultado_verificar) > 0) {
        // La cédula ya existe, muestra un mensaje de error con SweetAlert
        echo "<script>
             Swal.fire({
                 icon: 'error',
                 title: 'Error',
                 text: 'Este Departamento ya se encuentra registrado. No se puede realizar la inserción.',
                 confirmButtonText: 'Aceptar',
            confirmButtonColor: '#034D81',
             }).then(function() {
                 location.assign('../views/departamentos.php');
             });
             </script>";
    } else {

        // Construye la consulta SQL
        $consulta = "UPDATE departamentos SET nombre_departamento = '$nombre_departamento', estado = '$estado' WHERE id = '$id' ";

        // Ejecuta la consulta SQL
        $resultado = mysqli_query($conexion, $consulta);

        // Verifica si la consulta se ejecutó correctamente
        if ($resultado) {
            echo "<script>
                 Swal.fire({
                title: 'Éxito',
                text: 'El Departamento ($nombre_departamento) fue actualizado correctamente.',
                icon: 'success',
                closeOnClickOutside: false,
                closeOnEsc: false,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#034D81',
                content: {
                    element: 'p',
                    attributes: {
                        innerHTML: 'El Departamento ($nombre_departamento) fue actualizado correctamente.'
                    }
                }
            }).then(function() {
                location.assign('../views/departamentos.php');
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
                location.assign('../views/departamentos.php');
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
    $consulta = "INSERT INTO equipos (departamento, usuario_responsable, ubicacion, tipo_equipo, marca, modelo, serial, codigo_bienes, procesador, tipo_ram, cant_memoria, tipo_disco, almacenamiento, sistema_operativo, observaciones, estado, fecha_registro, encargado_registro)
                 VALUES ('$departamento', '$usuario_responsable', '$ubicacion', '$tipo_equipo', '$marca', '$modelo', '$serial', '$codigo_bienes', '$procesador', '$tipo_ram', '$cant_memoria', '$tipo_disco', '$almacenamiento', '$sistema_operativo', '$observaciones', '$estado', '$fecha_registro', '$encargado_registro')";
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

function editar_equipo()
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



    $consulta = "UPDATE equipos SET departamento = '$departamento', usuario_responsable = '$usuario_responsable', ubicacion = '$ubicacion', observaciones = '$observaciones', tipo_equipo = '$tipo_equipo', marca = '$marca', modelo = '$modelo', serial = '$serial', codigo_bienes = '$codigo_bienes', procesador = '$procesador', tipo_ram = '$tipo_ram', cant_memoria = '$cant_memoria', tipo_disco = '$tipo_disco', almacenamiento = '$almacenamiento', fecha_ultima_modificacion = '$fecha_ultima_modificacion', encargado_modificacion = '$encargado_modificacion', estado = '$estado' WHERE id = '$id' ";

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
