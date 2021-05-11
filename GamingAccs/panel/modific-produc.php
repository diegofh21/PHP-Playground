<?php
$id_producto = isset( $_GET[ 'id_produc' ] ) ? $_GET[ 'id_produc' ] : null;

if( $id_producto == null)
{
  header( 'location:panel.php?categoria=inventario' );
  return;
}

$consulta = "SELECT * FROM productos WHERE `id_prod` = '$id_producto'";
$resultado = mysqli_query( $conexion, $consulta ) or die( "No se ha podido realizar la consulta" );

if( mysqli_num_rows( $resultado ) <=0 ) 
{
  echo "<div class='text-center mt-3 d-flex flex-column flex-nowrap'><span class='text-danger display-5'>No existe el producto indicado</span><a class='mt-2 btn btn-primary' href='panel.php?categoria=inventario'>Volver</a></div>";
  return;
}

$columna = mysqli_fetch_array( $resultado );

?>
<div class="container bg-white p-4">
  <h2 class="text-center text-success">Editar producto</h2>
  <form action="procesos/updateproducts.php?id_produc=<?php echo $id_producto?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="categoria">Categoria</label>
      <select id="categoria" class="form-control" name="categoria">
        <option  value="<?php echo $columna['categoria'];?>"><?php echo $columna['categoria'];?>(s)</option>
        <option  value="computadora">Computadoras</option>
        <option value="laptop">Laptops</option>
        <option value="hardware">Hardware</option>
      </select>
    </div>

    <div class="form-group">
      <input type="text" name="nombre" class="form-control" placeholder="Nombre" required value="<?php echo $columna['nombre_prod'];?>">
    </div>

    <div class="form-group">
      <textarea name="descripcion" class="form-control descripcion"  cols="30" rows="10" placeholder="Descripcion" required><?php echo $columna['descripcion'];?></textarea>
    </div>

    <div class="form-group">
      <input type="file" class="form-control" name="imagen" required placeholder="imagen" maxlength="150">
    </div>
    <div class="form-group">
      <input type="number" min="1" name="precio" class="form-control" placeholder="Precio" required value="<?php echo $columna['precio'];?>">
    </div>

    <div class="form-group">
      <input type="number" name="cantidad" class="form-control" min="1" placeholder="Cantidad" required value="<?php echo $columna['cantidad'];?>">
    </div>

    <div class="form-group text-center">
      <input type="submit" class="btn btn-success" value="Guardar">
      <a class="btn btn-danger" href="panel.php?categoria=inventario">Cancelar</a>
    </div>
  </form>
</div>