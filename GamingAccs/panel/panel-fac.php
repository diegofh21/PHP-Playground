<?php
$mensaje = isset($_GET[ 'mensaje' ]) ? $_GET[ 'mensaje' ] : null;
$consulta = null;
$log = null;

$consulta = "SELECT * FROM factura WHERE `estado` != '1'";
$resultado = mysqli_query( $conexion, $consulta ) or die( "No se ha podido realizar la consulta" );

if( mysqli_num_rows( $resultado ) <=0 ) 
  $log = "<div class='text-center mt-3'><span class='text-danger display-5'>No existen facturas</span></div>";

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
}?>


<div class="container bg-white p-4">
<h2 class="text-center">Facturas no aprobadas</h2>
<hr>
<?php 
  while( $columna = mysqli_fetch_array( $resultado ) )
  {?>
  <div id="acordion" class="mt-2">
    <div class="card">
      <div class="card-header">
        <a href="#fac_<?php echo $columna[ 'id_factura' ]?>" class="card-link text-success" data-toggle="collapse" data-parent="#acordion">ID FACTURA #<?php echo $columna[ 'id_factura' ]?></a>
      </div>
      <div id="fac_<?php echo $columna[ 'id_factura' ]?>" class="collapse">
        <div class="card-body">
          <p>DESCRIPCION:<?php echo $columna[ 'descripcion' ]?></p>
          <p class="text-center text-success">TOTAL $<?php echo $columna[ 'total' ]?></p>
          <div class="btn-group">
            <a id="confirm" class="btn btn-warning" href="procesos/aprobar.php?id_factura=<?php echo $columna[ 'id_factura' ]?>">Aprobar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php }?>

  <script>
            ( () => 
            {
              window.onload   = function()
              {
                var div_confirm = document.querySelectorAll( '#confirm' );
                var div_fade = document.querySelectorAll( '#fade-seconds' );

                div_confirm.forEach(button => {
                  button.addEventListener( "click", (e) => {
                    let opcion = confirm('¿Estas seguro de que quieres aprobar la factura?');

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