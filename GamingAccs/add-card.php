<?php
$mensaje = isset($_GET[ 'mensaje' ]) ? $_GET[ 'mensaje' ] : null;
$error = isset($_GET[ 'error' ]) ? $_GET[ 'error' ] : null;

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
<link rel="stylesheet" type="text/css" href="css/styles.css">

<div class="container col-12 col-md-7 col-lg-6">
  <div class="creditCardForm">
      <div>
          <h1 class="text-center">Agregar tarjeta</h1>
          <hr>
      </div>
      <div class="payment">
          <form action="procesos/add-card.php" method="POST">
              <div class="form-group owner">
                  <input type="text" class="form-control" name="titular" id="owner" placeholder="Titular" required>
              </div>
              <div class="form-group CVV">
                  <input type="text" class="form-control" name="cvv" id="cvv" placeholder="CVV" required>
              </div>
              <div class="form-group" id="card-number-field">
                  <input type="text" class="form-control" name="numero" id="cardNumber" placeholder="Nro. Tarjeta" required>
              </div>
              <div class="form-group" id="expiration-date">
                  <label>Fecha vencimiento</label>
                  <select name="mes_exp">
                      <option value="01">Enero</option>
                      <option value="02">Febrero</option>
                      <option value="03">Marzo</option>
                      <option value="04">Abril</option>
                      <option value="05">Mayo</option>
                      <option value="06">Junio</option>
                      <option value="07">Julio</option>
                      <option value="08">Agosto</option>
                      <option value="09">Septiembre</option>
                      <option value="10">Octubre</option>
                      <option value="11">Noviembre</option>
                      <option value="12">Diciembre</option>
                  </select>
                  <select name="year_exp">
                      <option value="2020"> 2020</option>
                      <option value="2021"> 2021</option>
                      <option value="2022"> 2022</option>
                      <option value="2023"> 2023</option>
                      <option value="2024"> 2024</option>
                      <option value="2019"> 2025</option>
                  </select>
              </div>
              <div class="form-group" id="credit_cards">
                  <img src="img/visa.jpg" id="visa">
                  <img src="img/mastercard.jpg" id="mastercard">
                  <img src="img/amex.jpg" id="amex">
                  <input type="text" hidden name="tipo" id="type_card">
              </div>
              <div class="form-group" id="pay-now">
                  <button type="submit" class="btn btn-default" id="confirm-purchase">Agregar</button>
                  <a class="btn btn-danger" href="index.php?categoria=edit_perfil">Cancelar</a>
              </div>
          </form>
      </div>
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