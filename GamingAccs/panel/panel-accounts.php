<?php
$mensaje = isset($_GET[ 'mensaje' ]) ? $_GET[ 'mensaje' ] : null;
$error = isset($_GET[ 'error' ]) ? $_GET[ 'error' ] : null;
$log = null;

$consulta = "SELECT * FROM usuarios WHERE `level` = 'admin'";
$resultado = mysqli_query( $conexion, $consulta ) or die( "No se ha podido realizar la consulta" );

if( mysqli_num_rows( $resultado ) <=0 ) 
  $log = "<tr><td><div class='text-center mt-3'><span class='text-danger display-5'>No existen cuentas disponibles</span></div></td></tr>";

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
<div class="container d-flex flex-column flex-nowrap bg-white p-4 h-100">
	<div class="global-account">
    <div class="title d-flex flex-wrap justify-content-between">
      <h2>Administradores</h2>
      <?php if( $_SESSION[ 'user_level' ] == 'super') {?>
        <a class="ml-2 btn btn-primary align-self-center" href="panel.php?categoria=add_admin">+ Agregar</a>
      <?php }?>
    </div>
		<table class="table table-success text-center">
			<thead class="bg-primary text-white">
				<tr>
					<td>Id</td>
					<td>Usuario</td>
					<td>Nivel</td>
					<td>Accion</td>
				</tr>
			</thead>
			<tbody>
				<?php
          if( $log != null )
            echo $log;

          $cant_columnas = 0;

          while( $columna = mysqli_fetch_array( $resultado ) )
          {
          	if($columna[ 'username' ] == $_SESSION[ 'username'] )
          		continue;

            ++$cant_columnas;
          ?>
          <tr>
            <td> <?php echo $cant_columnas;?> </td>
            <td> <?php echo $columna[ 'username' ]; ?> </td>
            <td class="<?php if($columna[ 'estado' ]) { echo 'text-success'; } else { echo 'text-danger'; } ?>"> <?php echo $columna[ 'level' ]; ?> </td>
            <td>
              <a id="confirm" class="btn <?php if($columna[ 'estado' ]) { echo 'btn-warning'; } else { echo 'btn-success'; } ?>" href="procesos/toggle-account.php?id_user=<?php echo $columna[ 'id' ]; ?>"> <?php if($columna[ 'estado' ]) { echo 'Suspender'; } else { echo 'Activar'; } ?> </a>
              <?php
              if( $_SESSION[ 'user_level'] == 'super') {
              ?>
              <a id="confirm" class="btn btn-danger" href="procesos/delete-account.php?id_user=<?php echo $columna[ 'id' ]; ?>">Eliminar</a>
            <?php }?>
            </td>
          </tr>
        <?php }?>
			</tbody>
		</table>
	</div>
	<hr>
	<div class="my-account">
		<h2 class="text-center">Mi cuenta</h2>
		<table class="table table-success text-center">
			<thead class="bg-primary text-white">
				<tr>
					<td>Usuario</td>
					<td>Nivel</td>
					<td>Accion</td>
				</tr>
			</thead>
			<tbody>
          <tr>
            <td> <?php echo $_SESSION[ 'username' ]; ?> </td>
            <td class="text-success"> <?php echo $_SESSION[ 'user_level' ]; ?> </td>
            <td>
              <a class="btn btn-success" href="panel.php?categoria=change_paassword">Cambiar clave</a>
            </td>
          </tr>
			</tbody>
		</table>

		<script>
    ( () => 
    {
      window.onload   = function()
      {
        var div_confirm = document.querySelectorAll( '#confirm' );
        var div_fade = document.querySelectorAll( '#fade-seconds' );

        div_confirm.forEach(button => {
          button.addEventListener( "click", (e) => {
            let opcion = confirm('¿Estas seguro de que quieres realizar la siguiente accion?');

            if( !opcion )
              e.preventDefault();
          });
        });

        div_fade.forEach(mesagge => {
          $( '#fade-seconds' ).fadeOut( 3000 );
        });
      }
    }).call(this);
  </script>
	</div>
</div>