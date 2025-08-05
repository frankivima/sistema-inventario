<?php


session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

if ($varsesion == null || $varsesion = '') {
    header("Location:_sesion/login.php");
}
?>


<body id="page-top">
    <div class="modal fade" id="user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title mayus bold" id="exampleModalLabel">Agregar Usuario</h3>
                    <button type="button" class="btn btn-black" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i></button>
                </div>
                <div class="modal-body">

                    <form action="../includes/_user/insert_user.php" method="POST">

                        <div class="col-12">

                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="nombre" class="label-span">Nombre</label>
                                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                                </div>
                                <div class="form-group col">
                                    <label for="apellido" class="label-span">Apellido</label>
                                    <input type="text" id="apellido" name="apellido" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="username" class="label-span">Usuario:</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="**Usuario Unico**">
                                </div>
                                <div class="form-group col">
                                    <label for="password" class="font-dark bold">Contraseña:</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                            </div>


                            <div class="form-row">

                                <div class="form-group col">
                                    <label for="rol" class="font-dark bold">Nivel:</label>
                                    <select name="rol" id="rol" class="form-select" required>
                                        <option value="">--Selecciona una opción--</option>
                                        <option value="1">Administrador</option>
                                    </select>
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="modal-footer d-flex justify-content-center">

                            <button type="submit" id="register" name="registrar" class="btn btn-agg mayus mr-2">Agregar Usuario</button>
                            <a href="usuarios.php" class="btn btn-delete mayus ml-2">Cancelar</a>

                        </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $('#register').click(function(e) {
                var valid = this.form.checkValidity();

                if (valid) {
                    var nombre = $('#nombre').val();
                    var apellido = $('#apellido').val();
                    var username = $('#username').val();
                    var password = $('#password').val();
                    var rol = $('#rol').val();

                    e.preventDefault();

                    $.ajax({
                        type: 'POST',
                        url: '../includes/_sesion/validar.php',
                        data: {
                            nombre: nombre,
                            apellido: apellido,
                            username: username,
                            password: password,
                            rol: rol
                        },
                        dataType: 'json', // Esperar respuesta en formato JSON
                        success: function(response) {
                            if (response.status === 'success') {
                                // Éxito, mostrar mensaje de éxito
                                Swal.fire({
                                    'title': '¡Success!',
                                    'text': response.message,
                                    'icon': 'success',
                                    'showConfirmButton': 'false',
                                    'timer': '1500'
                                }).then(function() {
                                    window.location = "usuarios.php";
                                });
                            } else {
                                // Error, mostrar mensaje de error
                                Swal.fire({
                                    'title': 'Error',
                                    'text': response.message,
                                    'icon': 'error'
                                });
                            }
                        },
                        error: function() {
                            // Error de comunicación con el servidor, mostrar mensaje de error
                            Swal.fire({
                                'title': 'Error',
                                'text': 'Error al comunicarse con el servidor',
                                'icon': 'error'
                            });
                        }
                    });
                } else {
                    // Formulario no válido, puedes manejar esto si es necesario
                }
            });
        });
    </script>

</html>