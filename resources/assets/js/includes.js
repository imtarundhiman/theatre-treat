window.$ = window.jQuery = require('jquery');

require('bootstrap3');

$(document).ready(function () {
    $('[data-toggle="offcanvas"]').click(function () {
        $('.row-offcanvas').toggleClass('active')
    });
});