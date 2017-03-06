$(document).ready(function(){
    
    $('.form').on('submit', function(e){
        e.preventDefault();
        
        var email_ok = validarEmail( $('#email') );
        var pass_ok = validarPassword( $('#pass'), 6 );
        var pass2_ok = validarVacio($('#pass2'));
        var comparar = validarComparar($('#pass'), $('#pass2'));
        
        if(email_ok && pass_ok && pass2_ok && comparar){
            e.submit();
        }else{
            $('#error-msg').text('Acceso denegado. Compruebe todos los campos.');
        }
    });
    
    function validarEmail(nodo){
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
    
    function validarVacio(nodo){
        var contenido = nodo.val();
        var correcto = true;
        
        if(contenido.length === 0){
            correcto = false;
        }
        return correcto;
    }
    
    function validarComparar(nodo1, nodo2){
        var cadena1 = nodo1.val();
        var cadena2 = nodo2.val();
        var correcto = true;
        
        if(cadena1 !== cadena2){
            correcto = false;
        }
        return correcto;
    }
});