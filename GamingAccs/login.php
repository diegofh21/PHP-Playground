<?php
$mensaje  = isset($_GET[ 'mensaje' ]) ? $_GET[ 'mensaje' ] : null;
$error    = isset($_GET[ 'error' ]) ? $_GET[ 'error' ] : null;

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

<div class="container-login">
	<div class="login col-12 col-md-6 col-lg-4">
		<h1 class="text-center mb-5 text-white">Iniciar Sesión</h1>
		<form action="index.php?categoria=login&valid=1<?php if( $ex_categoria ) { echo "&excategoria=$ex_categoria"; }?>" method='post'>
			<div class="form-group">
				<input class="form-control" type="email" placeholder="Correo" name="user" required>
			</div>
			<div class="form-group">
				<input class="form-control" type="password" placeholder="Contraseña" name="password" required>
			</div>
			<div class="form-group">
				<input class="form-control btn btn-primary" type="submit">
			</div>
			<div class="mt-2 form-group text-center">
				<a class="text-link" href="index.php?categoria=recuperar">¿Has olvidado tu contraseña?</a>
			</div>
			<div class="form-group text-center">
				<a class="text-link" href="index.php?categoria=registro">¿Nuevo Usuario? Registrate aquí!</a>
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
