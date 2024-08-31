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
?>
<?php
include("conexion.php");
$con = conexion();

// Obtener los valores del formulario
$doc = $_POST["doc"];
$nom = $_POST["nom"];
$ape = $_POST["ape"];
$dir = $_POST["dir"];
$cel = $_POST["cel"];

// Crear la consulta SQL, especificando los nombres de las columnas
$sql = "INSERT INTO \"Persona\" (documento, nombre, apellido, direccion, celular) VALUES ('$doc', '$nom', '$ape', '$dir', '$cel')";

// Ejecutar la consulta
pg_query($con, $sql);

// Redirigir a la página de listado
header("Location: listar_grupoYCG.php");
?>
