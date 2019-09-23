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
        $book = new Book($sentence_post->ID);
        $word_matrix = $book->get_matrix();

        foreach ($word_matrix as $row) {
            $sentence = strtolower($row['sentence']);
            echo '<div class="sentence">' . $sentence . '</div>';
        }
        ?>
    </div>
</div>

<div class="game_sentence">
    <div class="grey_background">
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
        <progress value="0" max="20" id="progressBar"></progress>
        <div class="flashcard">
        </div>

        <div class="wordsWrap">
            <p class="words"></p>
        </div>
    </div>


</div>