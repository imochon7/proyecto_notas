$(document).ready(function(){
    
    $('.form').on( 'submit', function( e ){
        e.preventDefault();
        
        var email_ok = validarEmail( $('#email') );
        var pass_ok = validarPassword( $('#pass'), 6 );
        
        if(email_ok && pass_ok){
            e.submit();
        }else{
            $('#error-msg').text('Acceso denegado. Compruebe que el email y la contraseña introducida son correctos.');
        }
    });
    
    function validarEmail( nodo ){
        var email = nodo.val();
        var correcto = true;
        if ( email === '' ){
            correcto = false;
        } else {
            var expr = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
            
            if ( !expr.test( email ) ){
                correcto = false;
            }
        }
        return correcto;
    }
    
    function validarPassword(nodo, min){
        
        var pass = nodo.val();
        var correcto = true;
        
        // Comprueba tamaño minimo.
        if ( pass.length < min ){
            correcto = false;
        } else {
            // Comprueba que contenga letras
            if( !pass.match(/[A-z]/) ){
                correcto = false;
            }
            
            // Comprueba que contenga mayusculas
            if(!pass.match(/[A-Z]/)){
                correcto = false;
            }
            
            // Comprueba que contenga numeros
            if(!pass.match(/\d/)){
                correcto = false;
            }
        }
        return correcto;
    }
});