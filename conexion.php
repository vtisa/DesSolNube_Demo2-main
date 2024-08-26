<?php
	function conexion(){

	$host = "host=viaduct.proxy.rlwy.net";
	$port = "port=26862";
	$dbname = "dbname=railway";
	$user = "user=postgres";
	$password = "password=SIIZpYZuHrHzKtzfUhAFNdDKKPEACBSJ";

	$db = pg_connect("$host $port $dbname $user $password");

	return $db;
}
?>
