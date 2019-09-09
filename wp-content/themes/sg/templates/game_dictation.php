<div class="hidden_data" style="display:none;">
    <div class="hidden_data__userID">
        <?php global $current_user;
        wp_get_current_user();
        echo $current_user->ID;
        ?>
    </div>
    <div class="hidden_data__post_id">
        <?php
        echo $_SESSION['post_id'];
        ?>
    </div>

    <div class="hidden_data__wordlist">
        <?php
        $wordMatrix = $_SESSION['wordMatrix'];
        foreach ($wordMatrix as $wordline) {
            $word = strtolower($wordline['word']);
            echo '<div class="word">' . $word . '</div>';
            $sentence = strtolower($wordline['sentence']);
            echo '<div class="sentence">' . $sentence . '</div>';
        }
        ?>
    </div>
</div>
<link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
<div class="alert">
    <h2></h2>
</div>
<div id="game_staging_area">
    <div class="container">
        <ul>
            <li>
                <input type="checkbox" id="sound-option" name="sound" checked>
                <label for="sound-option">Sound</label>

                <div class="check"></div>
            </li>

            <li>
                <input type="checkbox" id="picture-option" name="picture">
                <label for="picture-option">Picture</label>

                <div class="check">
                    <div class="inside"></div>
                </div>
            </li>

            <li>
                <input type="checkbox" id="sentence-option" name="sentence">
                <label for="sentence-option">Sentence</label>

                <div class="check">
                    <div class="inside"></div>
                </div>
            </li>
        </ul>
        <p id="game_staging_area_start_btn">START</p>
    </div>
</div>
<div class="game_dictation">
    <button class="startBtn">START</button>
    <button class="replayBtn">REPLAY</button>
    <div class="outerWrap">
        <div class="scoreWrap">
            <p>Score</p>
            <span class="score"></span>
        </div>
        <div class="errorWrap">
            <p>Error</p>
            <span class="error"></span>
        </div>
    </div>
    <div class="wordsWrap">
        <img src="">
        <p class="words"></p>
    </div>

    <h1 class="sentenceWrap">
    </h1>

</div>