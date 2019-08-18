jQuery(document).ready(function (jQuery) {

    //1.get hidden_data & init

    var sentenceList = [];
    var sentenceIndex;


    jQuery(".hidden_data .hidden_data__wordlist .sentence").each(function () {
        sentenceList.push(jQuery(this).text());
    });

    var userID = jQuery(".hidden_data .hidden_data__userID").text().trim();
    var wordlist_id = jQuery(".hidden_data .hidden_data__wordlist_id").text().trim();

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


    var wordSound;


    var letterIndex = 0;
    var timeleft;


    //2.start game
    jQuery(".startBtn").on("click", document, function () {
        init();
        show_me_one_sentence();
    });

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
        jQuery(".game_sentence").css("background-image", "url(../wp-content/uploads/userdata" + userID + "/picture/" + wordlist_id + "_" + sentenceIndex + ")");



        //c. play sound
        wordSound = new Audio("../wp-content/uploads/userdata" + userID + "/paragraph/" + wordlist_id + "_" + sentenceIndex + ".mp3");
        wordSound.pause();
        wordSound.currentTime = 0;
        wordSound.play();

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
        wordSound.pause();
        wordSound.currentTime = 0;
        wordSound.play();
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
                                    wordlist_id: wordlist_id,
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

//__________________________Fireworks
var fireworks;

var SCREEN_WIDTH = window.innerWidth,
    SCREEN_HEIGHT = window.innerHeight,
    mousePos = {
        x: 400,
        y: 300
    },

    // create canvas
    canvas = document.createElement('canvas'),
    context = canvas.getContext('2d'),
    particles = [],
    rockets = [],
    MAX_PARTICLES = 400,
    colorCode = 0;

// init
jQuery(document).ready(function () {
    // jQuery('.game_sentence .for_canvas').append(canvas);
    document.body.appendChild(canvas);
    canvas.width = SCREEN_WIDTH;
    canvas.height = SCREEN_HEIGHT;

    setInterval(loop, 1000 / 50);
});

// update mouse position
jQuery(document).mousemove(function (e) {
    e.preventDefault();
    mousePos = {
        x: e.clientX,
        y: e.clientY
    };
});

// launch more rockets!!!
jQuery(document).mousedown(function (e) {
    jQuery("body canvas").fadeOut(2000);
    clearInterval(fireworks);
});

function launch() {
    for (var i = 0; i < 3; i++) {
        launchFrom(Math.random() * SCREEN_WIDTH * 2 / 3 + SCREEN_WIDTH / 6);
    }
}

function launchFrom(x) {
    if (rockets.length < 10) {
        var rocket = new Rocket(x);
        rocket.explosionColor = Math.floor(Math.random() * 360 / 10) * 10;
        rocket.vel.y = Math.random() * -3 - 4;
        rocket.vel.x = Math.random() * 6 - 3;
        rocket.size = 8;
        rocket.shrink = 0.999;
        rocket.gravity = 0.01;
        rockets.push(rocket);
    }
}

function loop() {
    // update screen size
    if (SCREEN_WIDTH != window.innerWidth) {
        canvas.width = SCREEN_WIDTH = window.innerWidth;
    }
    if (SCREEN_HEIGHT != window.innerHeight) {
        canvas.height = SCREEN_HEIGHT = window.innerHeight;
    }

    // clear canvas
    context.fillStyle = "rgba(0, 0, 0, 0.05)";
    context.fillRect(0, 0, SCREEN_WIDTH, SCREEN_HEIGHT);

    var existingRockets = [];

    for (var i = 0; i < rockets.length; i++) {
        // update and render
        rockets[i].update();
        rockets[i].render(context);

        // calculate distance with Pythagoras
        var distance = Math.sqrt(Math.pow(mousePos.x - rockets[i].pos.x, 2) + Math.pow(mousePos.y - rockets[i].pos.y, 2));

        // random chance of 1% if rockets is above the middle
        var randomChance = rockets[i].pos.y < (SCREEN_HEIGHT * 2 / 3) ? (Math.random() * 100 <= 1) : false;

        /* Explosion rules
         - 80% of screen
         - going down
         - close to the mouse
         - 1% chance of random explosion
         */
        if (rockets[i].pos.y < SCREEN_HEIGHT / 5 || rockets[i].vel.y >= 0 || distance < 50 || randomChance) {
            rockets[i].explode();
        } else {
            existingRockets.push(rockets[i]);
        }
    }

    rockets = existingRockets;

    var existingParticles = [];

    for (var i = 0; i < particles.length; i++) {
        particles[i].update();

        // render and save particles that can be rendered
        if (particles[i].exists()) {
            particles[i].render(context);
            existingParticles.push(particles[i]);
        }
    }

    // update array with existing particles - old particles should be garbage collected
    particles = existingParticles;

    while (particles.length > MAX_PARTICLES) {
        particles.shift();
    }
}

function Particle(pos) {
    this.pos = {
        x: pos ? pos.x : 0,
        y: pos ? pos.y : 0
    };
    this.vel = {
        x: 0,
        y: 0
    };
    this.shrink = .97;
    this.size = 2;

    this.resistance = 1;
    this.gravity = 0;

    this.flick = false;

    this.alpha = 1;
    this.fade = 0;
    this.color = 0;
}

Particle.prototype.update = function () {
    // apply resistance
    this.vel.x *= this.resistance;
    this.vel.y *= this.resistance;

    // gravity down
    this.vel.y += this.gravity;

    // update position based on speed
    this.pos.x += this.vel.x;
    this.pos.y += this.vel.y;

    // shrink
    this.size *= this.shrink;

    // fade out
    this.alpha -= this.fade;
};

Particle.prototype.render = function (c) {
    if (!this.exists()) {
        return;
    }

    c.save();

    c.globalCompositeOperation = 'lighter';

    var x = this.pos.x,
        y = this.pos.y,
        r = this.size / 2;

    var gradient = c.createRadialGradient(x, y, 0.1, x, y, r);
    gradient.addColorStop(0.1, "rgba(255,255,255," + this.alpha + ")");
    gradient.addColorStop(0.8, "hsla(" + this.color + ", 100%, 50%, " + this.alpha + ")");
    gradient.addColorStop(1, "hsla(" + this.color + ", 100%, 50%, 0.1)");

    c.fillStyle = gradient;

    c.beginPath();
    c.arc(this.pos.x, this.pos.y, this.flick ? Math.random() * this.size : this.size, 0, Math.PI * 2, true);

    c.closePath();
    c.fill();

    c.restore();
};

Particle.prototype.exists = function () {
    return this.alpha >= 0.1 && this.size >= 1;
};

function Rocket(x) {
    Particle.apply(this, [{
        x: x,
        y: SCREEN_HEIGHT
    }]);

    this.explosionColor = 0;
}

Rocket.prototype = new Particle();
Rocket.prototype.constructor = Rocket;

Rocket.prototype.explode = function () {
    var count = Math.random() * 10 + 80;

    for (var i = 0; i < count; i++) {
        var particle = new Particle(this.pos);
        var angle = Math.random() * Math.PI * 2;

        // emulate 3D effect by using cosine and put more particles in the middle
        var speed = Math.cos(Math.random() * Math.PI / 2) * 15;

        particle.vel.x = Math.cos(angle) * speed;
        particle.vel.y = Math.sin(angle) * speed;

        particle.size = 10;

        particle.gravity = 0.2;
        particle.resistance = 0.92;
        particle.shrink = Math.random() * 0.05 + 0.93;

        particle.flick = true;
        particle.color = this.explosionColor;

        particles.push(particle);
    }
};

Rocket.prototype.render = function (c) {
    if (!this.exists()) {
        return;
    }

    c.save();

    c.globalCompositeOperation = 'lighter';

    var x = this.pos.x,
        y = this.pos.y,
        r = this.size / 2;

    var gradient = c.createRadialGradient(x, y, 0.1, x, y, r);
    gradient.addColorStop(0.1, "rgba(255, 255, 255 ," + this.alpha + ")");
    gradient.addColorStop(1, "rgba(0, 0, 0, " + this.alpha + ")");

    c.fillStyle = gradient;

    c.beginPath();
    c.arc(this.pos.x, this.pos.y, this.flick ? Math.random() * this.size / 2 + this.size / 2 : this.size, 0, Math.PI * 2, true);
    c.closePath();
    c.fill();

    c.restore();
};