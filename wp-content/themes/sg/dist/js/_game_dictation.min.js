jQuery(document).ready(function ($) {

    
    //1.get hidden_data & init
    var list = [];

    jQuery(".hidden_data .hidden_data__wordlist .word").each(function () {
        list.push($(this).text());
    });

    var userID = jQuery(".hidden_data .hidden_data__userID").text().trim();

    var spark = new Audio("../wp-content/themes/sg/sound/__hit.mp3");
    var __typewriter = new Audio("../wp-content/themes/sg/sound/__typewriter.mp3");
    var __error = new Audio("../wp-content/themes/sg/sound/__error.wav");

    var temp = document.querySelector('.time');
    var button = document.querySelector(".startBtn");
    var words = document.querySelector(".words");
    var timerDiv = document.querySelector(".time");
    var scoreDiv = document.querySelector(".score");
    var errorDiv = document.querySelector(".error");
    
    var spans;
    var typed;


    var points;
    var errors;
    var wordIndex;

    var wordSound;



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
        scoreDiv.innerHTML = points;
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
        //b. play word sound
        wordSound = new Audio("../wp-content/uploads/userdata" + userID + "/word/" + list[wordIndex] + ".mp3");
        wordSound.pause();
        wordSound.currentTime = 0;
        wordSound.play();

        //c. prepare moving to next word
        wordIndex++;

        

    }


    $( ".replayBtn" ).on( "click", document, function() {
        wordSound.pause();
        wordSound.currentTime = 0;
        wordSound.play();
    });


    
    

    // function countdown() {
    //     points = 0;
    //     var timer = setInterval(function () {
    //         button.disabled = true;
    //         seconds--;
    //         temp.innerHTML = seconds;
    //         if (seconds === 0) {
    //             alert("Game over! Your score is " + points);
    //             scoreDiv.innerHTML = "0";
    //             words.innerHTML = "";
    //             button.disabled = false;
    //             clearInterval(timer);
    //             seconds = 60;
    //             timerDiv.innerHTML = "60";
    //             button.disabled = false;
    //         }
    //     }, 1000);
    // }

    

    

    //3.keydown
    document.addEventListener("keydown", typing, false);
    function typing(e) {
        
        typed = String.fromCharCode(e.which);
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
            __error.play();
            errors++;
            errorDiv.innerHTML = errors; //add points to the points div
        }
        var checker = 0;
        for (var j = 0; j < spans.length; j++) { //checking if all the letters are typed
            if (spans[j].className === "span bg") {
                checker++;
            }
            if (checker === spans.length) { // if so, animate the words with animate.css class
                // spark.pause();
                // spark.currentTime = 0;
                // spark.play();
                words.classList.add("animated");
                words.classList.add("fadeOut");
                points++; // increment the points
                scoreDiv.innerHTML = points; //add points to the points div

                document.removeEventListener("keydown", typing, false);
                setTimeout(function () {
                    if(wordIndex==list.length)
                    {
                        if(errors==0)
                        {
                            alert("well done! There should be fireworks");
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