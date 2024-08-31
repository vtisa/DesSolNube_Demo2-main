<?php
include("conexion.php");
$con = conexion();

$doc = $_POST["doc"];
$nom = $_POST["nom"];
$ape = $_POST["ape"];
$dir = $_POST["dir"];
$cel = $_POST["cel"];

$sql = "insert into persona values(default,'$doc','$nom','$ape','$dir','$cel')";
pg_query($con, $sql);

header("location:listar_grupoYCG.php");


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
                echo "Error al actulizar" . pg_last_error($con);
            } else {
                echo "Actualizado exitosamente";
            }
        } elseif ($_POST['action'] == 'delete') {
            $documento = $_POST['documento'];
            
            $sql = "DELETE FROM persona WHERE documento = $1";
            $result = pg_query_params($con, $sql, array($documento));
            
            if (!$result) {
                echo "Error al borrar: " . pg_last_error($con);
            } else {
                echo "Borrado exitosamente";
            }
        }
    }
}

?>
