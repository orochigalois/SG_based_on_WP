jQuery(document).ready(function($){
    $(document.body).removeClass('no-js').addClass('js');

    initPolyfills();

    // Utilities
    initClassToggle();
    initAnchorScroll()

    // CF7 Form Control
    //initCF7();
    //initFullheightMobile();
});

function isMobile() {
    return window.matchMedia('(max-width:767px)').matches;
}

function initPolyfills() {
    // CSS object-fit for IE
    objectFitImages();

    // polyfill for IE - startsWith
    if (!String.prototype.startsWith) {
        String.prototype.startsWith = function(searchString, position) {
            position = position || 0;
            return this.indexOf(searchString, position) === position;
        };
    }
}

function initClassToggle() {
    // Toggle class on click
    $(document.body).on('click', '[data-toggle="class"][data-class]', function(event) {
        var $trigger = $(this);
        var $target = $($trigger.data('target') ? $trigger.data('target') : $trigger.attr('href'));

        if($target.length) {
            event.preventDefault();
            $target.toggleClass($trigger.data('class'));
            $trigger.toggleClass('classed');
        }
    });
}

function initAnchorScroll() {
    // Smooth anchor scrolling
    $('a[href*="#"]:not([data-toggle])').click(function(event) {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name="'+this.hash.slice(1)+'"]');
            if (target.length && !target.parents('.woocommerce-tabs').length) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
            }
        }
    });
}

// function initCF7(){
//     var wpcf7Elm = $('.wpcf7-form')[0];
//     var formbtn = $('.wpcf7-form input[type="submit"]');

//     formbtn.on('click', function(){
//         formbtn.val('SENDING...');
//     });

//     document.addEventListener( 'wpcf7invalid', function( event ) {
//         formbtn.val('SUBMIT');
//     }, false );

//     document.addEventListener( 'wpcf7mailsent', function( event ) {
//         formbtn.val('SENT!');
//     }, false );
// }

/*function initFullheightMobile() {
    // Fix mobile 100vh change on address bar show/hide
    var lastHeight = $(window).height();
    var heightChangeTimeout = undefined;
    if(isMobile()) {
        $('.vh').css('height', lastHeight);
    }
    (maybe_update_landing_height = function() {
        var winHeight = $(window).height();

        if(heightChangeTimeout !== undefined) {
            clearTimeout(heightChangeTimeout);
        }

        if(!isMobile()) {
            $('.vh').css('height', '');
        }
        else if(Math.abs(winHeight - lastHeight) > 100) {
            heightChangeTimeout = setTimeout(function() {
                var winHeight = $(window).height();
                $('.vh').css('height', winHeight);
                lastHeight = winHeight;
            }, 50);
        }
    })();
    $(window).resize(maybe_update_landing_height);
}*/

/*function initCopyToClipboard() {
  $(document.body).on('click', '[data-copy-to-clipboard]', function(event) {
    event.preventDefault();

    // Source: https://hackernoon.com/copying-text-to-clipboard-with-javascript-df4d4988697f
    var el = document.createElement('textarea');
    el.value = $(this).data('copy-to-clipboard');
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
  });
}*/