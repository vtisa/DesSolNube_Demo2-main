<?php
include("conexion.php");
$con = conexion();

$documento = $_POST["documento"];
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$direccion = $_POST["direccion"];
$celular = $_POST["celular"];

$query = "INSERT INTO persona (documento, nombre, apellido, direccion, celular) 
          VALUES ($1, $2, $3, $4, $5)";

pg_prepare($con, "insert_persona", $query);

$result = pg_execute($con, "insert_persona", array($documento, $nombre, $apellido, $direccion, $celular));

if ($result) {
    header("Location: listar_grupoYCG.php");
} else {
    echo "Error al insertar: " . pg_last_error($con);
}
?>