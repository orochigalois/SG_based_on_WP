jQuery(document).ready(function (jQuery) {

    //1.get hidden_data & init

    var sentenceList = [];
    var sentenceIndex;


    jQuery(".hidden_data .hidden_data__wordlist .sentence").each(function () {
        sentenceList.push(jQuery(this).text());
    });

    var userID = jQuery(".hidden_data .hidden_data__userID").text().trim();
    var post_id = jQuery(".hidden_data .hidden_data__post_id").text().trim();

    var __typewriter = new Audio("../wp-content/themes/sg/sound/__typewriter.mp3");
    var __error = new Audio("../wp-content/themes/sg/sound/__error.wav");


    var startBtn = document.querySelector(".startBtn");
    var words = document.querySelector(".words");
    var scoreDiv = document.querySelector(".score");
    var errorDiv = document.querySelector(".error");

    var spans;
    var typed;


    var points;
    var errors;


    var __word;


    var letterIndex = 0;
    var timeleft;


    //2.start game
    jQuery(".startBtn").on("click", document, function () {
        init();
        show_me_one_sentence();
    });

    function init_sound() {
        __word = new Audio("../wp-content/uploads/userdata" + userID + "/paragraph/" + post_id + "_" + sentenceIndex + ".mp3");
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


    function init() {
        points = 0;
        errors = 0;
        sentenceIndex = 0;
        scoreDiv.innerHTML = points.toString() + '/' + sentenceList.length.toString();
        errorDiv.innerHTML = errors;
        jQuery(".wordsWrap").hide();
        startBtn.disabled = true;


        document.addEventListener("keyup", function (event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // Cancel the default action, if needed
                event.preventDefault();

                timeleft = 100;
            }
        });
    }


    function show_me_one_sentence() {

        //a. build word spans
        words.innerHTML = "";
        var letterArray = sentenceList[sentenceIndex].split("");
        for (var i = 0; i < letterArray.length; i++) { //building the words with spans around the letters
            var span = document.createElement("span");
            span.classList.add("span");
            span.classList.add("transparent");
            span.innerHTML = letterArray[i];
            words.appendChild(span);
        }
        spans = document.querySelectorAll(".span");


        //b. show picture
        jQuery(".game_sentence").css("background-image", "url(../wp-content/uploads/userdata" + userID + "/picture/" + post_id + "_" + sentenceIndex + ")");



        //c. play sound

        init_sound();
        play_sound();

        //d. show flashcard
        jQuery(".flashcard").text(sentenceList[sentenceIndex]);
        timeleft = 0;
        var downloadTimer = setInterval(function () {
            document.getElementById("progressBar").value = timeleft;
            timeleft += 1;
            if (timeleft > 20) {
                clearInterval(downloadTimer);
                jQuery(".flashcard").hide();
                jQuery(".wordsWrap").show();
                turn_on_typing_listener();
            }
        }, 1000);


        //e. prepare moving to next word
        sentenceIndex++;
        letterIndex = 0;



    }


    jQuery(".replayBtn").on("click", document, function () {
        play_sound();
        jQuery(this).blur();
    });



    //3.keydown
    function isLetterOrSpaceOrDash(str) {
        return str.length === 1 && str.match(/[a-z-]/i) || str == ' ';
    }

    function isSymbol(str) {
        return str.length === 1 && str.match(/[\？\！\“\”\：\；\，\。\‘\’\'\"\:\;\,\<\>\/\?!@#\$%\^\&*\)\(+=._-]/i) || str == ' ';
    }

    function turn_on_typing_listener() {
        document.addEventListener("keydown", typing, false);
    }

    function turn_off_typing_listener() {
        document.removeEventListener("keydown", typing, false);
    }


    function typing(e) {

        typed = e.key;
        var isTypo = true;

        if (isSymbol(spans[letterIndex].innerHTML.toUpperCase())) {
            isTypo = false;
        } else {
            if (!isLetterOrSpaceOrDash(typed))
                return;
            if (spans[letterIndex].innerHTML.toUpperCase() === typed.toUpperCase()) {
                isTypo = false;
            }
        }


        if (!isTypo) {
            play_typewriter_sound();



            spans[letterIndex].classList.remove("transparent");
            spans[letterIndex].classList.add("bg");

            letterIndex++;
        } else {
            play_error_sound();

            errors++;
            errorDiv.innerHTML = errors; //add points to the points div
        }


        var checker = 0;
        for (var j = 0; j < spans.length; j++) { //checking if all the letters are typed
            if (spans[j].className === "span bg") {
                checker++;
            }
            if (checker === spans.length) { // if so, animate the words with animate.css class


                jQuery(".wordsWrap").hide();
                jQuery(".flashcard").show();


                points++; // increment the points
                scoreDiv.innerHTML = points.toString() + '/' + sentenceList.length.toString();


                turn_off_typing_listener();
                setTimeout(function () {
                    if (sentenceIndex == sentenceList.length) {
                        if (errors <= 3) {
                            // alert("well done! There should be fireworks");
                            jQuery("body canvas").fadeIn(2000);
                            fireworks = setInterval(launch, 3000);
                            //update score
                            jQuery.ajax({
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

                                        console.log(response);
                                        startBtn.disabled = false;
                                    }

                                },
                            });

                        } else {
                            alert("please try again!");
                            startBtn.disabled = false;
                        }

                    } else {
                        show_me_one_sentence(); // give another word
                    }


                }, 400);
            }

        }
    }



});