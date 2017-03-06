$(document).ready(function () {
    $('a[href^="#"]').on('click', function (e) {
        e.preventDefault();

        var target = this.hash;
        var $target = $(target);

        $('html, body').stop().animate({
            'scrollTop': $target.offset().top
        }, 900, 'swing', function () {
            window.location.hash = target;
        });
    });
});

var main = $('#headercontain'),
    imgwidth = 500,
    imgHeight = 300,
    imgRatio = imgHeight / imgwidth,
    mHeight = main.height();

$(window).resize(function () {
    var cmWidth = main.width(),
        cmRatio = mHeight / cmWidth;

    if (cmRatio >= imgRatio) {
        main.height(imgRatio * cmWidth);
    } else {
        main.height('70%');
    }
}).resize();