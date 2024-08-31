<!doctype html>
<html lang="es">

<head>
    <title>Pagina Principal</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        h1 {
            font-weight: bold;
            color: #333;
        }

        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .card {
            box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand img {
            width: 30px;
            position: absolute;
            margin-left: -35px;
        }

        .navbar-brand span {
            position: relative;
            left: 35px;
        }

        .nav-link {
            color: #333 !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #ff6b6b !important;
        }

        .btn-info {
            background-color: #ff6b6b;
            border-color: #ff6b6b;
        }

        .btn-info:hover {
            background-color: #ff4f4f;
            border-color: #ff4f4f;
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-top: 50px;
        }

        footer img {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="index2.png" alt="Index Logo">
            <span>Index</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <div class="container px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4 text-info">Registrando datos con Railway</h1>
        <p class="lead">PostgreSQL + PHP</p>
    </div>

    <!-- Botón Registrar -->
    <div class="container text-right mb-4">
        <a href="index.php" class="btn btn-info">Registrar</a>
    </div>

    <!-- Tabla para mostrar los datos de las personas -->
    <div class="card mt-5">
        <div class="card-body">
            <h2 class="card-title text-center mb-4 text-info">Lista de Personas Registradas</h2>
            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead class="table-info">
                        <tr>
                            <th>Nro Documento</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Dirección</th>
                            <th>Celular</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="personaTableBody">
                        <?php
                        include("conexion.php");
                        $con = conexion();
                        $sql = "SELECT * FROM persona";

                        // Ejecutar la consulta
                        $resultado = pg_query($con, $sql);
                        if ($resultado) {
                            // Recorrer los resultados y mostrar cada fila en la tabla
                            while ($fila = pg_fetch_assoc($resultado)) {
                                echo "<tr>";
                                echo "<td>" . $fila['documento'] . "</td>";
                                echo "<td>" . $fila['nombre'] . "</td>";
                                echo "<td>" . $fila['apellido'] . "</td>";
                                echo "<td>" . $fila['direccion'] . "</td>";
                                echo "<td>" . $fila['celular'] . "</td>";
                                echo "<td>
                                        <button class='btn btn-sm btn-warning' onclick='editarPersona(" . json_encode($fila) . ")'>Editar</button>
                                        <button class='btn btn-sm btn-danger' onclick='eliminarPersona(\"" . $fila['documento'] . "\")'>Eliminar</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Error al ejecutar la consulta SQL: " . pg_last_error($con) . "</td></tr>";
                        }

                        pg_close($con);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Persona -->
    <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Editar Persona</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editarForm">
                        <div class="form-group">
                            <label for="editDocumento">Nro Documento</label>
                            <input type="text" class="form-control" id="editDocumento" readonly>
                        </div>
                        <div class="form-group">
                            <label for="editNombre">Nombre</label>
                            <input type="text" class="form-control" id="editNombre">
                        </div>
                        <div class="form-group">
                            <label for="editApellido">Apellidos</label>
                            <input type="text" class="form-control" id="editApellido">
                        </div>
                        <div class="form-group">
                            <label for="editDireccion">Dirección</label>
                            <input type="text" class="form-control" id="editDireccion">
                        </div>
                        <div class="form-group">
                            <label for="editCelular">Celular</label>
                            <input type="text" class="form-control" id="editCelular">
                        </div>
                        <button type="button" class="btn btn-info" onclick="guardarCambios()">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="pt-4 text-center">
        <div class="row">
            <div class="col-12 col-md">
                <img class="mb-2" src="https://www.svgrepo.com/show/508391/uncle.svg" alt="" width="24" height="24">
                <small class="d-block mb-3 text-muted">&copy; 2023-1</small>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>
        function editarPersona(fila) {
            $('#editDocumento').val(fila.documento);
            $('#editNombre').val(fila.nombre);
            $('#editApellido').val(fila.apellido);
            $('#editDireccion').val(fila.direccion);
            $('#editCelular').val(fila.celular);
            $('#editarModal').modal('show');
        }

        function guardarCambios() {
            const documento = $('#editDocumento').val();
            const nombre = $('#editNombre').val();
            const apellido = $('#editApellido').val();
            const direccion = $('#editDireccion').val();
            const celular = $('#editCelular').val();

            $.ajax({
            url: 'editar.php',
            method: 'POST',
            data: {
                documento: documento,
                nombre: nombre,
                apellido: apellido,
                direccion: direccion,
                celular: celular
            },
            success: function(response) {
                $('#editarModal').modal('hide');
                location.reload(); // Actualiza la página para reflejar los cambios
            },
            error: function(xhr, status, error) {
                alert('Error al guardar cambios: ' + error);
            }
        });
    }

    function eliminarPersona(documento) {
        if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
            $.ajax({
                url: 'eliminar.php',
                method: 'POST',
                data: {
                    documento: documento
                },
                success: function(response) {
                    location.reload(); // Actualiza la página para reflejar la eliminación
                },
                error: function(xhr, status, error) {
                    alert('Error al eliminar el registro: ' + error);
                }
            });
        }
    }
</script>

</body>

</html>