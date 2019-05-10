jQuery(document).ready(function ($) {

    //1.get hidden_data & init
    var list = [];
    var sentenceList = [];

    jQuery(".hidden_data .hidden_data__wordlist .word").each(function () {
        list.push($(this).text());
    });
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
    var wordIndex;

    var wordSound;
    
    var currentSentence;



    //2.start game

    $( ".startBtn" ).on( "click", document, function() {
        init();
        getWord();
        button.disabled = true;
    });

    function init(){
        button.disabled = false;
        points = 0;
        errors = 0;
        wordIndex=0;
        scoreDiv.innerHTML = points.toString()+'/'+list.length.toString();
        errorDiv.innerHTML = errors;
    }

    function getWord() {
        //a. build word spans
        words.innerHTML = "";
        var wordArray = list[wordIndex].split("");
        for (var i = 0; i < wordArray.length; i++) { //building the words with spans around the letters
            var span = document.createElement("span");
            span.classList.add("span");
            span.classList.add("transparent");
            span.innerHTML = wordArray[i];
            words.appendChild(span);
        }
        spans = document.querySelectorAll(".span");


        //b. show picture
        jQuery(".game_dictation").css("background-image", "url(../wp-content/uploads/userdata" + userID + "/picture/" + list[wordIndex]+")");



        //c. play sound
        wordSound = new Audio("../wp-content/uploads/userdata" + userID + "/word/" + list[wordIndex] + ".mp3");
        wordSound.pause();
        wordSound.currentTime = 0;
        wordSound.play();


        //d. store current sentence
        currentSentence=sentenceList[wordIndex];

        //e. prepare moving to next word
        wordIndex++;

        

    }


    $( ".replayBtn" ).on( "click", document, function() {
        wordSound.pause();
        wordSound.currentTime = 0;
        wordSound.play();
    });

    

    //3.keydown
    function isLetterOrSpace(str) {
        return str.length === 1 && str.match(/[a-z]/i) ||str==' ';
    }
    
    document.addEventListener("keydown", typing, false);
    function typing(e) {
        
        typed = String.fromCharCode(e.which);
        if(!isLetterOrSpace(typed))
            return;
        var isTypo=true;
        for (var i = 0; i < spans.length; i++) {
            if (spans[i].innerHTML.toUpperCase() === typed.toUpperCase()) { // if typed letter is the one from the word
                __typewriter.pause();
                __typewriter.currentTime = 0;
                __typewriter.play();
                isTypo=false;

                
                spans[i].classList.remove("transparent");

                if (spans[i].classList.contains("bg")) { // if it already has class with the bacground color then check the next one
                    continue;
                } else if (spans[i].classList.contains("bg") === false && spans[i - 1] === undefined || spans[i - 1].classList.contains("bg") !== false) { // if it dont have class, if it is not first letter or if the letter before it dont have class (this is done to avoid marking the letters who are not in order for being checked, for example if you have two "A"s so to avoid marking both of them if the first one is at the index 0 and second at index 5 for example)
                    spans[i].classList.add("bg");
                    break;
                }
            }
        }

        if(isTypo)
        {
            __error.pause();
            __error.currentTime = 0;
         

            var promise = __error.play();

         
            if (promise) {
                //Older browsers may not return a promise, according to the MDN website
                promise.catch(function(error) { console.error(error); });
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


                
                jQuery(".sentenceWrap").text(currentSentence);


                words.classList.add("animated");
                words.classList.add("fadeOut");
                points++; // increment the points
                scoreDiv.innerHTML = points.toString()+'/'+list.length.toString();

                

                document.removeEventListener("keydown", typing, false);
                setTimeout(function () {
                    if(wordIndex==list.length)
                    {
                        if(errors==0)
                        {
                            alert("well done! There should be fireworks");

                            //update score
                            jQuery.ajax({
                                url: _ajaxurl,
                                method: 'GET',
                                data: {
                                    action: 'updateScore',
                                    wordlist_id:wordlist_id,
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
                            getWord(); // give another word
                            document.addEventListener("keydown", typing, false);
                        }
                        else
                        {
                            alert("please try again!");
                            init();
                            words.className = "words"; // restart the classes
                            getWord(); // give another word
                            document.addEventListener("keydown", typing, false);
                        }
                    }
                    else{
                        words.className = "words"; // restart the classes
                        getWord(); // give another word
                        document.addEventListener("keydown", typing, false);
                    }
                        
                }, 400);
            }

        }
    }

    

});