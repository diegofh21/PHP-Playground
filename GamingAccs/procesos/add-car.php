<?php
include_once('db.php');

session_start();

if( $_SESSION[ 'user_level'] != 'usuario' )
{
  header( "location:../index.php?categoria=login" );
  return;
}

$id_producto  = isset($_GET[ 'producto' ]) ? $_GET[ 'producto' ] : null;
$categoria    = isset($_GET[ 'categoria' ]) ? $_GET[ 'categoria' ] : null;

if( $id_producto == null || $categoria == null )
{
  header( "location:../index.php?categoria=$categoria&mensaje=warning" );
  return;
} else if( !isset( $_SESSION[ 'loggedin' ] ) )
{
  header( "location:../index.php?categoria=login&excategoria=$categoria" );
  return;
}

if( check_car() )
{
  if( array_key_exists( "$id_producto", $_SESSION[ 'car' ] ) )
  {
    $cantidad = $_SESSION[ 'car' ]["$id_producto"];

    ++$cantidad;

    $_SESSION[ 'car' ]["$id_producto"] = $cantidad;
  }
  else
    $_SESSION[ 'car' ]["$id_producto"] = 1;

  header( "location:../index.php?categoria=$categoria&mensaje=success" );
  return;

}
else 
{
  header( "location:../index.php?categoria=$categoria&mensaje=warning" );
  return;
}

function check_car()
{
  $is_ready = false;
  
  if( !isset( $_SESSION['car'] ) )
    $_SESSION[ "car" ] = array();
    
  $is_ready = isset( $_SESSION[ 'car' ] ) ? true : false;

  return $is_ready;
}


header( "location:../index.php?categoria=$categoria&mensaje=success" );
return;
?>