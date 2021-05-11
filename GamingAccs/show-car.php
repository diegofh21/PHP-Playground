<?php
if( !isset( $_SESSION[ 'loggedin' ] ) )
{
  header( 'location:index.php' );
  return;
}

$mensaje = isset($_GET[ 'mensaje' ]) ? $_GET[ 'mensaje' ] : null;
$error = isset($_GET[ 'error' ]) ? $_GET[ 'error' ] : null;
$log = null;

$consulta_card = "SELECT * FROM `tarjetas` WHERE `id_persona` = '".$_SESSION[ 'id_persona' ]."' AND `estado` = true";
$resultado_card = mysqli_query( $conexion, $consulta_card ) or die( "No se ha podido realizar la consulta" );

if( mysqli_num_rows( $resultado_card ) <=0 ) 
  $log = "<option class='text-danger display-5' value='-1'>No existen tarjetas disponibles o activas...</option>";

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
<script>
  var productos = [];
</script>
<div class="container bg-white my-5 p-0">
  <h2 class="text-center py-4">Carrito</h2>
  <hr>
  <div class="factura">
    <div class="info-produc p-3">
      <?php if( isset( $_SESSION[ "car" ]) && count($_SESSION[ "car" ]) >=1  ) { ?>
        <form action="procesos/pago-car.php" method="post">
          <table class="table table-secondary text-secondary text-center">
            <thead>
              <tr class="bg-dark text-white">
                <td>Id</td>
                <td>Producto</td>
                <td>Cantidad</td>
                <td>Precio</td>
              </tr>
            </thead>
            <tbody>
              <?php

              $cant_row = 0;
              $total_price = 0.0;
              $total_prod =0;

              foreach ( $_SESSION[ "car" ] as $id_product => $value) {
                $consulta = "SELECT * FROM `productos` WHERE `id_prod` = '$id_product'";
                $resultado = mysqli_query( $conexion, $consulta ) or die( "No se ha podido realizar la consulta" );

                echo "<tr>";
                while( $columna = mysqli_fetch_array( $resultado ) )
                {
                  $total_prod+= $value;
                  ++$cant_row;
                  $total_price += ($columna[ 'precio' ]*$value);
                  echo "<td>$cant_row <input type='number' name='id_".$cant_row."' hidden value='".$columna[ 'id_prod' ]."'></td>";
                  echo "<td>".$columna[ 'nombre_prod' ]."</td>";
                  echo "<td class='d-flex flex-row flex-nowrap'><input id='valid-produc' id_producto='$id_product' class='form-control table-input m-auto' type='number' name='cantidad_".$cant_row."' min='1' max='".$columna[ 'cantidad' ]."' required value='$value'>/".$columna[ 'cantidad' ]."</td>";
                  echo "<td class='text-success'>$ <input id='update-produc' id_producto='$id_product' class='form-control table-input m-auto' type='number' min='".$columna[ 'precio' ]."' name='precio_".$cant_row."' required value='".$columna[ 'precio' ]."'></td>";
                  echo "</td>";
                ?>

                <script type="text/javascript">
                  productos.push(
                    {<?php echo json_encode( $id_product ); ?> : <?php echo json_encode( $columna[ 'precio' ] ); ?> }
                  );             
                </script>
                <?php
                }
                echo "</tr>";
              }

              echo "<tr class='bg-dark text-white'>";
              echo "<td><span class='text-warning'>Total</td><td></td><td>$total_prod</td><td class='text-success'>$$total_price</td>";
              echo "</tr>";

              ?>
            </tbody>
          </table>
          <div class="form-group">
            <select name="tarjeta" id="" class="form-control" required>
              <?php
                  if( $log != null )
                    echo $log;

                  while( $columna = mysqli_fetch_array( $resultado_card ) )
                  {
                    echo "<option value='".$columna[ 'id_tarjeta' ]."'>".$columna[ 'num_tarjeta' ]." - ".$columna[ 'tipo_tarjeta' ]."</option>";
                  }?>
            </select>
          </div>
          <div class="btn-group d-flex alig-center justify-content-center">
              <input type="submit" class="btn btn-warning mr-2 col-12 col-md-2" value="Pagar" <?php if( $log != null ) { echo 'disabled'; }?>>
              <a id="confirm" class="btn btn-danger col-12 col-md-2" href="procesos/clean-car.php">Vaciar carrito</a>
          </div>
      </form>
      <?php } else {
        echo "<div class='text-center mt-3 py-4'><span class='text-danger display-5'>No existen productos en el carrito</span></div>";
      }
      ?>
    </div>
  </div>
  <script>
    ( () => 
    {
      window.onload   = function()
      {
        var div_confirm = document.querySelectorAll( '#confirm' );
        var div_fade = document.querySelectorAll( '#fade-seconds' );
        var inputs = document.querySelectorAll('#valid-produc');
        var inputs_price = document.querySelectorAll('#update-produc');

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

        inputs.forEach(input => {
          input.addEventListener( 'change', (e) => {
            let id_item = input.getAttribute( 'id_producto' );
            var price_item = 0.0;
            var total = 0;


            for (let index = 0; index < productos.length; index++) {
              if( productos[index][id_item] == undefined )
                continue;

              price_item = productos[index][id_item];
              break;
            }

            total = total_item(price_item, input.value);
            Update_prices(id_item, total);
          });
        });

        function total_item(price, cantidad) { 
          return (price*cantidad);
        }

        function Update_prices(id_producto, total)
        {
          inputs_price.forEach(input => {
            let id_price_id = input.getAttribute( 'id_producto' );

            if( id_price_id == id_producto)
              input.value = total;
          });
        }
      }
    }).call(this);
  </script>
</div>