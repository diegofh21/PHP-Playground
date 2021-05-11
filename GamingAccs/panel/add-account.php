<?php
if( $_SESSION[ 'user_level' ] != 'super')
{
  header( 'location:panel.php?categoria=cuentas&error=No tienes permiso para usar esta funcion' );
  return;
}

$mensaje = isset($_GET[ 'mensaje' ]) ? $_GET[ 'mensaje' ] : null;
$error = isset($_GET[ 'error' ]) ? $_GET[ 'error' ] : null;

if( $error != null)
  echo "<div id='fade-seconds' class='container my-4 text-center'><span class='alert alert-danger'>$error.</span></div>";

if( $mensaje != null)
{
  switch( $mensaje )
  {
    case 'success': 
    {
      echo "<div id='fade-seconds' class='container my-4 text-center'><span class='alert alert-success'>Accion realizada exitosamente.</span></div>";
      break;
    }
    case 'warning':
    {
      echo "<div id='fade-seconds' class='container my-4 text-center'><span class='alert alert-warning text-center'>No se puedo realizar la accion selecionada.</span></div>";
      break;
    }
  }
}
?>

<div class="container h-100 p-4">
  <h2 class="text-center text-success">Agregar admin</h2>
  <div class="col-12 col-md-5 ml-auto mr-auto mt-5 bg-dark p-4">
    <form action="procesos/add-account.php" method="POST">
      <div class="form-group">
        <input type="email" class="form-control" name="correo" required placeholder="Correo">
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="clave" required placeholder="Clave">
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="clave_confirmar" required placeholder="Confirmar clave">
      </div>

      <div class="form-group text-center">
        <input class="btn btn-success" type="submit" value="Guardar">
        <a class="btn btn-danger" href="panel.php?categoria=cuentas">Cancelar</a>
      </div>
    </form>
  </div>

  <script>
    ( () => 
    {
      window.onload   = function()
      {
        var div_fade = document.querySelectorAll( '#fade-seconds' );

        div_fade.forEach(mesagge => {
          $( '#fade-seconds' ).fadeOut( 3000 );
        });
      }
    }).call(this);
  </script>
</div>