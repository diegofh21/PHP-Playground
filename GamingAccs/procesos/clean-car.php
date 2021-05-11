<?php
session_start();

if( $_SESSION[ 'user_level'] != 'usuario' )
{
  header( "location:../index.php?categoria=login" );
  return;
}

if( isset( $_SESSION['car'] ) )
{
  $_SESSION['car'] = array();
}

header( "location:../index.php?categoria=mycar&mensaje=success" );
return;

?>