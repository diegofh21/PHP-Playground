<?php 
include_once('db.php');

session_start();

if( !isset( $_SESSION[ 'loggedin' ] ) || $_SESSION[ 'user_level'] == 'usuario' )
{
  header( 'location:../index.php?categoria=login' );
  exit;
}

$id_factura = isset( $_GET[ 'id_factura' ] ) ? $_GET[ 'id_factura' ] : null;

$consulta = "UPDATE `factura` SET `estado`= '1' WHERE `factura`.`id_factura` = '$id_factura'";
$resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );
	
header( 'location:../panel.php?categoria=facturas&mensaje=success' );
?>