<?php
include("conexion.php");
$con = conexion();

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'edit') {
            $documento = $_POST['documento'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $direccion = $_POST['direccion'];
            $celular = $_POST['celular'];
            
            $sql = "UPDATE persona SET nombre = $1, apellido = $2, direccion = $3, celular = $4 WHERE documento = $5";
            $result = pg_query_params($con, $sql, array($nombre, $apellido, $direccion, $celular, $documento));
            
            if (!$result) {
                echo "Error updating record: " . pg_last_error($con);
            }
        } elseif ($_POST['action'] == 'delete') {
            $documento = $_POST['documento'];
            
            $sql = "DELETE FROM persona WHERE documento = $1";
            $result = pg_query_params($con, $sql, array($documento));
            
            if (!$result) {
                echo "Error deleting record: " . pg_last_error($con);
            }
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
    if ($resultado) {
        while ($fila = pg_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($fila['documento']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['apellido']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['direccion']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['celular']) . "</td>";
            echo "<td>
                    <button class='btn btn-sm btn-warning' onclick='editarPersona(\"" . htmlspecialchars(json_encode($fila)) . "\")'>Editar</button>
                    <form method='post' style='display:inline;'>
                        <input type='hidden' name='action' value='delete'>
                        <input type='hidden' name='documento' value='" . htmlspecialchars($fila['documento']) . "'>
                        <button type='submit' class='btn btn-sm btn-danger' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\")'>Eliminar</button>
                    </form>
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

    <footer class="pt-4 text-center">
        <div class="row">
            <div class="col-12 col-md">
                <img class="mb-2" src="https://www.svgrepo.com/show/508391/uncle.svg" alt="" width="24" height="24">
                <small class="d-block mb-3 text-muted">&copy; 2023-1</small>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
     function editarPersona(personaJSON) {
    var persona = JSON.parse(personaJSON);
    document.getElementById('editDocumento').value = persona.documento;
    document.getElementById('editNombre').value = persona.nombre;
    document.getElementById('editApellido').value = persona.apellido;
    document.getElementById('editDireccion').value = persona.direccion;
    document.getElementById('editCelular').value = persona.celular;

    var editarModal = new bootstrap.Modal(document.getElementById('editarModal'));
    editarModal.show();
}
    </script>
</body>

</html>