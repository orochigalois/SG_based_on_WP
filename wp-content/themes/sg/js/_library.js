var userID;
var isSentenceGame;

var currentPage = 1;
var currentWord;
var currentSentence;
var currentImg;

var currentPostID;
var currentTitle;

var $currentBook;
var $currentWord;
var $currentSentence;

jQuery(document).ready(function ($) {
	userID = jQuery(".hidden_data .hidden_data__userID").text().trim();
	isSentenceGame = jQuery(".hidden_data .hidden_data__isSentenceGame").text().trim();
	initChangeFont();
	initOpenModal();
});

var string_to_slug = function (str) {
	str = str.replace(/^\s+|\s+$/g, ''); // trim
	str = str.toLowerCase();

	// remove accents, swap ñ for n, etc
	var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
	var to = "aaaaeeeeiiiioooouuuunc------";

	for (var i = 0, l = from.length; i < l; i++) {
		str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
	}

	str = str.replace('.', '-') // replace a dot by a dash 
		.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
		.replace(/\s+/g, '-') // collapse whitespace and replace by a dash
		.replace(/-+/g, '-'); // collapse dashes

	return str;
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
		ajax_get_words(currentPostID, 'no', currentTitle);
	});

	jQuery(".shelf .book").on("click", document, function (event) {
		prepare_loading();
		$currentBook = jQuery(this);
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
	jQuery("#loadIcon").fadeIn();
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
					sentenceUpdateHandler();
				}



				imageHandler();

				

				if (isSentenceGame == 'no') {
					titleHandler(wordlist_id);
				}








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
		if (isSentenceGame == 'yes') {
			imageHTML = "<img src='" + "../wp-content/uploads/userdata" + userID + "/picture/" + currentPostID +"_"+i + "'/>";
		} else {
			imageHTML = "<img src='" + "../wp-content/uploads/userdata" + userID + "/picture/" + wordMatrix[i].word + "'/>";
		}
	
		jQuery(".md-modal .vocabulary>dl").append(imageHTML + wordHTML + sentenceHTML);
	});
}

function wordSoundHandler() {
	jQuery(".md-modal .vocabulary>dl>dt>span:last-child").each(function (index) {
		jQuery(this).on("click", function () {
			wordSound = new Audio("../wp-content/uploads/userdata" + userID + "/word/" + jQuery(this).prev().text().toLowerCase() + ".mp3");
			wordSound.pause();
			wordSound.currentTime = 0;
			wordSound.play();
		});
	});
}

function sentenceSoundHandler() {
	jQuery(".md-modal .vocabulary>dl>dd>span:last-child").each(function (index) {
		jQuery(this).on("click", function () {
			if (isSentenceGame == 'yes') {
				sentenceSound = new Audio("../wp-content/uploads/userdata" + userID + "/paragraph/" + + currentPostID +"_"+index + ".mp3");
			} else {
				sentenceSound = new Audio("../wp-content/uploads/userdata" + userID + "/sentence/" + jQuery(this).parent().prev().children().first().text().toLowerCase() + ".mp3");
			}

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

function updateWord(index, wordlist_id) {
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
			wordlist_id: wordlist_id,
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




function imageHandler() {
	jQuery(".md-modal .vocabulary>dl>img").each(function (index) {
		jQuery(this).on("click", function () {
			jQuery("#loadIcon").fadeIn();

			
			currentWord = jQuery(this).next().children().eq(0).text();

			currentSentence = currentPostID+"_"+index;
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
					jQuery("#loadIcon").fadeOut();




				},
			});


		});
	});

	//prev page
	jQuery("#image-overlay .prev").on("click", document, function () {
		jQuery("#loadIcon").fadeIn();
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
					jQuery("#loadIcon").fadeOut();
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
		jQuery("#loadIcon").fadeIn();
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
				jQuery("#loadIcon").fadeOut();
				jQuery("#image-overlay .prev").removeClass("greyout");
				ajax_save_images();
			},
		});

	});
}

function titleHandler(wordlist_id) {
	jQuery(".md-modal .vocabulary>h1").on("click", function () {
		jQuery(".modal-body").empty().append(`
                <form id="updateTitle" action="">
					 <input class="form-control" type="text" name="title" value="${currentTitle}"/>
				</form>
             `);

		jQuery(".modal-footer").empty().append(`
                     <button type="button" type="submit" class="btn btn-primary" onClick="updateTitle(${wordlist_id})">Save changes</button>
                     <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                 
             `);
	});
}

function updateTitle(wordlist_id) {
	currentTitle = jQuery('#updateTitle>input').val();
	jQuery('#updateModal').modal('hide');
	jQuery("#loadIcon").fadeIn();
	jQuery.ajax({
		url: _ajaxurl,
		method: 'GET',
		data: {
			action: 'update_title',
			title: currentTitle,
			wordlist_id: wordlist_id,
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
					sentence: currentSentence,
					isSentenceGame:isSentenceGame,
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