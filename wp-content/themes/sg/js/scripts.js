jQuery(document).ready(function($){
    $(document.body).removeClass('no-js').addClass('js');

   
    // CF7 Form Control
    //initCF7();
    //initFullheightMobile();




    initDownloadSound();
});

function isMobile() {
    return window.matchMedia('(max-width:767px)').matches;
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


function initDownloadSound() {
    jQuery(".sg_wordlist").on("click", document, function (event) {
        event.preventDefault();

        jQuery.ajax({
            url: _ajaxurl,
            method: 'GET',
            data: {
                action: 'downloadSound',
                title: jQuery(this).text(),
                wordlist_id:jQuery(this).data("wordlist_id"),
            },
            dataType: 'json',
           // async: false, 
            success: function (response) {
                if(response.status=='success'){
                    console.log(response);

                    jQuery( ".sg-current-label>span" ).text(response.title);

                }
                
            },
        });
    });
}