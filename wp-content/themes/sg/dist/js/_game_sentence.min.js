jQuery(document).ready(function ($) {

    init_progressBar();

    //1.get hidden_data & init
    var sentenceList = [];
    var translationList = [];


    jQuery(".hidden_data .hidden_data__sentenceList .sentence").each(function () {
        sentenceList.push($(this).text());
    });
    jQuery(".hidden_data .hidden_data__sentenceList .translation").each(function () {
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
    var sentenceIndex = 0;

    //all bool
    var is_checked_sentence = false;
    var is_checked_translation = false;

    var letterIndex = 0;
    var timeleft_in_percentage;



    //2.staging logic
    $("#game_staging_area_start_btn").on("click", document, function () {

        init();

        $("#game_staging_area").slideUp();
        $(".alert").hide();


        ask_me_one_sentence();
    });


    //3.functions
    function init() {
        points = 0;
        errors = 0;
        hint = 3;
        sentenceIndex = 0;
        $score.innerHTML = points.toString() + '/' + sentenceList.length.toString();
        $error.innerHTML = errors;
        $hint.innerHTML = hint.toString();

        is_checked_sentence = $('#game_staging_area input[id="sentence-option"]').is(':checked');
        is_checked_translation = $('#game_staging_area input[id="translation-option"]').is(':checked');

        if (is_checked_sentence) {
            $(".words_board").hide();
            $(".translation_board").hide();
            $(".flashcard").show();
            $('.progress').css('width', '100%');
            $(".progress").show();


        }

        if (is_checked_translation) {
            $(".flashcard").hide();
            $(".progress").hide();
            $(".words_board").show();
            $(".translation_board").show();

        }



        document.addEventListener("keyup", function (event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // Cancel the default action, if needed
                event.preventDefault();

                timeleft_in_percentage = 0;
            }
        });
    }

    function ask_me_one_sentence() {
        build_word_spans();
        init_sound();


        play_sound();

        if (is_checked_sentence) {
            $(".flashcard").text(sentenceList[sentenceIndex]);
            timeleft_in_percentage = 100;
            var progressTimer = setInterval(function () {
                $('.progress-bar').css('width', timeleft_in_percentage + '%');
                $('.progress-bar').attr('data-time', timeleft_in_percentage / 5 + 's');

                if (timeleft_in_percentage == 0) {
                    clearInterval(progressTimer);
                    $(".progress").hide();
                    $(".flashcard").hide();
                    $(".words_board").show();
                    document.addEventListener("keydown", typing_handler, false);
                }
                timeleft_in_percentage -= 5;

            }, 1000);

        }

        if (is_checked_translation) {
            $(".translation_board").text(translationList[sentenceIndex]);
            document.addEventListener("keydown", typing_handler, false);
        }



        sentenceIndex++;
        letterIndex = 0;
    }

    function build_word_spans() {
        $words.innerHTML = "";
        var wordArray = sentenceList[sentenceIndex].split("");
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
        __word = new Audio("../wp-content/uploads/userdata" + user_id + "/sound/" + post_id + '_' + sentenceIndex + "_s.mp3");
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
        ask_me_one_sentence();
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
            letterIndex++;
            hint--;
            $hint.innerHTML = hint.toString();
            if (letterIndex == $spans.length) {
                well_done();
            }

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

    function isSymbol(str) {
        return str.length === 1 && str.match(/[\？\！\“\”\：\；\，\。\‘\’\'\"\:\;\,\<\>\/\?!@#\$%\^\&*\)\(+=._-]/i) || str == ' ';
    }



    function typing_handler(e) {

        var typed = e.key;
        var isTypo = true;

        if (isSymbol($spans[letterIndex].innerHTML.toUpperCase())) {
            isTypo = false;
        } else {
            if (!isLetterOrNumberOrSpaceOrDash(typed))
                return;
            if ($spans[letterIndex].innerHTML.toUpperCase() === typed.toUpperCase()) {
                isTypo = false;
            }
        }


        if (!isTypo) {
            play_typewriter_sound();



            $spans[letterIndex].classList.remove("transparent");
            $spans[letterIndex].classList.add("bg");

            letterIndex++;
        } else {
            play_error_sound();

            errors++;
            $error.innerHTML = errors; //add points to the points div
        }


        if (letterIndex == $spans.length) {
            well_done();
        }
    }

    function well_done() {


        if (is_checked_sentence) {
            $(".words_board").hide();
            $(".flashcard").show();
            $('.progress').css('width', '100%');
            $(".progress").show();
        }




        points++; // increment the points
        $score.innerHTML = points.toString() + '/' + sentenceList.length.toString();


        document.removeEventListener("keydown", typing_handler, false);
        setTimeout(function () {
            if (sentenceIndex == sentenceList.length) {
                if (errors <= 3) {
                    $("body canvas").fadeIn(2000);
                    fireworks = setInterval(launch, 3000);
                    //update score
                    $.ajax({
                        url: _ajaxurl,
                        method: 'GET',
                        data: {
                            action: 'updateScore',
                            post_id: post_id,
                            isSentenceGame: 'yes',
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
                ask_me_one_sentence(); // give another word
            }

        }, 400);
    }

    //6.progressBar
    function init_progressBar() {


        // create an observer instance
        var observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.type == 'attributes' && mutation.attributeName == 'style') {
                    var el = mutation.target;
                    var width = el.style.width; // Can't use jQuery here, as we need the value back in percent
                    var $parentEl = $(el).parent('.progress');
                    var time_in_seconds = $(el).attr('data-time');
                    $parentEl.attr('data-width', width); // Why doesn't this work?? $parentEl.data('width',width)
                    $parentEl.find('.progress-text').text(time_in_seconds);
                }
            });
        });

        // configuration of the observer
        var config = {
            attributes: true,
            attributeFilter: ['style'],
            childList: false,
            characterData: false
        };

        $('.progress-bar').each(function (e) {
            // pass in the target node, as well as the observer options
            observer.observe(this, config);
        })


    }


});