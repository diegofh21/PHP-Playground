<?php
$username = isset($_POST[ 'user' ]) ? $_POST[ 'user' ] : null;
$password = isset($_POST[ 'password' ]) ? $_POST[ 'password' ] : null;

if( $username == null || $password == null ) 
{
  header( 'location:index.php?categoria=login&error=Estas alterando la pagina' );
  return;
}

$consulta = "SELECT * FROM usuarios WHERE `username` = '$username' AND `password` = '$password'";

$resultado = mysqli_query( $conexion, $consulta ) or die( "No se ha podido realizar la consulta" );

if( mysqli_num_rows( $resultado ) >= 1 ) 
{
  $columna = mysqli_fetch_array( $resultado );

  if( !$columna[ 'estado' ] )
  {
    header( 'location:index.php?categoria=login&error=Tu usuario se encuentra suspendido' );
    return;
  }

  $_SESSION[ 'user_level'] = $columna[ 'level' ];
  $_SESSION[ 'id_user' ] = $columna[ 'id' ];

  if( $columna[ 'id_persona' ] != null )
  {
    $consulta = "SELECT * FROM `personas` WHERE `id_persona` LIKE '".$columna[ 'id_persona' ]."'";
    $resultado = mysqli_query( $conexion, $consulta ) or die ( "Error: En la consulta: ".$consulta );

    $columna = mysqli_fetch_array( $resultado );
    $_SESSION[ 'nombre' ]   = $columna[ 'nombres' ];
    $_SESSION[ 'id_persona' ]   = $columna[ 'id_persona' ];
  } 
  else
  {
    $_SESSION[ 'nombre' ]   = $username;
    $_SESSION[ 'id_persona' ]   = null;
  }

  $_SESSION[ 'loggedin' ] = true;
  $_SESSION[ 'username' ] = $username;

  switch( $_SESSION[ 'user_level' ] )
  {
    case 'usuario': {
      if( $ex_categoria )
      {
        header( "location:index.php?categoria=$ex_categoria" );
        break;
      }

      header( "location:index.php" );
      break;
    }
    case 'admin': 
    case 'super':  {
      header( 'location:panel.php' );
      break;
    }
  }
} else {
  header( 'location:index.php?categoria=login&error=Usuario o clave incorrectos' );
}

return;

?>