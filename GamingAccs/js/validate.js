( () => 
{

  //Constantes
  const VALID_NUMBER      = "1234567890";
  const LIST_CODE         = [ 8, 9, 32, 48, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 107, 187 ];
  const LIST_CODE_CEDULA  = [ 8, 45, 46, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 190 ];

  //Variables
  var ListenTelefono  = document.querySelectorAll('#listen-tlf');
  var ListenCedula    = document.querySelectorAll('#listen-cedula');

  ListenCedula.forEach( ( Cedula ) => {
    Cedula.addEventListener( 'keypress', (e) => {
      if( Cedula.className == "off-cedula") {
        Cedula.setAttribute( "disabled", "disabled" );
        return e.preventDefault();
      }

      if( e.keyCode != 46 && e.keyCode != 45)
      {
        var CharKey = String.fromCharCode(e.keyCode);
        var Valido  = false;

        if( VALID_NUMBER.includes(CharKey) || LIST_CODE_CEDULA.includes(e.keyCode))
          Valido = true;

        if(!Valido)
          return e.preventDefault();
      }
    })

    Cedula.addEventListener( 'keydown', (e) => {
      if( Cedula.className == "off-cedula") {
        Cedula.setAttribute( "disabled", "disabled" );
        return e.preventDefault();
      }

      var CharKey = String.fromCharCode(e.keyCode);
      var Valido  = false;

      if( VALID_NUMBER.includes(CharKey) || LIST_CODE_CEDULA.includes(e.keyCode))
        Valido = true;

      if(!Valido)
        return e.preventDefault();
    })
  }); 

  ListenTelefono.forEach( ( telefono ) => {
    telefono.addEventListener( 'keypress', (e) => {

      if( e.keyCode != 43)
      {
        var CharKey = String.fromCharCode(e.keyCode);
        var Valido  = false;

        if( ( VALID_NUMBER.includes(CharKey) || LIST_CODE.includes(e.keyCode) ) && !(CharKey == 0 && telefono.value.length == 0 ) )
          Valido = true;

        if(!Valido)
          return e.preventDefault();
      }
    })

    telefono.addEventListener( 'keydown', (e) => {
      var CharKey = String.fromCharCode(e.keyCode);
      var Valido  = false;

      if( VALID_NUMBER.includes(CharKey) || LIST_CODE.includes(e.keyCode) )
        Valido = true;


      if(!Valido)
        return e.preventDefault();
    })
  });

}).call(this);