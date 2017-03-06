/*global $*/

$(document).ready(function(){

    $('.enviarRegistrar').on('click', validarFormularioRegistrar);
    $('.enviarEditar').on('click', validarFormularioEditar);
    //$('.eliminarusuario').on('click', borrarDatos);
    
    $(".eliminarusuario").click(function(){
        if(!confirm("¿Realmente quieres borrar al usuario?")){
            event.preventDefault();
        } else {
        }
    });
    
    $('.notamenu').hide();
    
    
/* ******************** BORRAR DATOS ******************** */
    
    function borrarDatos (event){
        if(!confirm("¿Realmente quieres borrar al usuario?")){
            event.preventDefault();
        } else {
        }
    }
    
    
/* ******************** CHANGE ******************** */

    /* CHANGE DEL INICIAR SESIÓN */
    $( "#emailIni" ).change(function() {
        validarEmail( $('#emailIni') );
    });
    $( "#passwordIni" ).change(function() {
        validarPassword( $('#passwordIni'), 6, true );
    });
    
    /* CHANGE DEL REGISTRARSE */
    $( "#emailReg" ).change(function() {
        validarEmail( $('#emailReg') );
    });
    $( "#passwordReg" ).change(function() {
        validarPassword( $('#passwordReg'), 6, true );
    });
    $( "#passwordReg" ).change(function() {
        validarComparar( $('#password3'), $('#password4'), true );
    });


/* ******************** VALIDAR FORMULARIO DEL REGISTRO ******************** */

    function validarFormularioRegistrar(event){
        event.preventDefault();
        
        var strEm = $('#listaEmails').val();
        var resEm = strEm.split("-");
        var strAli = $('#listaAlias').val();
        var resAli = strAli.split("-");
        
        var si_EmailBD = validarEnBD( $('#emailReg'), resEm );
        var si_AliasBD = validarEnBD( $('#aliasReg'), resAli );
        var si_Email = validarEmail( $('#emailReg') );
        var si_Password = validarPassword( $('#passwordReg'), 6, true );
        var si_CompararPass = validarComparar( $('#passwordReg'), $('#passwordRepReg'), true);
        

        if (si_EmailBD && si_AliasBD && si_Email && si_Password && si_CompararPass ){
            $("#formularioRegistro").submit();
        }
    }
    
    
/* ******************** VALIDAR FORMULARIO EDITAR PERFIL ******************** */

    function validarFormularioEditar(event){
        
        event.preventDefault();
        
        var strEm = $('#listaEmails').val();
        var resEm = strEm.split("-");
        var strAli = $('#listaAlias').val();
        var resAli = strAli.split("-");
        
        var si_EmailBD = ( validarComparar( $('#emailpk'), $('#emailEdit'), true ) ) || ( validarEnBD( $('#emailEdit'), resEm ) );
        var si_AliasBD = ( validarComparar( $('#aliaspk'), $('#aliasEdit'), true ) ) || (validarEnBD( $('#aliasEdit'), resAli ) );
        var si_Email = validarEmail( $('#emailEdit'));
        var si_AntiguaPassword = validarPassword( $('#passwordNew'), 6, true );
        var si_NuevaPassword = validarPassword( $('#passwordNew'), 6, false);
        var si_CompararPass = validarComparar( $('#passwordNew'), $('#passwordReNew'), false );

        if (si_EmailBD && si_AliasBD && si_Email && si_AntiguaPassword && si_NuevaPassword && si_CompararPass){
            $("#formularioEditar").submit();
        }
    }
    
/* ******************** MOVIMIENTOS DE LA NOTA AL HACER CLICK EN ELLA ******************** */

    $('.divnota').click(function (event) {
        
            /* Preguntamos si el div al que hemos clicado tiene la clase grande */
            if ( $(this).hasClass('grande') ){
            
            /* Si contiene la clase se la quitamos */
/*            $(this).removeClass('grande');
            
            /* Restauramos el css original de la nota */
/*            $(this).css({
                "width": "300px", 
                "height": "300px", 
            })
            
            /* Esconde el menu de la nota */
/*            $('.notamenu').hide();
            
            
            /* Reaparece todas las notas */
/*            $('.divnota').show();
            
            /* Volvemos a convertir en h5 el título y el p el texto */
/*            $(this).find( "input" ).replaceWith("<h5>" + $(this).find( "input" ).val() + "</h5>");
/*            $(this).find( "textarea" ).replaceWith("<p>" + $(this).find( "textarea" ).val() + "</p>");*/
            
        } else {
            
            /* Si no contiene la clase se la añadimos */
            $(this).addClass('grande');
            
            /* Le cambiamos el css para que se vea más grande */
            $(this).css({
                "width": "700px",
                "height": "700px",
            })
            
            /* Ésto es para que se centre en la pantalla */
            $('.row').css({
                "text-align": "center",
            })
            
            /* Mostramos el menu de la nota */
            $('.notamenu').show();
            
            /* Escondemos el navegador principal */
/*            $('.menuprincipal').hide();
            
            /* Escondemos todas las notas */
            $('.divnota').hide();
            /* Y ahora que solamente muestre el div al que hemos clicado */
            $(this).show();

            /* Convertimos el titulo en un input y el texto en un textarea */
/*            $(this).find( "h5" ).replaceWith("<input type=\"text\" value=\"" + $(this).find( "h5" ).text() + "\">");
            $(this).find( "p" ).replaceWith("<textarea rows=\"20\" cols=\"15\" >" + $(this).find( "p" ).text() + "</textarea>" );
            */
        }
        
	});


/* ******************** FUNCIONES DE VALIDACION ******************** */

    function validarEmail(nodo){ 
        var campo = nodo.val();
        if ( campo == '' ){
            nodo.addClass('invalid');
            return false;
        } else {
            var expr = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

            if (!expr.test(campo)) {
                nodo.addClass('invalid');
                return false;
            } else {
                nodo.addClass('valid');
                return true;
            }
        }
    }
    
    
    function validarPassword(nodo, tam, required){
        var si_tamanio, si_letra, si_mayuscula, si_numero;
        var campo = nodo.val();
        
        if (!required && campo == ''){
            nodo.addClass('valid');
            return true;
        } else {
            
            //validar el tamaño
            if ( campo.length < tam ) {
                si_tamanio = false;
            } else {
                si_tamanio = true;
            }
    
            //validar que tiene letras
            if ( campo.match(/[A-z]/) ) {
                si_letra = true;
            } else {
                si_letra = false;
            }
    
            //validar que tiene mayúsculas
            if ( campo.match(/[A-Z]/) ) {
                si_mayuscula = true;
            } else {
                si_mayuscula = false;
            }
    
            //validar que tiene números
            if ( campo.match(/\d/) ) {
                si_numero = true;
            } else {
                si_numero = false;
            }
            
            if (si_tamanio && si_letra && si_mayuscula && si_numero){
                nodo.addClass('valid');
                return true;
            } else {
                nodo.addClass('invalid');
                return false;
            }
            
        }
    }
    
    function validarComparar(nodo1, nodo2, required){
        var campo1 = nodo1.val();
        var campo2 = nodo2.val();
        
        if (!required && campo2 == ''){
            nodo2.addClass('valid');
            return true;
        } else {
            if (campo1 === campo2){
                nodo1.addClass('valid');
                nodo2.addClass('valid');
                return true;
            } else {
                nodo1.addClass('invalid');
                nodo2.addClass('invalid');
                return false;
            }
        }
    }
    
    function validarEnBD(nodo, array, required){
        var campo = nodo.val();
        var encontrado = false;
        
        /* Recorre el array buscando una coincidencia entre el valor del nodo y 
        con algún dato del array */
        $.each(array, function (ind, elem) { 
            if ( campo === elem ){
                encontrado = true;
            }
        });
        
        if(encontrado){
            nodo.addClass('invalid');
            return false;
        } else {
            nodo.addClass('valid');
            nodo.next().text('');
            return true;
        }
    }

});