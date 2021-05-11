<?php
include_once('db.php');

session_start();

if( !isset( $_SESSION[ 'loggedin' ] ) || $_SESSION[ 'user_level'] != 'super' )
{
  header( 'location:../index.php?categoria=login' );
  return;
}

define( 'USER_LEVEL', 'admin' );

$correo = isset($_POST[ 'correo' ]) ? $_POST[ 'correo' ] : null;
$clave = isset($_POST[ 'clave' ]) ? $_POST[ 'clave' ] : null;
$clave_confirmar = isset($_POST[ 'clave_confirmar' ]) ? $_POST[ 'clave_confirmar' ] : null;

if( $correo == null || $clave == null )
{
  header( 'location:../panel.php?categoria=cuentas&mensaje=warning' );
  return;
}


$consulta  = "SELECT * FROM `usuarios` WHERE `username` = '$correo'";
$resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );

if( mysqli_num_rows( $resultado ) >= 1 ) 
{
  header( "location:../panel.php?categoria=add_admin&error=El correo $correo se encuentra en uso" );
  return;
}
else
{
  if( $clave === $clave_confirmar )
  {
    $consulta  = "INSERT INTO `usuarios` VALUES ( NULL, '$correo', '$clave', '".USER_LEVEL."', NULL, '1' )";
    $resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );
    
    header( 'location:../panel.php?categoria=cuentas&mensaje=success' );
  }
  else
    header( "location:../panel.php?categoria=add_admin&error=La contraseña no coincide" );

  return;
}
?>