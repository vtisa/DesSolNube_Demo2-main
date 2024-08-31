<?php
include("conexion.php");
$con = conexion();

if ($con) {
    $doc = $_POST["doc"];
    $nom = $_POST["nom"];
    $ape = $_POST["ape"];
    $dir = $_POST["dir"];
    $cel = $_POST["cel"];

    $sql = "INSERT INTO Persona (documento, nombre, apellido, direccion, celular) VALUES ('$doc', '$nom', '$ape', '$dir', '$cel')";
    
    $result = pg_query($con, $sql);

    if (!$result) {
        die("Error en la consulta SQL: " . pg_last_error());
    } else {
        echo "Datos insertados correctamente.<br>";
    }

    header("Location: listar_grupoYCG.php");
} else {
    echo "No se pudo establecer la conexión.<br>";
}
?>
