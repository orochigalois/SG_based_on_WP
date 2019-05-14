var userID;
var currentPage=1;
var currentWord;
var $currentImg;

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
		jQuery('.md-modal button').attr("disabled", true);
		jQuery('.md-modal select').attr("disabled", true);
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

					//update image
					jQuery(".md-modal .vocabulary>dl>img").each(function (index) {
						jQuery(this).on("click", function () {

							
							currentWord=jQuery(this).next().text();
							$currentImg=jQuery(this);
							currentPage=1;

							jQuery("body").css("cursor", "waiting");
							jQuery.ajax({
								url: _ajaxurl,
								method: 'GET',
								data: {
									action: 'get_images',
									page: currentPage,
									word:currentWord,
								},
								dataType: 'html',
								success: function (response) {
									jQuery("#image-overlay>ul").remove();
									jQuery("#image-overlay").append(response);
									jQuery("#image-overlay").css('display', 'flex');
									jQuery("body").css("cursor", "default");


									ajax_save_images();


									
			
								},
							});


						});
					});

					//prev page
					jQuery( "#image-overlay .prev" ).on( "click", document, function() {
						jQuery("body").css("cursor", "waiting");
						if(currentPage>1){
							currentPage--;
							jQuery.ajax({
								url: _ajaxurl,
								method: 'GET',
								data: {
									action: 'get_images',
									page: currentPage,
									word:currentWord,
								},
								dataType: 'html',
								success: function (response) {
									jQuery("#image-overlay>ul").remove();
									jQuery("#image-overlay").append(response);
									jQuery("body").css("cursor", "default");

									if(currentPage==1){
										jQuery( "#image-overlay .prev" ).addClass("greyout");
									}

									ajax_save_images();
									
							
								},
							});
						}
					});
					//next page
					jQuery( "#image-overlay .next" ).on( "click", document, function() {
						jQuery("body").css("cursor", "waiting");
						currentPage++;
						jQuery.ajax({
							url: _ajaxurl,
							method: 'GET',
							data: {
								action: 'get_images',
								page: currentPage,
								word:currentWord,
							},
							dataType: 'html',
							success: function (response) {
								jQuery("#image-overlay>ul").remove();
								jQuery("#image-overlay").append(response);
								jQuery("body").css("cursor", "default");
								jQuery( "#image-overlay .prev" ).removeClass("greyout");
								ajax_save_images();
							},
						});
						
					});

					

					jQuery( ".game-dictation" ).on( "click", document, function() {
						window.location.href = 'admin.php?page=sg_dictation_page';
					});

					jQuery('.md-modal button').attr("disabled", false);
					jQuery('.md-modal select').attr("disabled", false);

				}

			},
		});
	});
}


function ajax_save_images(){
	jQuery("#image-overlay>ul>li>img").each(function (index) {
		jQuery(this).on("click", function () {

			var src= jQuery(this).attr("src");
			$currentImg.attr("src",src);
			jQuery("#image-overlay").hide();


			
			
			jQuery.ajax({
				url: _ajaxurl,
				method: 'GET',
				data: {
					action: 'save_images',
					imageUrl: src,
					word:currentWord,
				},
				dataType: 'json',
				success: function (response) {
					if (response.status == 'success') {
						console.log(response);
					}
			
				},
			});
		});
	});
}