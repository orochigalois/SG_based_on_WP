<style>
    body {
        background-color: #353535;
    }

    


    
</style>


<div class="hidden_data" style="display:none;">
    <div class="hidden_data__userID">
        <?php global $current_user;
        wp_get_current_user();
        echo $current_user->ID;
        ?>
    </div>

    <div class="hidden_data__wordlist">
        <?php
        $wordmatrix = $_SESSION['wordmatrix'];
        foreach ($wordmatrix as $wordline) {
            $word = strtolower($wordline['word']);
            echo '<div class="word">' . $word . '</div>';
        }
        ?>
    </div>
</div>

<div class="game_dictation">
    <button class="startBtn">START</button>
    <button class="replayBtn">REPLAY</button>
    <div class="outerWrap">
        <div class="scoreWrap">
            <p>Score</p>
            <span class="score">0</span>
        </div>
        <div class="errorWrap">
            <p>Error</p>
            <span class="error">0</span>
        </div>
    </div>
    <div class="wordsWrap">
        <p class="words"></p>
    </div>
</div>