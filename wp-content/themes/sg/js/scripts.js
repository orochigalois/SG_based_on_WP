jQuery(document).ready(function ($) {
    $(document.body).removeClass('no-js').addClass('js');
});

function isMobile() {
    return window.matchMedia('(max-width:767px)').matches;
}