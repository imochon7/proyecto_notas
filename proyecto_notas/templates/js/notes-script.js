/* global $ */

$(document).ready(function(){
    
    /* ******************* CARGAR EL COLOR DE CADA NOTA ***********************/
	
	var arrayNotas = $('.div-nota');
	var tamanno = arrayNotas.length;
	
	
	$.each(arrayNotas, function (ind, elem) { 
	    
        if( $(this).children('.form-nota').children('#hidden_color').val() === 'rosa' ){
            $(this).addClass('co-rosa');
        }
        if( $(this).children('.form-nota').children('#hidden_color').val() === 'azul' ){
            $(this).addClass('co-azul');
        }
        if( $(this).children('.form-nota').children('#hidden_color').val() === 'verde' ){
            $(this).addClass('co-verde');
        }
    });
    
    /************ CARGAR LA TIPOGRAFIA DE CADA NOTA *****/
    
    $.each(arrayNotas, function (ind, elem) {
        
        if( $(this).children('.form-nota').children('#hidden_tipo').val() === 'Calibri' ){
            $(this).children('.form-nota').children('.titulo-nota').addClass('tp-calibri');
            $(this).children('.form-nota').children('.contenido-nota').addClass('tp-calibri');
        }
        
        if( $(this).children('.form-nota').children('#hidden_tipo').val() === 'Cambria' ){
            $(this).children('.form-nota').children('.titulo-nota').addClass('tp-cambria');
            $(this).children('.form-nota').children('.contenido-nota').addClass('tp-cambria');
        }
        
        if( $(this).children('.form-nota').children('#hidden_tipo').val() === 'Raleway' ){
            $(this).children('.form-nota').children('.titulo-nota').addClass('tp-raleway');
            $(this).children('.form-nota').children('.contenido-nota').addClass('tp-raleway');
        }
        
        if( $(this).children('.form-nota').children('#hidden_tipo').val() === 'Satellite' ){
            $(this).children('.form-nota').children('.titulo-nota').addClass('tp-satellite');
            $(this).children('.form-nota').children('.contenido-nota').addClass('tp-satellite');
        }
    });
    
    /****** CARGAR EL TAMAÑO DE FUENTE DE CADA NOTA *****/
    
    $.each(arrayNotas, function (ind, elem) {
        
        if( $(this).children('.form-nota').children('#hidden_tam').val() === '12' ){
            $(this).children('.form-nota').children('.titulo-nota').addClass('tm-12');
            $(this).children('.form-nota').children('.contenido-nota').addClass('tm-12');
        }
        
        if( $(this).children('.form-nota').children('#hidden_tam').val() === '14' ){
            $(this).children('.form-nota').children('.titulo-nota').addClass('tm-14');
            $(this).children('.form-nota').children('.contenido-nota').addClass('tm-14');
        }
        
        if( $(this).children('.form-nota').children('#hidden_tam').val() === '16' ){
            $(this).children('.form-nota').children('.titulo-nota').addClass('tm-16');
            $(this).children('.form-nota').children('.contenido-nota').addClass('tm-16');
        }
        
        if( $(this).children('.form-nota').children('#hidden_tam').val() === '18' ){
            $(this).children('.form-nota').children('.titulo-nota').addClass('tm-18');
            $(this).children('.form-nota').children('.contenido-nota').addClass('tm-18');
        }
        
        if( $(this).children('.form-nota').children('#hidden_tam').val() === '24' ){
            $(this).children('.form-nota').children('.titulo-nota').addClass('tm-24');
            $(this).children('.form-nota').children('.contenido-nota').addClass('tm-24');
        }
    });
    
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
    
    $('.edit-submit').on('click', validarFormularioEditar);
    $('.edit-completo').on('click', validarFormularioEditarCompleto);
    
    /* CHECKEALO */
    
    $(".eliminarusuario").click(function(){
        if(!confirm("¿Realmente quieres borrar al usuario?")){
            event.preventDefault();
        } else {
        }
    });
    
    
    $(".btn-eliminar").click(function(){
        if(!confirm("¿Realmente quieres borrar tu perfil?")){
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
        
        var si_Email = validarEmail( $('#emailEdit'));
        var si_Alias = validarAlias($('#aliasEdit'));
        var si_AntiguaPassword = validarPassword( $('#passwordOld'), 6, true );
        var si_NuevaPassword = validarPassword( $('#passwordNew'), 6, false);
        var si_CompararPass = validarComparar( $('#passwordNew'), $('#passwordReNew'), false );

        if ( si_Email && si_Alias && si_AntiguaPassword && si_NuevaPassword && si_CompararPass ){
            $('#formularioEditar').submit();
        }
    }
    
    
    /* ********** VALIDAR FORMULARIO EDITAR PERFIL COMPLETO******************** */

    function validarFormularioEditarCompleto(event){
        
        event.preventDefault();
        
        var si_Email = validarEmail( $('#emailEdit'));
        var si_Alias = validarAlias($('#aliasEdit'));
        

        if ( si_Email && si_Alias ){
            $('#formularioEditarCompleto').submit();
        }
    }
    
    /* ******************** MOVIMIENTOS DE LA NOTA AL HACER CLICK EN ELLA ******************** */

    $(".grande").css("width", "35%");
	$(".lilista").css("width", "35%");
	$(".grande").css("font-size", "10px");
	$(".lilista").css("font-size", "10px");
    $('.div-nota').click(function (event) {
        
        $('.div-nota').hide();
        $(this).show();
        
        if(!$(this).hasClass('activo')){
            $(this).toggleClass('div-nota');
            $(this).toggleClass('div-nota-editar');
            $('.menu-editar').toggleClass('oculto');
            $(this).addClass('activo');
            $(this).find("li").addClass("grande");
            $(".grande").css("width", "75%");
	        $(".lilista").css("width", "75%");
	        $(".grande").css("font-size", "14px");
	        $(".lilista").css("font-size", "14px");
            
        }
	});
	
	
	
	
	/* ******************* CAMBIAR COLOR NOTA *********************************/
	
	$('#sel-color').change(function(){
	    
	    if($('#sel-color').val() === 'amarillo'){
	        $('.div-nota').removeClass('co-azul');
	        $('.div-nota').removeClass('co-verde');
	        $('.div-nota').removeClass('co-rosa');
	        $('.div-nota').addClass('co-amarillo');
	        $('.div-nota-editar').removeClass('co-azul');
	        $('.div-nota-editar').removeClass('co-verde');
	        $('.div-nota-editar').removeClass('co-rosa');
	        $('.div-nota-editar').addClass('co-amarillo');
	    }
	    
	    if($('#sel-color').val() === 'azul'){
	        $('.div-nota').removeClass('co-amarillo');
	        $('.div-nota').removeClass('co-verde');
	        $('.div-nota').removeClass('co-rosa');
	        $('.div-nota').addClass('co-azul');
	        $('.div-nota-editar').removeClass('co-amarillo');
	        $('.div-nota-editar').removeClass('co-verde');
	        $('.div-nota-editar').removeClass('co-rosa');
	        $('.div-nota-editar').addClass('co-azul');
	    }
	    
	    if($('#sel-color').val() === 'verde'){
	        $('.div-nota').removeClass('co-amarillo');
	        $('.div-nota').removeClass('co-azul');
	        $('.div-nota').removeClass('co-rosa');
	        $('.div-nota').addClass('co-verde');
	        $('.div-nota-editar').removeClass('co-amarillo');
	        $('.div-nota-editar').removeClass('co-azul');
	        $('.div-nota-editar').removeClass('co-rosa');
	        $('.div-nota-editar').addClass('co-verde');
	    }
	    
	    if($('#sel-color').val() === 'rosa'){
	        $('.div-nota').removeClass('co-amarillo');
	        $('.div-nota').removeClass('co-verde');
	        $('.div-nota').removeClass('co-azul');
	        $('.div-nota').addClass('co-rosa');
	        $('.div-nota-editar').removeClass('co-amarillo');
	        $('.div-nota-editar').removeClass('co-verde');
	        $('.div-nota-editar').removeClass('co-azul');
	        $('.div-nota-editar').addClass('co-rosa');
	    }
	});
	
	/**** CAMBIAR TIPOGRAFIA DE LA NOTA  *****/
	
	$('.sel-tipo').change(function(){
	    
	    /*alert($(this).val());*/
	    
	    if($(this).val() === 'Calibri'){
	        
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tp-cambria');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tp-raleway');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tp-satellite');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').addClass('tp-calibri');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tp-cambria');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tp-raleway');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tp-satellite');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').addClass('tp-calibri');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tp-cambria');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tp-raleway');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tp-satellite');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').addClass('tp-calibri');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tp-cambria');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tp-raleway');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tp-satellite');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').addClass('tp-calibri');
	    }
	    
	    if($(this).val() === 'Cambria'){
	        
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tp-calibri');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tp-raleway');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tp-satellite');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').addClass('tp-cambria');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tp-calibri');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tp-raleway');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tp-satellite');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').addClass('tp-cambria');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tp-calibri');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tp-raleway');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tp-satellite');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').addClass('tp-cambria');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tp-calibri');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tp-raleway');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tp-satellite');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').addClass('tp-cambria');
	    }
	    
	    if($(this).val() === 'Raleway'){
	        
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tp-calibri');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tp-cambria');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tp-satellite');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').addClass('tp-raleway');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tp-calibri');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tp-cambria');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tp-satellite');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').addClass('tp-raleway');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tp-calibri');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tp-cambria');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tp-satellite');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').addClass('tp-raleway');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tp-calibri');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tp-cambria');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tp-satellite');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').addClass('tp-raleway');
	    }
	    
	    if($(this).val() === 'Satellite'){
	        
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tp-calibri');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tp-raleway');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tp-cambria');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').addClass('tp-satellite');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tp-calibri');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tp-raleway');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tp-cambria');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').addClass('tp-satellite');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tp-calibri');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tp-raleway');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tp-cambria');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').addClass('tp-satellite');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tp-calibri');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tp-raleway');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tp-cambria');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').addClass('tp-satellite');
	    }
	});
	
	/****** CAMBIAR TAMAÑO DE LA NOTA *******/
	
	$('.sel-tama').change(function(){
	    
	    if($(this).val() === '12'){
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-14');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-16');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-18');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-24');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').addClass('tm-12');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-14');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-16');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-18');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-24');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').addClass('tm-12');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-14');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-16');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-18');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-24');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').addClass('tm-12');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-14');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-16');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-18');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-24');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').addClass('tm-12');
	    }
	    
	    if($(this).val() === '14'){
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-12');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-16');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-18');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-24');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').addClass('tm-14');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-12');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-16');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-18');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-24');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').addClass('tm-14');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-12');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-16');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-18');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-24');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').addClass('tm-14');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-12');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-16');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-18');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-24');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').addClass('tm-14');
	    }
	    
	    if($(this).val() === '16'){
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-14');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-12');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-18');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-24');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').addClass('tm-16');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-14');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-12');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-18');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-24');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').addClass('tm-16');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-14');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-12');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-18');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-24');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').addClass('tm-16');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-14');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-12');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-18');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-24');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').addClass('tm-16');
	    }
	    
	    if($(this).val() === '18'){
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-14');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-16');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-12');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-24');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').addClass('tm-18');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-14');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-16');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-12');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-24');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').addClass('tm-18');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-14');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-16');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-12');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-24');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').addClass('tm-18');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-14');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-16');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-12');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-24');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').addClass('tm-18');
	    }
	    
	    if($(this).val() === '24'){
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-14');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-16');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-18');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').removeClass('tm-12');
	        $('.div-nota').children('.form-nota').children('.titulo-nota').addClass('tm-24');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-14');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-16');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-18');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').removeClass('tm-12');
	        $('.div-nota').children('.form-nota').children('.contenido-nota').addClass('tm-24');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-14');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-16');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-18');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').removeClass('tm-12');
	        $('.div-nota-editar').children('.form-nota').children('.titulo-nota').addClass('tm-24');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-14');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-16');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-18');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').removeClass('tm-12');
	        $('.div-nota-editar').children('.form-nota').children('.contenido-nota').addClass('tm-24');
	    }
	});
	
	
/****** INTRODUCIR LI EN LAS LISTAS*******/
	var contenidoalfocus;
	var cadenavalues = "";
	var contenidoTotal = $(".textoculto").attr("value");
	$(".inputlista").on("keypress", añadirlis);
	$(".div-nota").on("click", capturarvalues);
	$(".grande").on("keypress", volveralinput);
	$(".checklista").change(tachar);
	$(".btn-submit-nota").on("click",enviarvalues);
	
	
	function capturarvalues(){
	    var losli = $(this).find("li");
	    var optionTexts = [];
	    var cadena = "";
        losli.each(function() {
            optionTexts.push($(this).text() + "_")
            
        });
        for(var i=0; i < optionTexts.length; i++){
            cadena = cadena + optionTexts[i];
        }
        var cadenaFinal = cadena.substring(0, cadena.length -1); 
        $(".textoculto").attr("value",  cadenaFinal);
	}

	
	
	/*
	$(".grande").focusin(function(){
    contenidoalfocus = $(this).text();
    cadenavalues =  $(".textoculto").attr("value");
    	$(this).focusout(function(){
    	   // alert("hola");
	        var nuevovalor = $(this).text();
            cadenavalues = cadenavalues.replace(contenidoalfocus + "&", nuevovalor + "&");
             $(".textoculto").attr("value",  cadenavalues);
        });
    });
    */
    

	
	
	var html = "<input type='checkbox' name='realizado' class='checklista' value=''>" +
	            "<li class='txt grande' name='lista' contenteditable='true'></li>" +
	            "<span class='spanoculto'>x</span>";
	            
	function añadirlis(e){
	        if(e.keyCode === 13 ){
            e.preventDefault();
            var elementoactuador = $(this).prev();
            elementoactuador.append(html);
            //$(this).parent().parent().prev().find("ul").append(html);
            //$(".listanotalista").append(html);
            elementoactuador.find(".txt").text($(this).val());
            elementoactuador.find("li").removeClass("txt");
            var il = $(".textoculto").val() +  $(".inputlista").val() + "_";
            $(".textoculto").attr("value",  il);
           	$(this).val(" "); 
           	$(".checklista").change(tachar);
           	$(".spanoculto").on("click", borrarlis);
        }
	}
	
	
	function volveralinput(e){
	    if(e.keyCode === 13){
	        e.preventDefault();
	        $(".inputlista").focus();
	    }
	}
	
	
	
/****** Borrar LI EN LAS LISTAS*******/
	
	
		$(".spanoculto").on("click", borrarlis);
		
		function borrarlis(e){
            e.preventDefault();
            //var contenidoli =  $(this).prev().text();
            //contenidoTotal = $(".textoculto").attr("value");
            $(this).prev().prev().remove();
            $(this).prev().remove();
            $(this).remove();
            //contenidoTotal = contenidoTotal.replace(contenidoli + "&", "");
            //$(".textoculto").attr("value",  contenidoTotal);
        }
        
/****** tachar LI EN LAS LISTAS*******/     

    function tachar(e){
        e.preventDefault();
         if (this.checked) {
          $(this).next().css("text-decoration" , "line-through");
         }else{
        $(this).next().css("text-decoration" , "none");
         }
    }

/****** Remiendo de las notas normales*******/ 

    function enviarvalues(e){
        var loslideestanota = $(this).parent().parent().prev().find("li");
	    var arraylies = [];
	    var cadena = "";
        loslideestanota.each(function() {
              arraylies.push($(this).text() + "_");  
        });
        for(var i=0; i < arraylies.length; i++){
            cadena = cadena + arraylies[i];
        }
        var cadenaFinal = cadena.substring(0, cadena.length-1); 
        $(".textoculto").attr("value",  cadenaFinal);
    
    }
    
    
 
		
/* ******************** FUNCIONES DE VALIDACION ******************** */

    function validarEmail(nodo){ 
        var campo = nodo.val();
        if ( campo == '' ){
            nodo.addClass('invalid');
            return false;
        } else {
            var expr = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

            if (!expr.test(campo)) {
                nodo.next().text('El formato no es correcto');
                return false;
            } else {
                nodo.next().text('');
                return true;
            }
        }
    }
    
    function validarAlias(nodo){
        var alias = nodo.val();
        var correcto = true;
        
        if( alias === ''){
            correcto = false;
        }
        return correcto;
    }
    
    
    function validarPassword(nodo, tam, required){
        var si_tamanio, si_letra, si_mayuscula, si_numero;
        var campo = nodo.val();
        
        if (!required && campo == ''){
            nodo.next().text('');
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
                nodo.next().text('');
                return true;
            } else {
                nodo.next().text('El formato no es el correcto');
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
    
    
     $("#file").change(function(){
        readURL(this);
    });
    
     function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
    }
    

    
    
// Fin de la funcion autoejecutada    
});

