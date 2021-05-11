<?php
include_once('db.php');

session_start();

if( !isset( $_SESSION[ 'loggedin' ] ) || $_SESSION[ 'user_level'] == 'usuario' )
{
  header( 'location:../index.php?categoria=login' );
  exit;
}

if( $_SESSION[ 'user_level'] != 'super')
{
  header( 'location:../panel.php?categoria=cuentas&error=No tienes permiso para hacer esta accion' );
  return;
}

$id_user = isset($_GET[ 'id_user' ]) ? $_GET[ 'id_user' ] : null;

if( $id_user == null )
{
  header( 'location:../panel.php?categoria=cuentas&mensaje=warning' );
  return;
}

$consulta = "SELECT `estado` FROM usuarios WHERE `id` = '$id_user'";
$resultado = mysqli_query( $conexion, $consulta ) or die( "No se ha podido realizar la consulta" );

if( mysqli_num_rows( $resultado ) >= 1 ) 
{
  $columna = mysqli_fetch_array( $resultado );

  $consulta = "DELETE FROM `usuarios` WHERE `usuarios`.`id` = '$id_user'";
  $resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );
  
  header( 'location:../panel.php?categoria=cuentas&mensaje=success' );
  return;
}
else
{
  header( 'location:../panel.php?categoria=cuentas&error=El usuario especificado no existe' );
  return;
}
    
?>