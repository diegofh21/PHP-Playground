<?php
if( !isset( $_SESSION[ 'loggedin' ] ) )
{
  header( 'location:index.php' );
  return;
}

$mensaje = isset($_GET[ 'mensaje' ]) ? $_GET[ 'mensaje' ] : null;
$error = isset($_GET[ 'error' ]) ? $_GET[ 'error' ] : null;
$log = null;

$consulta = "SELECT * FROM `tarjetas` WHERE `id_persona` = '".$_SESSION[ 'id_persona' ]."'";
$resultado = mysqli_query( $conexion, $consulta ) or die( "No se ha podido realizar la consulta" );

if( mysqli_num_rows( $resultado ) <=0 ) 
  $log = "<tr><td><div class='text-center mt-3'><span class='text-danger display-5'>No existen tarjetas disponibles</span></div></td></tr>";

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

<div class="container bg-dark mx-auto mt-4 text-white p-3">
  <h2 class="text-center text-white">Editar datos</h2>
  <hr>
  <div id="acordion">
    <div class="card">
      <div class="card-header">
        <a href="#addcards" class="card-link text-warning" data-toggle="collapse" data-parent="#acordion">Tarjetas de pago</a>
      </div>
      
      <div id="addcards" class="collapse">
        <div class="card-body">

        <div class="title d-flex flex-wrap justify-content-between">
          <h2 class="text-dark">Tarjetas</h2>
          <a class="ml-2 btn btn-primary align-self-center" href="index.php?categoria=add_card">+ Agregar</a>
        </div>
        <table class="table table-success text-center">
          <thead class="bg-primary text-white">
            <tr>
              <td>Id</td>
              <td>Numero</td>
              <td>Fech. Expiracion</td>
              <td>Tipo</td>
              <td>Estado</td>
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
                ++$cant_columnas;
              ?>
              <tr>
                <td> <?php echo $cant_columnas;?> </td>
                <td> <?php echo $columna[ 'num_tarjeta' ]; ?> </td>
                <td> <?php echo $columna[ 'mes_exp' ]; ?>/<?php echo $columna[ 'year_exp' ]; ?> </td>
                <td> <?php echo $columna[ 'tipo_tarjeta' ]; ?> </td>
                <td class="<?php if($columna[ 'estado' ]) { echo 'text-success'; } else { echo 'text-danger'; } ?>"> <?php if($columna[ 'estado' ]) { echo 'Activa'; } else { echo 'Vencida'; } ?> </td>
                <td>
                  <a id="confirm" class="btn btn-danger" href="procesos/delete-card.php?id_card=<?php echo $columna[ 'id_tarjeta' ]; ?>">Eliminar</a>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>

        </div>
      </div>
    </div>
  </div>

  <hr>

  <div id="acordion">
    <div class="card">
      <div class="card-header">
        <a href="#facturas" class="card-link text-primary" data-toggle="collapse" data-parent="#acordion">Facturas de Compras</a>
      </div>
      
      <div id="facturas" class="collapse">
        <div class="card-body">

        <div class="title d-flex flex-wrap justify-content-between">
          <h2 class="text-dark">Historial de Compras</h2>
          <!-- <a class="ml-2 btn btn-primary align-self-center" href="index.php?categoria=add_card">+ Agregar</a> -->
        </div>
        <table class="table table-success text-center">
          <thead class="bg-primary text-white">
            <tr>
              <td>Id</td>
              <td>Cliente</td>
              <td>Cedula</td>
              <td>Total</td>
              <td>Estado</td>
              <td>Accion</td>
            </tr>
          </thead>
          <tbody>
            <?php

              $consulta_cl = "SELECT * FROM `personas` where id_persona = '".$_SESSION['id_persona']."'";
              $resultado_cl = mysqli_query( $conexion, $consulta_cl ) or die( "No se ha podido realizar la consulta" );   

              $columna_persona = $resultado_cl->fetch_assoc();

              $consulta_fac = "SELECT * FROM `factura` where id_persona = '".$_SESSION['id_persona']."'";
              $resultado_fac = mysqli_query( $conexion, $consulta_fac ) or die( "No se ha podido realizar la consulta" ); 

              if( $log != null )
                echo $log;

              $cant_columnas = 0;

              while( $columna_fac = $resultado_fac->fetch_assoc( ) )
              {
                ++$cant_columnas;
              ?>
              <tr>
                <td> <?php echo $cant_columnas;?> </td>
                <td> <?php echo $columna_persona[ 'nombres' ];    ?> </td>
                <td> <?php echo $columna_persona[ 'cedula'  ];    ?> </td>
                <td> <?php echo $columna_fac[ 'total'   ];    ?> </td>
                <td class="<?php if( $columna_fac[ 'estado'   ]) { echo "text-success"; } else { echo "text-danger"; }?>"> <?php if( $columna_fac['estado']) { echo "Aprobada"; } else { echo "No aprobada"; }?> </td>
                <td>
                  <a id="confirm" target="_blank" class="btn btn-primary text-white" href="procesos/facturapdf.php?factura_id=<?php echo $columna_fac[ 'id_factura'   ];?>">Imprimir</a>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>

        </div>
      </div>
    </div>
  </div>
  
  <hr>

  <div id="acordion">
    <div class="card">
      <div class="card-header">
        <a href="#changepassword" class="card-link text-success" data-toggle="collapse" data-parent="#acordion">Cambiar clave</a>
      </div>
      <div id="changepassword" class="collapse">
        <div class="card-body">

        <div class="col-12 col-md-5 ml-auto mr-auto p-4">
          <form action="procesos/password-change.php" method="POST">
            <div class="form-group">
              <input type="password" class="form-control" name="clave_actual" required placeholder="Clave actual">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="clave_nueva" required placeholder="Clave nueva">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="clave_confirmar" required placeholder="Confirmar clave">
            </div>

            <div class="form-group text-center">
              <input class="btn btn-success" type="submit" value="Guardar">
              <a class="btn btn-danger" href="index.php?categoria=edit_perfil">Cancelar</a>
            </div>
          </form>
        </div>

        </div>
      </div>
    </div>
  </div>

  <script>
    ( () => 
    {
      window.onload   = function()
      {
        var div_confirm = document.querySelectorAll( '#confirm' );
        var div_fade = document.querySelectorAll( '#fade-seconds' );

        div_confirm.forEach(button => {
          button.addEventListener( "click", (e) => {
            let opcion = confirm('¿Estas seguro de que quieres avanzar?');

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