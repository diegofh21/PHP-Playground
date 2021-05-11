<?php
include_once('db.php');

session_start();

if( !isset( $_SESSION[ 'loggedin' ] ) || $_SESSION[ 'user_level'] == 'usuario' )
{
  header( 'location:../index.php?categoria=login' );
  exit;
}

$id_producto = isset($_GET[ 'id_product' ]) ? $_GET[ 'id_product' ] : null;

if( $id_producto == null )
{
  header( 'location:../panel.php?categoria=inventario&mensaje=warning' );
  return;
}

$consulta  = "DELETE FROM `productos` WHERE `id_prod` = '$id_producto'";
$resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );

header( 'location:../panel.php?categoria=inventario&mensaje=success' );
    
?>