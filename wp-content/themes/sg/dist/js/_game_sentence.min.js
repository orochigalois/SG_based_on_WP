jQuery(document).ready(function ($) {

    //1.get hidden_data & init

    var sentenceList = [];
    var sentenceIndex;


    jQuery(".hidden_data .hidden_data__wordlist .sentence").each(function () {
        sentenceList.push($(this).text());
    });

    var userID = jQuery(".hidden_data .hidden_data__userID").text().trim();
    var wordlist_id = jQuery(".hidden_data .hidden_data__wordlist_id").text().trim();

    var __typewriter = new Audio("../wp-content/themes/sg/sound/__typewriter.mp3");
    var __error = new Audio("../wp-content/themes/sg/sound/__error.wav");

    var button = document.querySelector(".startBtn");
    var words = document.querySelector(".words");
    var scoreDiv = document.querySelector(".score");
    var errorDiv = document.querySelector(".error");

    var spans;
    var typed;


    var points;
    var errors;


    var wordSound;


    var letterIndex = 0;



    //2.start game
    $(".startBtn").on("click", document, function () {
        init();
        show_me_one_sentence();
        button.disabled = true;
    });

    function init() {
        button.disabled = false;
        points = 0;
        errors = 0;
        sentenceIndex = 0;
        scoreDiv.innerHTML = points.toString() + '/' + sentenceList.length.toString();
        errorDiv.innerHTML = errors;
        jQuery(".wordsWrap").hide();
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
        jQuery(".game_dictation").css("background-image", "url(../wp-content/uploads/userdata" + userID + "/picture/" + wordlist_id + "_" + sentenceIndex + ")");



        //c. play sound
        wordSound = new Audio("../wp-content/uploads/userdata" + userID + "/paragraph/" + wordlist_id + "_" + sentenceIndex + ".mp3");
        wordSound.pause();
        wordSound.currentTime = 0;
        wordSound.play();

        //d. show flashcard
        jQuery(".flashcard").text(sentenceList[sentenceIndex]);
        var timeleft = 0;
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


    $(".replayBtn").on("click", document, function () {
        wordSound.pause();
        wordSound.currentTime = 0;
        wordSound.play();
    });



    //3.keydown
    function isLetterOrSpaceOrDash(str) {
        return str.length === 1 && str.match(/[a-z-]/i) || str == ' ';
    }

    function isSymbol(str) {
        return str.length === 1 && str.match(/[\'\"\:\;\,\<\>\/\?!@#\$%\^\&*\)\(+=._-]/i) || str == ' ';
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
            __typewriter.pause();
            __typewriter.currentTime = 0;
            __typewriter.play();



            spans[letterIndex].classList.remove("transparent");
            spans[letterIndex].classList.add("bg");

            letterIndex++;
        } else {
            __error.pause();
            __error.currentTime = 0;


            var promise = __error.play();


            if (promise) {
                //Older browsers may not return a promise, according to the MDN website
                promise.catch(function (error) {
                    console.error(error);
                });
            }

            // if (promise !== undefined) {
            //   promise.then(_ => {
            //     // Autoplay started!
            //   }).catch(error => {
            //     // Autoplay was prevented.
            //     // Show a "Play" button so that user can start playback.
            //   });
            // }

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
                        if (errors == 0) {
                            alert("well done! There should be fireworks");

                            //update score
                            jQuery.ajax({
                                url: _ajaxurl,
                                method: 'GET',
                                data: {
                                    action: 'updateScore',
                                    wordlist_id: wordlist_id,
                                    isSentenceGame: 'yes',
                                },
                                dataType: 'json',
                                success: function (response) {
                                    if (response.status == 'success') {
                                        console.log(response);
                                    }

                                },
                            });

                            init();
                            words.className = "words"; // restart the classes
                            show_me_one_sentence(); // give another word
                        } else {
                            alert("please try again!");
                            init();
                            words.className = "words"; // restart the classes
                            show_me_one_sentence(); // give another word
                        }

                    } else {
                        words.className = "words"; // restart the classes
                        show_me_one_sentence(); // give another word

                    }


                }, 400);
            }

        }
    }



});