<?php
$Nombre = isset($_POST[ 'nombre' ]) ? $_POST[ 'nombre' ] : null;
$Cedula = isset($_POST[ 'cedula' ]) ? $_POST[ 'cedula' ] : null;
$Genero = isset($_POST[ 'genero' ]) ? $_POST[ 'genero' ] : null;
$Email  = isset($_POST[ 'email' ]) ? $_POST[ 'email' ] : null;
$Telefono = isset($_POST[ 'telefono' ]) ? $_POST[ 'telefono' ] : null;
$Direccion = isset($_POST[ 'direccion' ]) ? $_POST[ 'direccion' ] : null;
$Fec_nac  = isset($_POST[ 'fec_nac' ]) ? $_POST[ 'fec_nac' ] : null;
$Password = isset($_POST[ 'password' ]) ? $_POST[ 'password' ] : null;
$password_confirm = isset($_POST[ 'cpassword' ]) ? $_POST[ 'cpassword' ] : null;

if( $Nombre == null || $Cedula == null ) 
{
  header( 'location:index.php?categoria=login&error=Estas alterando la pagina' );
  return;
}

define( 'USER_LEVEL', 'usuario' );

$consulta = "SELECT * FROM `personas` WHERE `cedula` LIKE '$Cedula'";
$resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );

if( mysqli_num_rows( $resultado ) >= 1 )
{
  header( "location:index.php?categoria=registro&error=La cedula $Cedula ya se encuentra registrada" );
  return;
}

$consulta = "SELECT * FROM `usuarios` WHERE `username` LIKE '$Email'";
$resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );

if( mysqli_num_rows( $resultado ) >= 1 )
{
  header( "location:index.php?categoria=registro&error=El correo $Email ya esta en uso" );
  return;
}

if( $Password != $password_confirm )
{
  header( "location:index.php?categoria=registro&error=La contraseña no coincide" );
  return;
}

$consulta  = "INSERT INTO `personas` VALUES ( NULL, '$Nombre', '$Genero', '$Cedula', '$Email', '$Telefono', '$Fec_nac', '$Direccion' )";
$resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );

$consulta = "SELECT * FROM `personas` WHERE `cedula` LIKE '$Cedula'";
$resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );

if( mysqli_num_rows( $resultado ) >= 1 ) 
{
  $columna = mysqli_fetch_array( $resultado );

  $_SESSION[ 'id_persona' ]   = $columna[ 'id_persona' ];
  
  $consulta  = "INSERT INTO `usuarios` VALUES ( NULL, '$Email', '$Password', '".USER_LEVEL."', '".$columna[ 'id_persona' ]."', true )";
  mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );
  
  $consulta = "SELECT * FROM usuarios WHERE `username` = '$Email' AND `password` = '$Password'";
  $resultado = mysqli_query( $conexion, $consulta ) or die( "No se ha podido realizar la consulta" );
  $columna = mysqli_fetch_array( $resultado );

  $_SESSION[ 'loggedin' ]   = true;
  $_SESSION[ 'username' ]   = $Email;
  $_SESSION[ 'nombre' ]     = $Nombre;
  $_SESSION[ 'user_level']  = 'usuario';
  $_SESSION[ 'id_user']     = $columna[ 'id' ];
  
  header( 'location:index.php?categoria=mecanico' );
}
?>