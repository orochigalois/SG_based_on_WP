<link href='https://fonts.googleapis.com/css?family=Audiowide|Nixie+One' rel='stylesheet' type='text/css'>
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

    <div class="hidden_data__sentenceList">
        <?php
        $book = new Book($post_id);
        $word_matrix = $book->get_matrix();

        foreach ($word_matrix as $row) {
            $sentence = $row['sentence'];
            echo '<div class="sentence">' . $sentence . '</div>';
            $translate = $row['sentence_in_native_language'];
            echo '<div class="translation">' . $translate . '</div>';
        }
        ?>
    </div>
</div>
<div class="alert">
    <h2></h2>
</div>
<div id="game_staging_area">
    <div class="container">
        <ul>

            <li>
                <input type="radio" id="sentence-option" name="mode" checked>
                <label for="sentence-option">Sentence</label>

                <div class="check">
                    <div class="inside"></div>
                </div>
            </li>

            <li>
                <input type="radio" id="translation-option" name="mode">
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

    <div class="background-image">

    </div>


    <div class="btn_board">
        <p class="restart-btn">RESTART</p>
        <p class="pronounce-btn">PRONOUNCE</p>
        <p class="hint-btn">HINT</p>
        <p class="exit-btn">EXIT</p>
    </div>


    <div class="toogle_board">
        <div class="toggle toggle--neon">
            <input type="checkbox" id="toggle--neon" class="toggle--checkbox">
            <label class="toggle--btn" for="toggle--neon" data-label-on="image" data-label-off="off"></label>
        </div>
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

    <div class="progress neon" data-width="0%">
        <div class="progress-text">20s</div>
        <div class="progress-bar" data-time="20">
            <div class="progress-text">20s</div>
        </div>
    </div>
    <div class="flashcard">
    </div>
    <div class="words_board">
        <p class="words"></p>
    </div>

    <h4 class="translation_board">
    </h4>

</div>