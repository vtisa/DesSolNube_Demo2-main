<?php

function conexion(){

$host = "host=dpg-cr6g05bv2p9s7392u7h0-a.oregon-postgres.render.com";
$port = "port=5432";
$dbname = "dbname=dbprueba_7k2p";
$user = "user=dbprueba_7k2p_user";
$password = "password=H0IB7ht78vEte22UZ2eQEUcYWSvLjtn4";

$db = pg_connect("$host $port $dbname $user $password");

return $db;
}
?>