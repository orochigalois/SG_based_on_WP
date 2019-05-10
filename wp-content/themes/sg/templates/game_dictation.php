<div class="hidden_data" style="display:none;">
    <div class="hidden_data__userID">
        <?php global $current_user;
        wp_get_current_user();
        echo $current_user->ID;
        ?>
    </div>
    <div class="hidden_data__wordlist_id">
        <?php 
        echo $_SESSION['wordlist_id'];
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
    
</div>
<h1 class="sentenceWrap">
</h1>