<?php
include_once('db.php');

session_start();

if( !isset( $_SESSION[ 'loggedin' ] ) || $_SESSION[ 'user_level'] != 'usuario' )
{
  header( 'location:../index.php?categoria=login' );
  return;
}

$titular = isset($_POST[ 'titular' ]) ? $_POST[ 'titular' ] : null;
$numero = isset($_POST[ 'numero' ]) ? $_POST[ 'numero' ] : null;
$cvv = isset($_POST[ 'cvv' ]) ? $_POST[ 'cvv' ] : null;
$mes_exp = isset($_POST[ 'mes_exp' ]) ? $_POST[ 'mes_exp' ] : null;
$year_exp = isset($_POST[ 'year_exp' ]) ? $_POST[ 'year_exp' ] : null;
$type_card = isset($_POST[ 'tipo' ]) ? $_POST[ 'tipo' ] : null;

if( $titular == null || $numero == null || $cvv == null || $type_card == null )
{
  header( 'location:../index.php?categoria=edit_perfil&mensaje=warning' );
  return;
}

$consulta  = "SELECT * FROM `tarjetas` WHERE `id_persona` = '".$_SESSION['id_persona']."'";
$resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );
$existe = false;

if( mysqli_num_rows( $resultado ) >= 1 ) 
{
  while( $columna = mysqli_fetch_array( $resultado ) )
  {
    if( $columna[ 'num_tarjeta' ] == $numero )
    {
      $existe = true;
      break;
    }
  }
}

if( !$existe )
{
  $consulta  = "INSERT INTO `tarjetas` VALUES ( NULL, '".$_SESSION['id_persona']."', '$numero', '$cvv', '$mes_exp', '$year_exp', '$type_card', '1' )";
  $resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );
  
  header( 'location:../index.php?categoria=edit_perfil&mensaje=success' );
}
else 
  header( "location:../index.php?categoria=add_card&error=La tarjeta $numero se encuentra agregada" );

return;
?>