<?php 
include_once('db.php');

session_start();

if( !isset( $_SESSION[ 'loggedin' ] ) || $_SESSION[ 'user_level'] == 'usuario' )
{
  header( 'location:../index.php?categoria=login' );
  exit;
}

$id_producto = isset( $_GET[ 'id_produc' ] ) ? $_GET[ 'id_produc' ] : null;

if( $id_producto == null)
{
  header( 'location:../panel.php?categoria=inventario&mensaje=warning' );
  return;
}

$Categoria = isset($_POST[ 'categoria' ]) ? $_POST[ 'categoria' ] : null;
$Nombre = isset($_POST[ 'nombre' ]) ? $_POST[ 'nombre' ] : null;
$Descripcion = isset($_POST[ 'descripcion' ]) ? $_POST[ 'descripcion' ] : null;
$Precio = isset($_POST[ 'precio' ]) ? $_POST[ 'precio' ] : null;
$Cantidad = isset($_POST[ 'cantidad' ]) ? $_POST[ 'cantidad' ] : null;

if( $Categoria == null || $Nombre == null )
{
  header( 'location:../panel.php?categoria=inventario&mensaje=warning' );
  return;
}

$file_name =  $_FILES[ 'imagen' ][ 'name' ];
$file_namer = strtolower( $file_name );
$cd = $_FILES[ 'imagen' ][ 'tmp_name' ];
$ruta = "../img/productos/".$_FILES[ 'imagen' ][ 'name' ];
$destino = "img/productos/".$file_namer;

$resultado = @move_uploaded_file( $cd, $ruta);

if(!empty( $resultado ) )
{
	$consulta = "UPDATE `productos` SET `categoria`= '$Categoria', `foto_prod`= '$destino', `nombre_prod`= '$Nombre',`descripcion`= '$Descripcion', `precio`= '$Precio', `cantidad`= '$Cantidad' WHERE `productos`.`id_prod` = '$id_producto'";
	$resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );
	
	header( 'location:../panel.php?categoria=inventario&mensaje=success' );
} else
	header( 'location:../panel.php?categoria=inventario&mensaje=warning' );
?>