<?php
  include_once('procesos/db.php');

  session_start();
  
  if( !isset( $_SESSION[ 'loggedin' ] ) || $_SESSION[ 'user_level'] == 'usuario' )
  {
    header( 'location:index.php?categoria=login' );
    exit;
  }

  if( isset( $_GET[ 'categoria' ] ) )
    $Categoria = $_GET[ 'categoria' ];
  else 
    $Categoria = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="img/icono control png.ico" type="image/x-icon">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <title>Gaming Accs - Panel</title>
</head>
<body>
  <div class="container-fluid col-12 d-flex justify-content-between full-screen p-0">
    <div class="container col-2 bg-primary fixed_menu">
        <nav class="navbar navbar-nav navbar-dark p-0 py-4 h-100 d-flex flex-column justify-content-between flex-nowrap">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link text-center text-warning" href="panel.php"> <?php echo $_SESSION[ 'nombre' ]?></a>
            </li>
            <li class="mt-2 dropdown-divider"></li>
            <li class="nav-item <?php if($Categoria == 'inventario' ) { echo ('active'); } ?>">
              <a class="nav-link text-center" href="panel.php?categoria=inventario&search=todo">Inventario</a>
            </li>
            <li class="nav-item <?php if($Categoria == 'facturas' ) { echo ('active'); } ?>">
                <a class="nav-link text-center" href="panel.php?categoria=facturas">Facturas</a>
              </li>
            <li class="nav-item <?php if($Categoria == 'cuentas' ) { echo ('active'); } ?>">
              <a class="nav-link text-center" href="panel.php?categoria=cuentas">Cuentas</a>
            </li>
          </ul>
          <a class="text-center btn btn-danger" href="session_closet.php">Cerrar sesion</a>
        </nav>
    </div>
    
    <div class="container col-10 body-panel py-2 content-table">
      <?php
      if( $Categoria != null )
      {
          if( $Categoria == 'inventario')
            include( 'panel/panel-inv.php' );
          else if( $Categoria == 'modificar_inv' )
            include( 'panel/modific-produc.php' );
          else if( $Categoria == 'facturas')
            include( 'panel/panel-fac.php' );
          else if( $Categoria == 'cuentas')
            include( 'panel/panel-accounts.php' );
          else if( $Categoria == 'add_admin' )
            include( 'panel/add-account.php' );
          else if( $Categoria == 'change_paassword' )
            include( 'panel/change_password.php' );
      } else {
      ?>

      <div class="container d-flex flex-column justify-content-center h-100 text-center">
        <?php
          if( $_SESSION[ 'user_level' ] == 'super')
          {?>
            <h1 class="text-success">Super admin</h1>
            <p class="text-white">El nivel de Super admin es el encargado de administrar todas las cuentas, productos, procesar pagos, procesar facturas, etc.</p>
          <?php 
          }
          else
          {?>
          <h1 class="text-success">Admin</h1>
            <p class="text-white">El nivel de Admin es el encargado de administrar los productos, procesar pagos, procesar facturas.</p>
        <?php } ?>
      </div>

      <?php }?>
    </div>
  </div>
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/validate.js"></script>
</body>
</html>