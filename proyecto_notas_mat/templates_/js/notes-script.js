$(document).ready(function(){
    
    /*--- Menu desplegable ---*/
    
    $('#sideMenu').on('click', openSide);
    $('#closebtn').on('click', closeSide);
    
    function openSide(){
        $('#mySidenav').css({'width': '250px'});
    }
    
    function closeSide(){
        $('#mySidenav').css({'width': '0px'});
    }
    
    var inputs = document.querySelectorAll( '.inputfile' );
    Array.prototype.forEach.call( inputs, function( input )
    {
        var label	 = input.nextElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener( 'change', function( e )
        {
            var fileName = '';
            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
            else
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                label.querySelector( 'span' ).innerHTML = fileName;
            else
                label.innerHTML = labelVal;
        });
    });
    // fin menu desplegable
    
    /* Copiado de jquery.js */
    
    /* boton editar */
    
    $('#btn-submit-editar').on('click', validarFormularioEditar);
    
    /* CHECKEALO */
    
    $(".eliminarusuario").click(function(){
        if(!confirm("¿Realmente quieres borrar al usuario?")){
            event.preventDefault();
        } else {
        }
    });
    //
    
    /* ******************** BORRAR DATOS ******************** */
    
    function borrarDatos (event){
        if(!confirm("¿Realmente quieres borrar al usuario?")){
            event.preventDefault();
        } else {
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

    $('#div-nota').click(function (event) {
        
        if(!$(this).hasClass('activo')){
            $(this).toggleClass('div-nota');
            $(this).toggleClass('div-nota-editar');
            $('#menu-nota').toggleClass('oculto');
            $(this).addClass('activo');
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
    
    
// Fin de la funcion autoejecutada    
});

