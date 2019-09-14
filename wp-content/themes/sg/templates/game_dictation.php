<div class="hidden_data" style="display:none;">
    <div class="hidden_data__userID">
        <?php global $current_user;
        echo $current_user->ID;
        ?>
    </div>
    <div class="hidden_data__post_id">
        <?php
        $post_id = get_user_meta($current_user->ID, 'sg_current_post', true);
        echo $post_id;
        ?>
    </div>

    <div class="hidden_data__wordlist">
        <?php
        $word_matrix = new WordMatrix($post_id);

        foreach ($word_matrix->data as $row) {
            $word = $row['word'];
            echo '<div class="word">' . $word . '</div>';
            $sentence = $row['sentence'];
            echo '<div class="sentence">' . $sentence . '</div>';
            $translate = $row['translation'];
            echo '<div class="translation">' . $translate . '</div>';
        }
        ?>
    </div>
</div>
<link href='https://fonts.googleapis.com/css?family=Audiowide|Nixie+One' rel='stylesheet' type='text/css'>

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

            <li>
                <input type="checkbox" id="translation-option" name="translation">
                <label for="translation-option">Translation</label>

                <div class="check">
                    <div class="inside"></div>
                </div>
            </li>
        </ul>
        <p id="game_staging_area_start_btn">START</p>
    </div>
</div>
<div class="game_dictation">


    <div class="btn_board">
        <p class="restart-btn">RESTART</p>
        <p class="pronounce-btn">PRONOUNCE</p>
        <p class="hint-btn">HINT</p>
        <p class="exit-btn">EXIT</p>
    </div>

    <div class="score_board">

        <p>Score</p>
        <span class="score"></span>

        <p>Error</p>
        <span class="error"></span>

        <p>Hint</p>
        <span class="hint"></span>

    </div>
    <input class="for_mobile_keyboard" type="text">
    <div class="words_board">
        <p class="words"></p>
    </div>

    <h1 class="sentence_board">
    </h1>
    <h1 class="translation_board">
    </h1>

</div>