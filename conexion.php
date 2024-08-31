<?php
<?php
$db = pg_connect("host=dpg-cr6g05bv2p9s7392u7h0-a.oregon-postgres.render.com port=5432 dbname=dbprueba_7k2p user=dbprueba_7k2p_user password=H0IB7ht78vEte22UZ2eQEUcYWSvLjtn4");
if ($db) {
    echo "Conexión exitosa.";
} else {
    echo "Error en la conexión.";
}

?>
