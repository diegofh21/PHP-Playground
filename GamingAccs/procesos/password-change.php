<?php
include_once('db.php');

session_start();

if( !isset( $_SESSION[ 'loggedin' ] ) )
{
  header( 'location:../index.php?categoria=login' );
  exit;
}

$clave_actual = isset( $_POST[ 'clave_actual' ] ) ? $_POST[ 'clave_actual' ] : null ;
$clave_nueva = isset( $_POST[ 'clave_nueva' ] ) ? $_POST[ 'clave_nueva' ] : null ;
$clave_confirmar = isset( $_POST[ 'clave_confirmar' ] ) ? $_POST[ 'clave_confirmar' ] : null ;

if( $clave_actual == null || $clave_nueva == null )
{
  if( $_SESSION[ 'user_level'] == 'usuario' )
    header( 'location:../index.php?categoria=edit_perfil&mensaje=warning' );
  else
    header( 'location:../panel.php?categoria=change_paassword&mensaje=warning' );
  return;
}

if( $clave_nueva === $clave_confirmar )
{
  $consulta = "SELECT * FROM usuarios WHERE `username` = '".$_SESSION[ 'username' ]."' AND `password` = '$clave_actual'";
  $resultado = mysqli_query( $conexion, $consulta ) or die( "No se ha podido realizar la consulta" );

  if( mysqli_num_rows( $resultado ) >= 1 ) 
  {
    $columna = mysqli_fetch_array( $resultado );

    $consulta = "UPDATE `usuarios` SET `password`= '$clave_nueva' WHERE `usuarios`.`id` = '".$columna['id']."'";
    $resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );
    
    if( $_SESSION[ 'user_level'] == 'usuario' )
      header( 'location:../index.php?categoria=edit_perfil&mensaje=success' );
    else
      header( 'location:../panel.php?categoria=cuentas&mensaje=success' );
    return;
  } 
  else 
  {
    if( $_SESSION[ 'user_level'] == 'usuario' )
      header( 'location:../index.php?categoria=edit_perfil&error=Tu contraseña actual es invalidad' );
    else
      header( 'location:../panel.php?categoria=change_paassword&error=Tu contraseña actual es invalidad' );
    return;
  }
} 
else 
{
  if( $_SESSION[ 'user_level'] == 'usuario' )
    header( 'location:../index.php?categoria=edit_perfil&error=La contraseña no coincide' );
  else
    header( 'location:../panel.php?categoria=change_paassword&error=La contraseña no coincide' );
}

return;
?>