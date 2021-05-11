<?php
include_once('procesos/db.php');

session_start();

if( isset( $_SESSION[ 'loggedin' ] ) && $_SESSION[ 'user_level'] != 'usuario' )
{
  header( 'location:panel.php' );
  return;
}

$Categoria = isset( $_GET[ 'categoria' ] ) ? $_GET[ 'categoria' ] : null ;
$ex_categoria = isset($_GET[ 'excategoria' ]) ? $_GET[ 'excategoria' ] : null;
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
    <title>Gaming Accs</title>
</head>
<body class="bg-img">
    <nav class="navbar navbar-expand-md navbar-dark bg-nav">
        <img src="img/logo.png" width="4%" class="esp-logo"> 
        <a class="navbar-brand" href="index.php">Gaming Accs</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link <?php if($Categoria == null) { echo 'active'; }?>" href="index.php">Inicio<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($Categoria == 'computadora') { echo 'active'; }?>" href="index.php?categoria=computadora">Computadoras</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($Categoria == 'laptop') { echo 'active'; }?>" href="index.php?categoria=laptop">Laptops</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($Categoria == 'hardware') { echo 'active'; }?>" href="index.php?categoria=hardware">Hardware y Accesorios</a>
                </li>
            </ul>
            <?php
            if ( isset( $_SESSION[ 'loggedin' ] ) &&  $_SESSION[ 'loggedin' ] === true ) { ?>
							<ul class="navbar-nav">
                <li class="nav-item">
                  <a href="index.php?categoria=mycar" class="btn btn-dark mr-4">Carrito <span class="badge badge-success">
                  <?php
                  if( isset( $_SESSION[ "car" ] ) )
                   {
                     $items = 0;
                     for ($i=0; $i < sizeof($_SESSION[ "car" ]) ; $i++) { 
                       ++$items;
                     }

                    echo ($items);
                   } else
                    echo 0;
                  ?>
                  </span></a>
                </li>
                <li class="dropdown">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION[ 'nombre' ]?></button>
            
                  <ul class="dropdown-menu text-center">
                    <div class="dropdown-header">Opciones</div>
                    <a class="dropdown-item" href="index.php?categoria=edit_perfil">Mis datos</a>
                    <a class="dropdown-item bg-danger text-white" href="session_closet.php">Cerrar sesion</a>
                  </ul>
                </li>
              </ul>
          	<?php } else { ?>
              <a href="index.php?categoria=login" class="btn btn-primary my-2 my-sm-0">Iniciar Sesión</a>
						<?php } ?>
        </div>
    </nav>

    <?php
    if( $Categoria != null )
    {
        if( $Categoria == "computadora")
          include( 'pc.php' );
        else if( $Categoria == "laptop")
          include( 'laptop.php' );
        else if( $Categoria == "hardware")
          include( 'hardware.php' );
        else if ( $Categoria == "pago")
          include( 'pagar-car.php' );
        else if( $Categoria == "edit_perfil" )
          include( 'user-edit.php' );
        else if( $Categoria == "add_card" )
          include( 'add-card.php' );
        else if( $Categoria == "mycar")
          include( 'show-car.php');
        else if ( $Categoria == "login" && !isset( $_SESSION[ 'loggedin' ] ) )
				{
					if( isset( $_GET[ 'valid'] ) && !is_null( $_GET[ 'valid' ] ) )
          	include( 'procesos/authentic.php' );
          else
						include( 'login.php' );
				}
        else if ( $Categoria == "registro" && !isset( $_SESSION[ 'loggedin' ] ) )
        {
          if( isset( $_GET[ 'valid'] ) && !is_null( $_GET[ 'valid' ] ) )
            include( 'procesos/register.php' );
          else
            include( 'registro.php' );
        }
        else if ( !isset( $_SESSION[ 'loggedin' ] ) &&  $Categoria == "recuperar" )
					include( 'recuperar.php' );
				else 
					header( 'location:index.php' );
    } else {
    ?>

    <div class="container">
        <div class="init pushed text-center">
            <h1>Inicio</h1>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sed placeat nobis et molestiae sunt tempore necessitatibus repellendus dolorem iusto quos quis modi eius cupiditate, accusantium repellat fugiat, error dolores! Reprehenderit?</p>
        </div>
    </div>

    <?php }?>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/validate.js"></script>
    <?php
    if( $Categoria == "add_card" ) {?>
    <script src="js/jquery.payform.min.js" charset="utf-8"></script>
    <script src="js/script.js"></script>
    <?php }?>

</body>
</html>