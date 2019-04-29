<style>
    body {
        background-color: #353535;
    }

    .wrapper {
        max-width: 600px;
        margin: 0 auto;
        width: 100%;
        text-align: center;
        padding: 2%;
        background-color: #424242;
        height: 500px;
    }


    .scoreWrap {
        float: left;
    }

    .errorWrap {
        float: right;
    }

    .outerWrap:after {
        content: "";
        display: block;
        clear: both;
    }

    .bg {
        background-color: #04AF71 !important;
    }

    .transparent{
        color:transparent;
    }

    .startBtn {
        border: none;
        background-color: #FF7373;
        box-shadow: 0px 5px 0px 0px #CE4646;
        outline: none;
        border-radius: 5px;
        padding: 10px 15px;
        font-size: 22px;
        text-decoration: none;
        margin: 20px;
        color: #fff;
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .startBtn:active {
        transform: translate(0px, 5px);
        -webkit-transform: translate(0px, 5px);
        box-shadow: 0px 1px 0px 0px;
    }

    .scoreWrap p,
    .scoreWrap span,
    .errorWrap p,
    .errorWrap span {
        font-size: 30px;
        color: #FF7373;
    }

    .wordsWrap {
        margin-top: 50px;
    }

    .words span {
        font-size: 60px;
        letter-spacing: 1px;
        background-color:#ECF0F1;
        /* color: #ECF0F1; */

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

<div class="wrapper">
    <button class="startBtn">START</button>
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