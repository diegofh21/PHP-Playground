<?php
require( 'procesos/db.php' );

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
<div class="container push-cont">
  <?php
    $consulta = "SELECT * FROM productos WHERE `categoria` = '$Categoria'";

    $resultado = mysqli_query( $conexion, $consulta ) or die( "No se ha podido realizar la consulta" );
  ?>
  <div class="containpc mb-5">
    <h3 class="text-center pt-4"> <img src="utils/logo-categoria-pc.png" alt="" width=10%>Hardware y Accesorios<img src="utils/laptop-logo.png" alt="" width=10%></h2>
    <h6 class="text-center pt-2">Actualizate para jugar siempre al máximo!</h4>
    <?php
    if( mysqli_num_rows( $resultado ) <=0 ) 
    {
      echo "<div class='text-center mt-3'><span class='text-danger display-5'>No existen productos disponibles</span></div>";
    }
    ?>
    <hr class="mt-4 mb-4 own">
  <?php
    while( $columna = mysqli_fetch_array( $resultado ) )
    {?>
      <div class="contpc">
        <img src="<?php echo $columna[ 'foto_prod' ]; ?>" alt="PC" class="ml-3"width=20%>
        <div class="titlepc">
          <p> <?php echo ( $columna[ 'nombre_prod' ]." - ".$columna[ 'descripcion' ] ); ?> </p>
          <p>Precio: <span class="precio"> $<?php echo $columna[ 'precio' ]; ?> </span></p>
          <a href="procesos/add-car.php?categoria=hardware&producto=<?php echo $columna[ 'id_prod' ]; ?>" class="boton boton-comprar">Agregar</a>
          <p class="stock">Disponibles: <span class="nstock"> <?php echo $columna[ 'cantidad' ]; ?> </span></p>
        </div>
      </div>
  <?php }?>
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
