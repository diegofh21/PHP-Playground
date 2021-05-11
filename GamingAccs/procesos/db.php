<?php  

$host = "localhost";
$user = "root";
$password = "";
$database   = "gamingdb";

$conexion = mysqli_connect( $host, $user, $password, $database ) or die( "No se ha podido establecer conexion con el servidor" ); 
?>