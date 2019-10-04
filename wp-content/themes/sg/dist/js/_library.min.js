var userID;
var isSentenceGame;

var currentPage = 1;
var currentWord;
var picture_name;
var currentImg;

var currentPostID;
var currentTitle;

var $currentBook;
var $currentWord;
var $currentSentence;

jQuery(document).ready(function ($) {
	userID = jQuery(".hidden_data .hidden_data__userID").text().trim();
	isSentenceGame = jQuery(".hidden_data .hidden_data__isSentenceGame").text().trim();
	initDeleteBook();
	initChangeFont();
	initOpenModal();
});

function initDeleteBook() {
	jQuery(document).on("click", ".delete-icon", function () {
		jQuery('body').toggleClass("delete-mode");
	});
}

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

	if (isSentenceGame == 'yes') {
		jQuery(".game-dictation").on("click", document, function () {
			window.location.href = 'admin.php?page=sg_sentence_page';
			jQuery("body").removeClass('book-open');
		});


	} else {
		jQuery(".game-dictation").on("click", document, function () {
			window.location.href = 'admin.php?page=sg_dictation_page';
			jQuery("body").removeClass('book-open');
		});


	}
	jQuery('.reload-all').on('click', function () {
		prepare_loading();
		ajax_get_words(currentPostID, 'yes', currentTitle);
	});

	jQuery(".shelf .book").on("click", document, function (event) {
		if (jQuery("body").hasClass("delete-mode")) {
			jQuery("#loadIcon").fadeIn();
			currentPostID = jQuery(this).data("post_id");
			$currentBook = jQuery(this);
			ajax_delete_book(currentPostID);



		} else {
			prepare_loading();
			$currentBook = jQuery(this);
			currentPostID = jQuery(this).data("post_id");
			currentTitle = jQuery(this).text();

			ajax_get_words(currentPostID, 'no', currentTitle);
		}


	});



}

function prepare_loading() {
	jQuery("body").addClass('book-open');
	jQuery(".md-modal .vocabulary>dl").empty();
	jQuery(".md-modal .vocabulary h1").empty();
	jQuery("#loadIcon").fadeIn();
	jQuery('.md-modal').addClass('md-show');
	jQuery('.md-modal button').attr("disabled", true);
	jQuery('.md-modal select').attr("disabled", true);
}

function ajax_get_words(post_id, reload_all, title) {
	jQuery.ajax({
		url: _ajaxurl,
		method: 'GET',
		data: {
			action: 'getWords',
			post_id: post_id,
			reload_all: reload_all,
			isSentenceGame: isSentenceGame,
		},
		dataType: 'json',
		success: function (response) {
			if (response.status == 'success') {
				jQuery(".sg-current-label>span").text(title);
				jQuery("#loadIcon").fadeOut();
				jQuery(".md-modal .vocabulary h1").empty().append("Vocabulary - " + title);
				generateVocabularyHTML(response.wordMatrix);
				if (isSentenceGame == 'no') {
					wordSoundHandler();
				}
				sentenceSoundHandler();
				if (isSentenceGame == 'no') {
					wordUpdateHandler();
				}
				sentenceUpdateHandler();
				imageHandler();
				titleHandler(post_id);
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
		if (isSentenceGame == 'yes') {
			wordHTML = "";
		} else {
			wordHTML = "<dt><span data-toggle='modal' data-target='#updateModal'>" + wordMatrix[i].word + "</span><span></span></dt>";
		}

		sentenceHTML = "<dd><span data-toggle='modal' data-target='#updateModal'>" + wordMatrix[i].sentence + "</span><span></span></dd>";

		imageHTML = "<img referrerpolicy=\"no-referrer\" src='" + "../wp-content/uploads/userdata" + userID + "/picture/" + currentPostID + "_" + i + "'/>";


		jQuery(".md-modal .vocabulary>dl").append(imageHTML + wordHTML + sentenceHTML);
	});
}





function wordSoundHandler() {
	jQuery(".md-modal .vocabulary>dl>dt>span:last-child").each(function (index) {
		jQuery(this).on("click", function () {

			wordSound = new Audio("../wp-content/uploads/userdata" + userID + "/sound/" + currentPostID + "_" + index + ".mp3");
			wordSound.pause();
			wordSound.currentTime = 0;
			wordSound.play();
		});
	});
}

function sentenceSoundHandler() {
	jQuery(".md-modal .vocabulary>dl>dd>span:last-child").each(function (index) {
		jQuery(this).on("click", function () {
			sentenceSound = new Audio("../wp-content/uploads/userdata" + userID + "/sound/" + currentPostID + "_" + index + "_s.mp3");
			sentenceSound.pause();
			sentenceSound.currentTime = 0;
			sentenceSound.play();
		});
	});
}

function wordUpdateHandler() {

	jQuery(".md-modal .vocabulary>dl>dt>span:first-child").each(function (index) {
		jQuery(this).on("click", function () {
			var word = jQuery(this).text();
			var sentence = jQuery(this).parent().next().children().first().text();
			$currentWord = jQuery(this);
			$currentSentence = jQuery(this).parent().next().children().first();

			jQuery(".modal-body").empty().append(`
				<form id="updateWord" action="">
					 <label for="word">Word</label>
					 <input class="form-control" type="text" name="word" value="${word}"/>
					 <label for="sentence">Sentence</label>
					 <input class="form-control" type="text" name="sentence" value="${sentence}"/>
				</form>
             `);

			jQuery(".modal-footer").empty().append(`
                     <button type="button" type="submit" class="btn btn-primary" onClick="updateWord(${index},${currentPostID})">Save changes</button>
                     <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                 
			 `);

		});
	});
}

function sentenceUpdateHandler() {
	jQuery(".md-modal .vocabulary>dl>dd>span:first-child").each(function (index) {
		jQuery(this).on("click", function () {
			var word = jQuery(this).parent().prev().children().first().text();
			var sentence = jQuery(this).text();

			$currentWord = jQuery(this).parent().prev().children().first();
			$currentSentence = jQuery(this);

			if (isSentenceGame == 'no') {
				jQuery(".modal-body").empty().append(`
				<form id="updateWord" action="">
					 <label for="word">Word</label>
					 <input class="form-control" type="text" name="word" value="${word}"/>
					 <label for="sentence">Sentence</label>
					 <input class="form-control" type="text" name="sentence" value="${sentence}"/>
				</form>
             `);

				jQuery(".modal-footer").empty().append(`
                     <button type="button" type="submit" class="btn btn-primary" onClick="updateWord(${index},${currentPostID})">Save changes</button>
                     <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                 
			 `);

			} else {

				jQuery(".modal-body").empty().append(`
				<form id="updateWord" action="">
					 <label for="sentence">Sentence</label>
					 <input class="form-control" type="text" name="sentence" value="${sentence}"/>
				</form>
             `);

				jQuery(".modal-footer").empty().append(`
                     <button type="button" type="submit" class="btn btn-primary" onClick="updateSentence(${index},${currentPostID})">Save changes</button>
                     <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                 
			 `);

			}
		});
	});
}

function updateWord(index, post_id) {
	var word = jQuery('#updateWord>input[name=word]').val();
	var sentence = jQuery('#updateWord>input[name=sentence]').val();
	jQuery('#updateModal').modal('hide');
	jQuery("#loadIcon").fadeIn();
	jQuery.ajax({
		url: _ajaxurl,
		method: 'GET',
		data: {
			action: 'update_word',
			index: index,
			post_id: post_id,
			word: word,
			sentence: sentence,
		},
		dataType: 'json',
		success: function (response) {
			if (response.status == 'success') {
				jQuery("#loadIcon").fadeOut();
				$currentWord.text(word);
				$currentSentence.text(sentence);
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

function updateSentence(index, post_id) {
	var sentence = jQuery('#updateWord>input[name=sentence]').val();
	jQuery('#updateModal').modal('hide');
	jQuery("#loadIcon").fadeIn();
	jQuery.ajax({
		url: _ajaxurl,
		method: 'GET',
		data: {
			action: 'update_sentence',
			index: index,
			post_id: post_id,
			sentence: sentence,
		},
		dataType: 'json',
		success: function (response) {
			if (response.status == 'success') {
				jQuery("#loadIcon").fadeOut();
				$currentSentence.text(sentence);
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




function imageHandler() {
	jQuery(".md-modal .vocabulary>dl>img").each(function (index) {
		jQuery(this).on("click", function () {
			jQuery("#loadIcon").fadeIn();


			currentWord = jQuery(this).next().children().eq(0).text();
			extraWord = jQuery('.extra-keyword').val();

			picture_name = currentPostID + "_" + index;
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
					extraWord: extraWord,
				},
				dataType: 'html',
				success: function (response) {
					jQuery(".image-overlay__content__body>ul").remove();
					jQuery(".image-overlay__content__body").append(response);
					jQuery(".image-overlay").show();
					jQuery("body").css("cursor", "default");


					ajax_save_images();
					jQuery("#loadIcon").fadeOut();




				},
			});


		});
	});

	jQuery(document).on("click", ".image-overlay__content__close", function () {
		jQuery(".image-overlay").hide();
	});

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function (event) {
		if (event.target == document.getElementById('image-overlay')) {
			jQuery(".image-overlay").hide();
		}
	}

	//prev page
	jQuery(".image-overlay__content__body .prev").on("click", document, function () {
		jQuery("#loadIcon").fadeIn();
		extraWord = jQuery('.extra-keyword').val();
		if (currentPage > 1) {
			currentPage--;
			jQuery.ajax({
				url: _ajaxurl,
				method: 'GET',
				data: {
					action: 'get_images',
					page: currentPage,
					word: currentWord,
					extraWord: extraWord,
				},
				dataType: 'html',
				success: function (response) {
					jQuery(".image-overlay__content__body>ul").remove();
					jQuery(".image-overlay__content__body").append(response);
					jQuery("#loadIcon").fadeOut();
					if (currentPage == 1) {
						jQuery(".image-overlay__content__body .prev").addClass("greyout");
					}

					ajax_save_images();


				},
			});
		}
	});
	//next page
	jQuery(".image-overlay__content__body .next").on("click", document, function () {
		jQuery("#loadIcon").fadeIn();
		extraWord = jQuery('.extra-keyword').val();
		currentPage++;
		jQuery.ajax({
			url: _ajaxurl,
			method: 'GET',
			data: {
				action: 'get_images',
				page: currentPage,
				word: currentWord,
				extraWord: extraWord,
			},
			dataType: 'html',
			success: function (response) {
				jQuery(".image-overlay__content__body>ul").remove();
				jQuery(".image-overlay__content__body").append(response);
				jQuery("#loadIcon").fadeOut();
				jQuery(".image-overlay__content__body .prev").removeClass("greyout");
				ajax_save_images();
			},
		});

	});
}

function titleHandler(post_id) {
	jQuery(".md-modal .vocabulary>h1").on("click", function () {
		jQuery(".modal-body").empty().append(`
                <form id="updateTitle" action="">
					 <input class="form-control" type="text" name="title" value="${currentTitle}"/>
				</form>
             `);

		jQuery(".modal-footer").empty().append(`
                     <button type="button" type="submit" class="btn btn-primary" onClick="updateTitle(${post_id})">Save changes</button>
                     <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                 
             `);
	});
}

function updateTitle(post_id) {
	currentTitle = jQuery('#updateTitle>input').val();
	jQuery('#updateModal').modal('hide');
	jQuery("#loadIcon").fadeIn();
	jQuery.ajax({
		url: _ajaxurl,
		method: 'GET',
		data: {
			action: 'update_title',
			title: currentTitle,
			post_id: post_id,
		},
		dataType: 'json',
		success: function (response) {
			if (response.status == 'success') {
				jQuery("#loadIcon").fadeOut();
				jQuery(".md-modal .vocabulary h1").empty().append("Vocabulary - " + currentTitle);
				$currentBook.text(currentTitle);
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
	jQuery(".image-overlay__content__body>ul>li>img").each(function (index) {
		jQuery(this).on("click", function () {
			var src = jQuery(this).attr("src");
			currentImg.attr("src", src);
			jQuery(".image-overlay").hide();
			jQuery.ajax({
				url: _ajaxurl,
				method: 'GET',
				data: {
					action: 'save_images',
					imageUrl: src,
					picture_name: picture_name,
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



function ajax_delete_book(post_id) {
	jQuery.ajax({
		url: _ajaxurl,
		method: 'GET',
		data: {
			action: 'delete_book',
			post_id: post_id,
		},
		dataType: 'json',
		success: function (response) {
			if (response.status == 'success') {
				jQuery("#loadIcon").fadeOut();
				$currentBook.parent().remove();
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