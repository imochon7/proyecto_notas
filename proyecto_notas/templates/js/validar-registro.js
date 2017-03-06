/* global $ */

$(document).ready(function(){
    
    $('#signup_enviar').on('click', validar);
    
    function validar(e){
        
        e.preventDefault();
        
        var email_ok = validarEmail($('#email'));
        var alias_ok = validarVacio($('#alias'));
        var pass_ok = validarPassword($('#pass'), 4);
        var pass2_ok = validarVacio($('#pass2'));
        var comparar_ok = validarComparar($('#pass'), $('#pass2'));
        

        if (email_ok && alias_ok && pass_ok && pass2_ok && comparar_ok ){
            $("#signup").submit();
        }
    }
    
    // Comprueba que un campo no este vacio
    function validarVacio(nodo){
        var contenido = nodo.val();
        var correcto = true;
        
        nodo.next().text('');
        
        if( contenido === '' ){
            correcto = false;
            nodo.next().text('El campo no puede estar vacio.');
        }
        return correcto;
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
    
    // Comprueba que los dos password sean iguales
    function validarComparar(nodo1, nodo2){
        var pass1 = nodo1.val();
        var pass2 = nodo2.val();
        var correcto = true;
        
        nodo2.next().text('');
        
        if( pass1 != pass2 ){
            correcto = false;
            nodo2.next().text('La confirmacion de contraseña no es valida.');
        }
        return correcto;
    }
});