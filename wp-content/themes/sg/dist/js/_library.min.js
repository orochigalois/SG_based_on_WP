var userID
jQuery(document).ready(function ($) {
	userID = jQuery(".hidden_data .hidden_data__userID").text().trim();
	

	initChangeFont();

	initOpenModal();

});

function initChangeFont(){
	jQuery("#font-id").change(function() {
		jQuery('.md-modal .vocabulary').css("font-family", jQuery(this).val());
	});
}

function initOpenModal() {

	jQuery('.md-close').on('click', function () {
        jQuery('.md-modal').removeClass('md-show');
	});
	
	jQuery(".shelf .book").on("click", document, function (event) {
		jQuery(".md-modal .vocabulary>dl").empty();
		jQuery(".md-modal .vocabulary h1").empty();
		jQuery(".md-modal .vocabulary #loadIcon").fadeIn();
		jQuery('.md-modal').addClass('md-show');
		var title = jQuery(this).text();
		jQuery.ajax({
			url: _ajaxurl,
			method: 'GET',
			data: {
				action: 'getWords',
				wordlist_id: jQuery(this).data("wordlist_id"),
			},
			dataType: 'json',
			success: function (response) {
				if (response.status == 'success') {
					jQuery(".sg-current-label>span").text(title);
					jQuery(".md-modal .vocabulary #loadIcon").fadeOut();
					jQuery(".md-modal .vocabulary h1").append("Vocabulary - "+title);

					jQuery.each(response.wordMatrix, function(i, item) {
						wordHTML="<dt>"+response.wordMatrix[i].word+"</dt>";
						sentenceHTML="<dd>"+response.wordMatrix[i].sentence+"</dd>";
						imageHTML="<img src='"+"../wp-content/uploads/userdata" + userID + "/picture/" + response.wordMatrix[i].word+"'/>";
						jQuery(".md-modal .vocabulary>dl").append(imageHTML+wordHTML+sentenceHTML); 
					});

					jQuery(".md-modal .vocabulary>dl>dt").each(function (index) {
						jQuery(this).on("click", function () {
							wordSound = new Audio("../wp-content/uploads/userdata" + userID + "/word/" + jQuery(this).text() + ".mp3");
							wordSound.pause();
							wordSound.currentTime = 0;
							wordSound.play();
						});
					});

					jQuery(".md-modal .vocabulary>dl>dd").each(function (index) {
						jQuery(this).on("click", function () {
							sentenceSound = new Audio("../wp-content/uploads/userdata" + userID + "/sentence/" + jQuery(this).prev().text() + ".mp3");
							sentenceSound.pause();
							sentenceSound.currentTime = 0;
							sentenceSound.play();
						});
					});

					jQuery(".md-modal .vocabulary>dl>img").each(function (index) {
						jQuery(this).on("click", function () {


							var currentWord=jQuery(this).next().text();
							jQuery.ajax({
								url: _ajaxurl,
								method: 'GET',
								data: {
									action: 'get_images',
									page: 1,
									word:currentWord,
								},
								dataType: 'html',
								success: function (response) {
									jQuery(".md-modal #image-overlay").html(response);
									jQuery(".md-modal #image-overlay").show();
							
								},
							});




					// 		myDialog.currentWord=$(this)[0].parentNode.childNodes[0].innerHTML;
					// myDialog.currentImgID=$(this)[0].parentNode.childNodes[1].children[0].id;

                    // $('.eachLine').css('cursor', 'wait');
                    // $.post("m3_X_get_pic_from_bingAPI.php", {
					// 	picName: myDialog.currentWord,
                    //                 page: 1
                        
                    // }, function (data, status) {
                    //     $('.eachLine').css('cursor', 'default');
                    //     myDialog.page = 1;
                    //     $(".page").html("Page 1"); 
                    //     $(".caption").html(myDialog.currentWord);

                    //     document.getElementById("hide").innerHTML = data;
                    //     myDialog.show();

                    //     myDialog.content.innerHTML = "<table width=" + (myDialog.width - 26) + " height=" +
                    //         (myDialog.height - 96) + "><tr><td>" +
                    //         document.getElementById("hide").innerHTML + "</td></tr></table>"
					// });
					


						});
					});



					jQuery( ".game-dictation" ).on( "click", document, function() {
						window.location.href = 'admin.php?page=sg_dictation_page';
					});


					


					
				}

			},
		});
	});
}
