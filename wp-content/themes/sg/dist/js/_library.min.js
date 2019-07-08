var userID;
var currentPage = 1;
var currentWord;
var currentImg;

var currentPostID;
var currentTitle;

jQuery(document).ready(function ($) {
	userID = jQuery(".hidden_data .hidden_data__userID").text().trim();
	initChangeFont();
	initOpenModal();
});

function initChangeFont() {
	jQuery("#font-id").change(function () {
		jQuery('.md-modal .vocabulary').css("font-family", jQuery(this).val());
	});
}

function initOpenModal() {

	jQuery('.md-close').on('click', function () {
		jQuery('.md-modal').removeClass('md-show');
		jQuery("body").removeClass('book-open');
	});

	jQuery(".game-dictation").on("click", document, function () {
		window.location.href = 'admin.php?page=sg_dictation_page';
		jQuery("body").removeClass('book-open');
	});


	jQuery('.reload-all').on('click', function () {
		prepare_loading();
		ajax_get_words(currentPostID, 'no', currentTitle);
	});

	jQuery(".shelf .book").on("click", document, function (event) {
		prepare_loading();
		currentPostID = jQuery(this).data("wordlist_id");
		currentTitle = jQuery(this).text();
		var already_loaded = jQuery(this).data("already_loaded")
		ajax_get_words(currentPostID, already_loaded, currentTitle);

	});
}

function prepare_loading() {
	jQuery("body").addClass('book-open');
	jQuery(".md-modal .vocabulary>dl").empty();
	jQuery(".md-modal .vocabulary h1").empty();
	jQuery(".md-modal .vocabulary #loadIcon").fadeIn();
	jQuery('.md-modal').addClass('md-show');
	jQuery('.md-modal button').attr("disabled", true);
	jQuery('.md-modal select').attr("disabled", true);
}

function ajax_get_words(wordlist_id, already_loaded, title) {
	jQuery.ajax({
		url: _ajaxurl,
		method: 'GET',
		data: {
			action: 'getWords',
			wordlist_id: wordlist_id,
			already_loaded: already_loaded,
		},
		dataType: 'json',
		success: function (response) {
			if (response.status == 'success') {
				jQuery(".sg-current-label>span").text(title);
				jQuery(".md-modal .vocabulary #loadIcon").fadeOut();
				jQuery(".md-modal .vocabulary h1").append("Vocabulary - " + title);

				generateVocabularyHTML(response.wordMatrix);

				wordSoundHandler();

				sentenceSoundHandler();

				imageHandler();

				titleHandler(title, wordlist_id);








				jQuery('.md-modal button').attr("disabled", false);
				jQuery('.md-modal select').attr("disabled", false);

			}

		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

			alert('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
			console.log('jqXHR:');
			console.log(jqXHR);
			console.log('textStatus:');
			console.log(textStatus);
			console.log('errorThrown:');
			console.log(errorThrown);
		},
	});
}


function generateVocabularyHTML(wordMatrix) {
	jQuery.each(wordMatrix, function (i, item) {
		wordHTML = "<dt>" + wordMatrix[i].word + "</dt>";
		sentenceHTML = "<dd>" + wordMatrix[i].sentence + "</dd>";
		imageHTML = "<img src='" + "../wp-content/uploads/userdata" + userID + "/picture/" + wordMatrix[i].word + "'/>";
		jQuery(".md-modal .vocabulary>dl").append(imageHTML + wordHTML + sentenceHTML);
	});
}

function wordSoundHandler() {
	jQuery(".md-modal .vocabulary>dl>dt").each(function (index) {
		jQuery(this).on("click", function () {
			wordSound = new Audio("../wp-content/uploads/userdata" + userID + "/word/" + jQuery(this).text() + ".mp3");
			wordSound.pause();
			wordSound.currentTime = 0;
			wordSound.play();
		});
	});
}

function sentenceSoundHandler() {
	jQuery(".md-modal .vocabulary>dl>dd").each(function (index) {
		jQuery(this).on("click", function () {
			sentenceSound = new Audio("../wp-content/uploads/userdata" + userID + "/sentence/" + jQuery(this).prev().text() + ".mp3");
			sentenceSound.pause();
			sentenceSound.currentTime = 0;
			sentenceSound.play();
		});
	});
}

function imageHandler() {
	jQuery(".md-modal .vocabulary>dl>img").each(function (index) {
		jQuery(this).on("click", function () {

			currentWord = jQuery(this).next().text();
			currentImg = jQuery(this);
			currentPage = 1;

			jQuery("body").css("cursor", "waiting");
			jQuery.ajax({
				url: _ajaxurl,
				method: 'GET',
				data: {
					action: 'get_images',
					page: currentPage,
					word: currentWord,
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
	jQuery("#image-overlay .prev").on("click", document, function () {
		jQuery("body").css("cursor", "waiting");
		if (currentPage > 1) {
			currentPage--;
			jQuery.ajax({
				url: _ajaxurl,
				method: 'GET',
				data: {
					action: 'get_images',
					page: currentPage,
					word: currentWord,
				},
				dataType: 'html',
				success: function (response) {
					jQuery("#image-overlay>ul").remove();
					jQuery("#image-overlay").append(response);
					jQuery("body").css("cursor", "default");

					if (currentPage == 1) {
						jQuery("#image-overlay .prev").addClass("greyout");
					}

					ajax_save_images();


				},
			});
		}
	});
	//next page
	jQuery("#image-overlay .next").on("click", document, function () {
		jQuery("body").css("cursor", "waiting");
		currentPage++;
		jQuery.ajax({
			url: _ajaxurl,
			method: 'GET',
			data: {
				action: 'get_images',
				page: currentPage,
				word: currentWord,
			},
			dataType: 'html',
			success: function (response) {
				jQuery("#image-overlay>ul").remove();
				jQuery("#image-overlay").append(response);
				jQuery("body").css("cursor", "default");
				jQuery("#image-overlay .prev").removeClass("greyout");
				ajax_save_images();
			},
		});

	});
}

function titleHandler(title, wordlist_id) {
	jQuery(".md-modal .vocabulary>h1").on("click", function () {
		jQuery(".modal-body").empty().append(`
                <form id="updateTitle" action="">
					 <input class="form-control" type="text" name="title" value="${title}"/>
				</form>
             `);

		jQuery(".modal-footer").empty().append(`
                     <button type="button" type="submit" class="btn btn-primary" onClick="updateTitle(${wordlist_id})">Save changes</button>
                     <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                 
             `);
	});
}

function updateTitle(wordlist_id) {
	jQuery.ajax({
		url: _ajaxurl,
		method: 'GET',
		data: {
			action: 'update_title',
			title: jQuery('#updateTitle>input').val(),
			wordlist_id: wordlist_id,
		},
		dataType: 'json',
		success: function (response) {
			if (response.status == 'success') {
				console.log(response);
			}
	
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');
	
			alert('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
			console.log('jqXHR:');
			console.log(jqXHR);
			console.log('textStatus:');
			console.log(textStatus);
			console.log('errorThrown:');
			console.log(errorThrown);
		},
	});

}











function ajax_save_images() {
	jQuery("#image-overlay>ul>li>img").each(function (index) {
		jQuery(this).on("click", function () {

			var src = jQuery(this).attr("src");
			currentImg.attr("src", src);
			jQuery("#image-overlay").hide();




			jQuery.ajax({
				url: _ajaxurl,
				method: 'GET',
				data: {
					action: 'save_images',
					imageUrl: src,
					word: currentWord,
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