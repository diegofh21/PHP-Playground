<?php
include_once('db.php');

session_start();

if( $_SESSION[ 'user_level'] != 'usuario' )
{
  header( "location:../index.php?categoria=login" );
  return;
}

$row_cantidad = 1;

$productos = [];
$productos_number = 0;
$total_prices  = 0;
$descripcion = "";

while( isset($_POST[ "cantidad_".$row_cantidad ]) )
{
  $id_prod = $_POST[ "id_".$row_cantidad ];
  $cantidad = $_POST[ "cantidad_".$row_cantidad ];
  $precio = $_POST[ "precio_".$row_cantidad ];
  $total = ($cantidad * $precio);

  $consulta = "SELECT * FROM productos WHERE `id_prod` = '$id_prod'";
  $resultado = mysqli_query( $conexion, $consulta ) or die( "No se ha podido realizar la consulta" );
  $columna = mysqli_fetch_array( $resultado );

  $descripcion = $descripcion."\nProducto: ".$columna['nombre_prod']." - Cantidad: ".$cantidad;

  $sobrante = ( $columna['cantidad'] - $cantidad); 
  $consulta = "UPDATE `productos` SET `cantidad`= '$sobrante' WHERE `productos`.`id_prod` = '$id_prod'";
  $resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );

  $total_prices += $total;
  $row_cantidad++;
}

$consulta  = "INSERT INTO `factura` VALUES ( NULL, '".$_SESSION['id_persona']."', '$descripcion', '$total_prices', 'false')";
$resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );

$_SESSION['car'] = array();
header( "location:../index.php?categoria=laptop&mensaje=success" );
return;
?>