(function(){
    var confirmarBorrar = function(evento) {
        var objeto = evento.target;
        var r = confirm('Borrar?');
        if (r) {
        } else {
            evento.preventDefault();
        }
    }
    var a = document.getElementsByClassName('borrar');
    for (var i = 0; i < a.length; i++) {
        a[i].addEventListener('click', confirmarBorrar, false);
    }
})();