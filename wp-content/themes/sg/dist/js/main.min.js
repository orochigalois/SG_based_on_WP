jQuery(document).ready(function ($) {
    $(document.body).removeClass('no-js').addClass('js');

    initDownloadSound();

});

function isMobile() {
    return window.matchMedia('(max-width:767px)').matches;
}


function initDownloadSound() {
    jQuery(".sg_wordlist").on("click", document, function (event) {
        event.preventDefault();

        jQuery.ajax({
            url: _ajaxurl,
            method: 'GET',
            data: {
                action: 'downloadSound',
                title: jQuery(this).text(),
                wordlist_id: jQuery(this).data("wordlist_id"),
            },
            dataType: 'json',
            // async: false, 
            success: function (response) {
                if (response.status == 'success') {
                    console.log(response);

                    jQuery(".sg-current-label>span").text(response.title);

                }

            },
        });
    });
}