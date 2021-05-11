<?php
$search = isset($_GET[ 'search' ]) ? $_GET[ 'search' ] : null;
$mensaje = isset($_GET[ 'mensaje' ]) ? $_GET[ 'mensaje' ] : null;
$consulta = null;
$log = null;

if( $search == null )
  $search = 'todo';

switch( $search )
{
  case 'todo': 
  {
    $consulta = "SELECT * FROM productos";
    break;
  }
  case 'computadora':
  {
    $consulta = "SELECT * FROM productos WHERE `categoria` = '$search'";
    break;
  }
  case 'laptop':
  {
    $consulta = "SELECT * FROM productos WHERE `categoria` = '$search'";
    break;
  }
  case 'hardware':
  {
    $consulta = "SELECT * FROM productos WHERE `categoria` = '$search'";
    break;
  }
}

$resultado = mysqli_query( $conexion, $consulta ) or die( "No se ha podido realizar la consulta" );
if( mysqli_num_rows( $resultado ) <=0 ) 
  $log = "<div class='text-center mt-3'><span class='text-danger display-5'>No existen productos disponibles</span></div>";

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

<div id="acordion">
  <div class="card">
    <div class="card-header">
      <a href="#addproducts" class="card-link text-success" data-toggle="collapse" data-parent="#acordion">+ Agregar producto</a>
    </div>
    <div id="addproducts" class="collapse">
      <div class="card-body">

        <form action="procesos/addproducts.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="categoria">Categoria</label>
            <select id="categoria" class="form-control" name="categoria">
              <option  value="computadora">Computadoras</option>
              <option value="laptop">Laptops</option>
              <option value="hardware">Hardware</option>
            </select>
          </div>

          <div class="form-group">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
          </div>

          <div class="form-group">
            <textarea name="descripcion" class="form-control descripcion"  cols="30" rows="10" placeholder="Descripcion" required></textarea>
          </div>

          <div class="form-group">
            <input type="file" class="form-control" name="imagen" required placeholder="imagen" maxlength="150">
          </div>
          <div class="form-group">
            <input type="number" min="1" name="precio" class="form-control" placeholder="Precio" required>
          </div>

          <div class="form-group">
            <input type="number" name="cantidad" class="form-control" min="1" placeholder="Cantidad" required>
          </div>

          <div class="form-group text-center">
            <input type="submit" class="btn btn-success" value="Agregar">
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<div id="acordion" class="mt-2">
  <div class="card">
    <div class="card-header">
      <a href="#inventario" class="card-link text-warning" data-toggle="collapse" data-parent="#acordion">- Inventario</a>
    </div>
    <div id="inventario" class="collapse show">
      <div class="card-body">
        <div class="search-inv">

          <div class="btns d-flex justify-content-between flex-wrap b-dark"> 
            <a class="btn <?php if($search != 'todo') echo 'prop-disabled';?>" href="panel.php?categoria=inventario&search=todo">Todo</a>
            <a class="btn <?php if($search != 'computadora') echo 'prop-disabled';?>" href="panel.php?categoria=inventario&search=computadora">Computadoras</a>
            <a class="btn <?php if($search != 'laptop') echo 'prop-disabled';?>" href="panel.php?categoria=inventario&search=laptop">Laptops</a>
            <a class="btn <?php if($search != 'hardware') echo 'prop-disabled';?>" href="panel.php?categoria=inventario&search=hardware">Hardware</a>
          </div>

          <div class="contenido mt-4">
            <?php
            if( $log != null)
              echo $log;
            else
            {
            ?>
            <table class="table table-success text-center content-table">
              <thead class="bg-primary text-white">
                <tr>
                  <td>Id</td>
                  <td>Foto</td>
                  <td>Nombre</td>
                  <td>Categoria</td>
                  <td>Precio</td>
                  <td>Cantidad</td>
                  <td>Accion</td>
                </tr>
              </thead>
              <tbody>
                <?php
                $cant_columnas = 0;

                while( $columna = mysqli_fetch_array( $resultado ) )
                {
                  ++$cant_columnas;
                ?>
                  <tr>
                    <td> <?php echo $cant_columnas;?> </td>
                    <td><img src="<?php echo $columna[ 'foto_prod' ]; ?>" alt="PC" class="ml-3" width="50" height="40"></td>
                    <td> <?php echo $columna[ 'nombre_prod' ]; ?> </td>
                    <td> <?php echo $columna[ 'categoria' ]; ?> </td>
                    <td> <span class="precio"> $<?php echo $columna[ 'precio' ]; ?> </span> </td>
                    <td> <?php echo $columna[ 'cantidad' ]; ?> </td>
                    <td>
                      <a class="btn btn-warning" href="panel.php?categoria=modificar_inv&id_produc=<?php echo $columna[ 'id_prod' ]; ?>">Editar</a>
                      <a id="confirm" class="btn btn-danger" href="procesos/delete-produc.php?id_product=<?php echo $columna[ 'id_prod' ]; ?>">Borrar</a>
                    </td>
                  </tr>
              <?php }?>
              </tbody>
            </table>
            <?php }?>
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
                    let opcion = confirm('¿Estas seguro de que quieres eliminar el producto?');

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
    </div>
  </div>
</div>