$( document ).ready(function() {
   
    $( "#form_registro").on( "submit", function( event ) {
        event.preventDefault();
   
        
      let formulario = $( this ).serializeArray();
      
      console.log(formulario)
      
        $.ajax({
          type:'POST', 
          url:'./accion/registrarUsuario.php',
          data: formulario,
          success: function(respuesta){
            Swal.fire({
                title: "Usuario registrado con éxito",
                icon: "success",
                text: "En breve serás redirigido al login",
                timer: 2000,
                timerProgressBar: true,
                willClose: () => {
                  window.location.href = "./login.php";
                }
            }) }
        }).fail(
            function(jqXHR, textStatus, errorThrown){
              
                Swal.fire({
                    title: jqXHR.responseJSON.mensaje,
                    icon: "error",
    
                })
              }
        ) 
       
      } );
});