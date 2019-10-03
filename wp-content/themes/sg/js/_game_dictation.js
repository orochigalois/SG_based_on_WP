jQuery(document).ready(function ($) {

    //1.get hidden_data & init
    var wordList = [];
    var sentenceList = [];
    var translationList = [];

    jQuery(".hidden_data .hidden_data__wordlist .word").each(function () {
        wordList.push($(this).text());
    });
    jQuery(".hidden_data .hidden_data__wordlist .sentence").each(function () {
        sentenceList.push($(this).text());
    });
    jQuery(".hidden_data .hidden_data__wordlist .translation").each(function () {
        translationList.push($(this).text());
    });

    var user_id = jQuery(".hidden_data .hidden_data__userID").text().trim();
    var post_id = jQuery(".hidden_data .hidden_data__post_id").text().trim();

    //all sound resource
    var __typewriter = new Audio("../wp-content/themes/sg/sound/__typewriter.mp3");
    var __error = new Audio("../wp-content/themes/sg/sound/__error.wav");
    var __word;

    //all selectors
    var $words = document.querySelector(".words");
    var $score = document.querySelector(".score");
    var $error = document.querySelector(".error");
    var $hint = document.querySelector(".hint");
    var $spans;

    //numbers & index
    var points;
    var errors;
    var hint;
    var wordIndex = 0;


    //all bool
    var is_checked_sound = false;
    var is_checked_picture = false;
    var is_checked_sentence = false;
    var is_checked_translation = false;



    //2.staging logic
    $("#game_staging_area_start_btn").on("click", document, function () {

        is_checked_sound = $('#game_staging_area input[name="sound"]').is(':checked');
        is_checked_picture = $('#game_staging_area input[name="picture"]').is(':checked');
        is_checked_sentence = $('#game_staging_area input[name="sentence"]').is(':checked');
        is_checked_translation = $('#game_staging_area input[name="translation"]').is(':checked');

        var atLeastOneIsChecked = $('#game_staging_area input[type="checkbox"]:checked').length > 0;
        if (atLeastOneIsChecked) {
            $("#game_staging_area").slideUp();
            $(".alert").hide();

            init();
            ask_me_one_word();
        } else {
            $(".alert>h2").text("At least select one option below!");
            $(".alert").show();
        }
    });


    //3.functions
    function init() {
        points = 0;
        errors = 0;
        hint = 3;
        wordIndex = 0;
        $score.innerHTML = points.toString() + '/' + wordList.length.toString();
        $error.innerHTML = errors;
        $hint.innerHTML = hint.toString();
        document.addEventListener("keydown", typing_handler, false);
    }

    function build_word_spans() {
        $words.innerHTML = "";
        var wordArray = wordList[wordIndex].split("");
        for (var i = 0; i < wordArray.length; i++) { //building the words with spans around the letters
            var span = document.createElement("span");
            span.classList.add("span");
            span.classList.add("transparent");
            span.innerHTML = wordArray[i];
            $words.appendChild(span);
        }
        $spans = document.querySelectorAll(".span");
    }

    function init_sound() {
        __word = new Audio("../wp-content/uploads/userdata" + user_id + "/sound/" + post_id + '_' + wordIndex + ".mp3");
    }

    function play_sound() {

        __word.pause();
        __word.currentTime = 0;
        const playedPromise = __word.play();
        if (playedPromise) {
            playedPromise.catch((e) => {
                if (e.name === 'NotAllowedError' ||
                    e.name === 'NotSupportedError') {
                    //console.log(e.name);
                }
            });
        }
    }

    function play_typewriter_sound() {

        __typewriter.pause();
        __typewriter.currentTime = 0;
        const playedPromise = __typewriter.play();
        if (playedPromise) {
            playedPromise.catch((e) => {
                if (e.name === 'NotAllowedError' ||
                    e.name === 'NotSupportedError') {
                    //console.log(e.name);
                }
            });
        }
    }

    function play_error_sound() {

        __error.pause();
        __error.currentTime = 0;
        const playedPromise = __error.play();
        if (playedPromise) {
            playedPromise.catch((e) => {
                if (e.name === 'NotAllowedError' ||
                    e.name === 'NotSupportedError') {
                    //console.log(e.name);
                }
            });
        }
    }

    function show_picture() {
        jQuery(".game_dictation .background-image").css("background-image", "url(../wp-content/uploads/userdata" + user_id + "/picture/" + post_id + '_' + wordIndex + ")");
    }

    function hide_picture() {
        jQuery(".game_dictation .background-image").css("background-image", "none");
    }

    function show_sentence() {
        var pattern = wordList[wordIndex],
            re = new RegExp(pattern, "gi");
        var res = sentenceList[wordIndex].replace(re, "_____");

        jQuery(".sentence_board").text(res);
        jQuery(".sentence_board").show();
    }

    function hide_sentence() {
        jQuery(".sentence_board").hide();
    }

    function show_translation() {

        jQuery(".translation_board").text(translationList[wordIndex]);
        jQuery(".translation_board").show();
    }

    function hide_translation() {
        jQuery(".translation_board").hide();
    }


    function ask_me_one_word() {
        build_word_spans();
        init_sound();

        if (is_checked_sound)
            play_sound();
        if (is_checked_picture)
            show_picture();
        else
            hide_picture();
        if (is_checked_sentence)
            show_sentence();
        else
            hide_sentence();
        if (is_checked_translation)
            show_translation();
        else
            hide_translation();






        wordIndex++;
    }

    //4.btn_board
    function I_did_helped() {
        var helped = false;
        for (var i = 0; i < $spans.length; i++) {
            if (!$spans[i].classList.contains("transparent")) { // if it already has class with the bacground color then check the next one
                continue;
            }
            $spans[i].classList.remove("transparent");
            $spans[i].classList.add("bg");
            helped = true;
            break;
        }
        return helped;
    }
    $(".restart-btn").on("click", document, function () {
        init();
        ask_me_one_word();
    });
    $(".pronounce-btn").on("click", document, function () {
        __word.pause();
        __word.currentTime = 0;
        __word.play();
    });
    $(".hint-btn").on("click", document, function () {
        if (hint == 0) {
            play_error_sound();
            return;
        }

        if (I_did_helped()) {
            play_typewriter_sound();
            hint--;
            $hint.innerHTML = hint.toString();
        }

    });
    $(".exit-btn").on("click", document, function () {
        init();
        $("#game_staging_area").slideDown();
    });



    //5.typing_handler
    function isLetterOrNumberOrSpaceOrDash(str) {
        return str.length === 1 && str.match(/[0-9a-z-]/i) || str == ' ';
    }

    function typing_handler(e) {

        var typed = e.key;
        if (!isLetterOrNumberOrSpaceOrDash(typed))
            return;
        var isTypo = true;
        for (var i = 0; i < $spans.length; i++) {
            if ($spans[i].innerHTML.toUpperCase() === typed.toUpperCase()) { // if typed letter is the one from the word
                play_typewriter_sound();
                isTypo = false;


                $spans[i].classList.remove("transparent");

                if ($spans[i].classList.contains("bg")) { // if it already has class with the bacground color then check the next one
                    continue;
                } else if ($spans[i].classList.contains("bg") === false && $spans[i - 1] === undefined || $spans[i - 1].classList.contains("bg") !== false) { // if it dont have class, if it is not first letter or if the letter before it dont have class (this is done to avoid marking the letters who are not in order for being checked, for example if you have two "A"s so to avoid marking both of them if the first one is at the index 0 and second at index 5 for example)
                    $spans[i].classList.add("bg");
                    break;
                }
            }
        }

        if (isTypo) {
            play_error_sound();


            errors++;
            $error.innerHTML = errors; //add points to the points div
        }

        var checker = 0;
        for (var j = 0; j < $spans.length; j++) { //checking if all the letters are typed
            if ($spans[j].className === "span bg") {
                checker++;
            }
            if (checker === $spans.length) { // if so, animate the words with animate.css class

                points++; // increment the points
                $score.innerHTML = points.toString() + '/' + wordList.length.toString();



                document.removeEventListener("keydown", typing_handler, false);
                setTimeout(function () {
                    if (wordIndex == wordList.length) {
                        if (errors == 0) {
                            jQuery("body canvas").fadeIn(2000);
                            fireworks = setInterval(launch, 3000);

                            //update score
                            jQuery.ajax({
                                url: _ajaxurl,
                                method: 'GET',
                                data: {
                                    action: 'updateScore',
                                    post_id: post_id,
                                },
                                dataType: 'json',
                                success: function (response) {
                                    if (response.status == 'success') {
                                        init();
                                        $("#game_staging_area").slideDown();
                                    }

                                },
                            });


                        } else {
                            $("#game_staging_area").slideDown();
                            $(".alert>h2").text("Please try again!");
                            $(".alert").show();
                        }
                    } else {
                        ask_me_one_word(); // give another word
                        document.addEventListener("keydown", typing_handler, false);
                    }

                }, 400);
            }

        }
    }



});