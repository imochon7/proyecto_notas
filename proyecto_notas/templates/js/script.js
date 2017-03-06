$(document).ready(function () {
    var botonenvio = $("#sendbutton");
    botonenvio.on("click", evaluarformu);
    
    $("#sendbutton").attr("disabled", true);
    $("#sendbutton").addClass('desactivado');
    $(window).scroll(function () {
        var sT = $(this).scrollTop();
        if (sT >= 200) {
            $('header').addClass('cambio')
            $('#izq').addClass('resize')

        } else {
            $('header').removeClass('cambio')
            $('#izq').removeClass('resize')

        }
    });
    
    $("#remember_me").click(function() {
        var attr = $("#sendbutton").attr('disabled');
        $("#sendbutton").attr("disabled", !this.checked);
        if (typeof attr === typeof undefined && attr !== true) {
            $("#sendbutton").addClass('desactivado');
        }else{
            $("#sendbutton").removeClass('desactivado');
        }
    });
    
    ////////////////////////////////////////////////////////////
    function evaluarformu(evt) {
        evt.preventDefault();
        var contenidonombre = $("#nombreusuario").val();
        if (evaluamail() === true && contenidonombre !== ""){
            setTimeout(function () {
                $("#formnews").submit();
            }, 1000);
        } else {
            alert ('campos incorrectos');
        }
    };
    
    function evaluamail() {
        var patron = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
        var contenidomail = $("#emailnews").val();
        if (!patron.test(contenidomail)) {
            return false;
        } else {
            return true;
        }
    };
    
    
})