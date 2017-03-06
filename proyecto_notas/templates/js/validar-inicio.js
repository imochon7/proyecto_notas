/*global $*/

$(document).ready(function(){
    
    $('#login').on('submit', validar);
    
    function validar(e){
        
        var email_ok = validarEmail($('#email'));
        var pass_ok = validarPassword($('#pass'), 4);
        
        if( !email_ok || !pass_ok){
            e.preventDefault();
        }
    }
    
    // Comprueba que el campo email no este vacio y tenga
    // el formato correcto.
    function validarEmail(nodo){
        
        var email = nodo.val();
        var correcto = true;
        
        nodo.next().text('');
        
        if ( email === '' ){
            correcto = false;
            nodo.next().text('El campo email no puede estar vacio.');
        } else {
            var expr = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
            
            if ( !expr.test( email ) ){
                correcto = false;
                nodo.next().text('El formato del email introducido no es correcto.');
            }
        }
        return correcto;
    }
    
    // Comprueba que el campo password no este vacio y tenga
    // el formato correcto.
    function validarPassword(nodo, min){
        
        var pass = nodo.val();
        var correcto = true;
        
        nodo.next().text('');
        
        // Comprueba tamaño minimo.
        if ( pass.length < min ){
            correcto = false;
            nodo.next().text('Debe contener al menos 4 caracteres');
        } else {
            // Comprueba que contenga letras
            if( !pass.match(/[A-z]/) ){
                correcto = false;
                nodo.next().text('Debe contener letras.');
            }
            
            // Comprueba que contenga mayusculas
            if(!pass.match(/[A-Z]/)){
                correcto = false;
                nodo.next().text('Debe contener al menos una mayuscula.');
            }
            
            // Comprueba que contenga numeros
            if(!pass.match(/\d/)){
                correcto = false;
                nodo.next().text('Debe contener al menos un numero.');
            }
        }
        return correcto;
    }
});