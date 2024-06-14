<?php
$servername = "localhost";
$username = "conector_amor_animal";
$password = "amor_animal";
$database = "app";

$conexion = new mysqli($servername, $username, $password, $database);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
