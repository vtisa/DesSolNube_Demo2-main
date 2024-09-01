<?php
include("conexion.php");
$con = conexion();

$message = "";
$messageType = "";

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['action'] == 'edit') {
        $documento = $_POST['documento'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $direccion = $_POST['direccion'];
        $celular = $_POST['celular'];
        
        $sql = "UPDATE persona SET nombre = $1, apellido = $2, direccion = $3, celular = $4 WHERE documento = $5";
        $result = pg_query_params($con, $sql, array($nombre, $apellido, $direccion, $celular, $documento));
        
        if (!$result) {
            $message = "Error al actualizar: " . pg_last_error($con);
            $messageType = "error";
        } else {
            $message = "Actualizado exitosamente";
            $messageType = "success";
        }
    } elseif ($_POST['action'] == 'delete') {
        $documento = $_POST['documento'];
        
        $sql = "DELETE FROM persona WHERE documento = $1";
        $result = pg_query_params($con, $sql, array($documento));
        
        if (!$result) {
            $message = "Error al borrar: " . pg_last_error($con);
            $messageType = "error";
        } else {
            $message = "Borrado exitosamente";
            $messageType = "success";
        }
    }
}

// Fetch all records
$sql = "SELECT * FROM persona";
$resultado = pg_query($con, $sql);
?>

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
        body {
            padding-top: 56px; /* Adjust for fixed navbar */
        }
        h1 {
            font-weight: bold;
            color: #333;
        }
        .card {
            box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
        }
        .navbar-brand {
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            width: 30px;
            margin-right: 10px;
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
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.9rem;
            }
        }
        #message-container {
            position: fixed;
            top: 60px;
            right: 20px;
            z-index: 9999;
            max-width: 300px;
        }
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            font-weight: bold;
        }
        .message-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .message-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="index2.png" alt="Index Logo">
                <span>Index</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <main role="main" class="container mt-5">
        <div id="message-container"></div>

        <div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4 text-info">Registrando datos con Render</h1>
            <p class="lead">PostgreSQL + PHP</p>
        </div>

        <!-- Tabla para mostrar los datos de las personas -->
        <div class="card mt-5">
            <div class="card-body">
                <h2 class="card-title text-center mb-4 text-info">Lista de Personas Registradas</h2>
                <div class="text-right mb-4">
                    <a href="index.php" class="btn btn-info">Registrar</a>
                </div>
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
                            if ($resultado) {
                                while ($fila = pg_fetch_assoc($resultado)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($fila['documento']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['apellido']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['direccion']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['celular']) . "</td>";
                                    echo "<td>
                                            <button class='btn btn-sm btn-warning' onclick='editarPersona(" . json_encode($fila) . ")'>Editar</button>
                                            <button class='btn btn-sm btn-danger' onclick='eliminarPersona(\"" . htmlspecialchars($fila['documento']) . "\")'>Eliminar</button>
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
    </main>

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
                    <form id="editarForm" method="post">
                        <input type="hidden" name="action" value="edit">
                        <div class="form-group">
                            <label for="editDocumento">Nro Documento</label>
                            <input type="text" class="form-control" id="editDocumento" name="documento" readonly>
                        </div>
                        <div class="form-group">
                            <label for="editNombre">Nombre</label>
                            <input type="text" class="form-control" id="editNombre" name="nombre">
                        </div>
                        <div class="form-group">
                            <label for="editApellido">Apellidos</label>
                            <input type="text" class="form-control" id="editApellido" name="apellido">
                        </div>
                        <div class="form-group">
                            <label for="editDireccion">Dirección</label>
                            <input type="text" class="form-control" id="editDireccion" name="direccion">
                        </div>
                        <div class="form-group">
                            <label for="editCelular">Celular</label>
                            <input type="text" class="form-control" id="editCelular" name="celular">
                        </div>
                        <button type="submit" class="btn btn-info">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Confirmar Eliminación -->
    <div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="eliminarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que quieres eliminar esta persona?</p>
                    <form id="eliminarForm" method="post">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" id="deleteDocumento" name="documento">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <img src="index2.png" alt="Index Logo">
            <p>&copy; 2023 Tu Empresa. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const messageContainer = document.getElementById("message-container");

            function showMessage(type, text) {
                const message = document.createElement("div");
                message.className = `message message-${type}`;
                message.textContent = text;
                messageContainer.appendChild(message);

                setTimeout(() => {
                    message.remove();
                }, 5000);
            }

            <?php if ($message): ?>
            showMessage('<?php echo $messageType; ?>', '<?php echo $message; ?>');
            <?php endif; ?>

            window.editarPersona = function(persona) {
                document.getElementById("editDocumento").value = persona.documento;
                document.getElementById("editNombre").value = persona.nombre;
                document.getElementById("editApellido").value = persona.apellido;
                document.getElementById("editDireccion").value = persona.direccion;
                document.getElementById("editCelular").value = persona.celular;
                $('#editarModal').modal('show');
            }

            window.eliminarPersona = function(documento) {
                document.getElementById("deleteDocumento").value = documento;
                $('#eliminarModal').modal('show');
            }
        });
    </script>

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-csS5cXGZjPYJL4Ih6JABWHtdLbsH6M1VXq3qt4WmFIKkAaKGiCx9BfJFcFIYOw0g" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
