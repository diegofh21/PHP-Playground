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

<div class="container mt-5 mb-5">
  <div class="form-pay">
    <h2 class="text-center mt-2">Registro de Usuarios</h1>

    <form action='index.php?categoria=registro&valid=1' method='post'>

    <hr class='rob22 mt-3 mb-4'>

      <div class='form-row'>
          <label class='col col-md-3 bold'>Nombre y Apellido:</label>
          <div class='col col-md-4'>
              <input type='text' class='form-control' placeholder='Nombre Completo' name='nombre' required>
          </div>
      </div>

      <br>

      <div class='form-row'>
          <label class='col col-md-3 bold'>Cédula de Identidad:</label>
          <div class='col col-md-3'>
              <input type='text' class='form-control' id='listen-cedula' placeholder='Cédula de Identidad' name='cedula' required>
          </div>
      </div>

      <br>

      <div class='form-row'>
        <label class='col-md-3 bold'>Género:</label>
        <div class='col col-md-4  '>
            <select class='form-control' name='genero'>
                <option value='opt'>Seleccione una opción</option>
                <option value='Masculino'>Masculino</option>
                <option value='Femenino'>Femenino</option>
            </select>
        </div>
      </div>

      <br>

      <div class='form-row'>
          <label class='col col-md-3 bold'>Correo Electrónico:</label>
          <div class='col col-md-3'>
              <input type='email' class='form-control' placeholder='Correo Electrónico' name='email' required>
          </div>
      </div>

      <br>

      <div class='form-row'>
          <label class='col col-md-3 bold'>Teléfono:</label>
          <div class='col col-md-3'>
              <input type='text' class='form-control' id='listen-tlf' placeholder='Teléfono' name='telefono' required>
          </div>
      </div>

      <br>

      <div class='form-row'>
          <label class='col col-md-3 bold'>Fecha de Nacimiento:</label>
          <div class='col col-md-3'>
              <input type='date' class='form-control' placeholder='Fecha' name='fec_nac' required>
          </div>
      </div>

      <br>

      <div class='form-row'>
          <label class='col col-md-3 bold'>Contraseña:</label>
          <div class='col col-md-3'>
              <input type='password' class='form-control' placeholder='Contraseña' name='password' required maxlength='24'>
          </div>
      </div>

      <br>

      <div class='form-row'>
          <label class='col col-md-3 bold'>Confirmar Contraseña:</label>
          <div class='col col-md-3'>
              <input type='password' class='form-control' placeholder='Contraseña' name='cpassword' required maxlength='24'> 
          </div>
      </div>

      <br>

      <div class='form-row'>
          <label class='col col-md-3 bold'>Direccion:</label>
          <div class='col col-md-4'>
              <textarea class="form-control" name="direccion" id="" cols="30" rows="10" placeholder="Direccion" required></textarea>
          </div>
      </div>

      <br>

      <hr class='rob22'>

      <div class="form-row">
          <div class="col-md-12 text-center">
              <button type='submit' class='btn btn-primary btn-lg' name="btn-reg" value="Registrar">Registrarse</button>
          </div>
      </div>     
    </form>
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