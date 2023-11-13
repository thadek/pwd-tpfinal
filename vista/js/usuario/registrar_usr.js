$( document ).ready(function() {
   
    $( "#form_registro").on( "submit", function( event ) {
        console.log( $( this ).serializeArray() );
        event.preventDefault();
      } );

});