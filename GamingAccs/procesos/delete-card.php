<?php
include_once('db.php');

session_start();

if( !isset( $_SESSION[ 'loggedin' ] ) || $_SESSION[ 'user_level'] != 'usuario' )
{
  header( 'location:../index.php?categoria=login' );
  exit;
}

$id_card = isset($_GET[ 'id_card' ]) ? $_GET[ 'id_card' ] : null;

if( $id_card == null )
{
  header( 'location:../index.php?categoria=edit_perfil&mensaje=warning' );
  return;
}

$consulta = "SELECT `estado` FROM tarjetas WHERE `id_persona` = '".$_SESSION['id_persona']."' AND `id_tarjeta` = '$id_card' ";
$resultado = mysqli_query( $conexion, $consulta ) or die( "No se ha podido realizar la consulta" );

if( mysqli_num_rows( $resultado ) >= 1 ) 
{
  $columna = mysqli_fetch_array( $resultado );

  $consulta = "DELETE FROM `tarjetas` WHERE `tarjetas`.`id_persona` = '".$_SESSION['id_persona']."' AND `tarjetas`.`id_tarjeta` = '$id_card'";
  $resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );
  
  header( 'location:../index.php?categoria=edit_perfil&mensaje=success' );
  return;
}
else
{
  header( 'location:../index.php?categoria=edit_perfil&error=La tarjeta especificada no existe' );
  return;
}
    
?>