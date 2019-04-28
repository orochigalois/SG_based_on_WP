<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Typing game</title>
	<link href='https://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
    
    <style>
    * {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
}

body {
	background-color: #353535;
	font-family: 'Raleway', sans-serif;
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

h1 {
    color: #ecf0f1;
}

h1 + p {
	margin-bottom: 5%;
    color: #3498db;
}

.scoreWrap {float: left;}
.timeWrap {float: right;}

.outerWrap:after {
	content: "";
	display: block;
	clear: both;
}

.bg {
	background-color: #04AF71 !important;
}

button {
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

button:active {
  transform: translate(0px, 5px);
  -webkit-transform: translate(0px, 5px);
  box-shadow: 0px 1px 0px 0px;
}

.scoreWrap p, .scoreWrap span, .timeWrap p, .timeWrap span {
    font-size: 30px;
    color: #FF7373;
}

.wordsWrap {
	margin-top: 50px;
}

.words span{
    font-size: 60px;
    letter-spacing: 1px;
    color: #ECF0F1;
    background-color:#ECF0F1;
}





.wordlist{
    display: none;
}



    
    </style>

</head>
<body>


    <div class="wordlist">
        <div class="userID">

        <?php global $current_user;
        wp_get_current_user();
        echo $current_user->ID;
        ?>
        </div>
        <?php 
        $wordmatrix=$_SESSION['wordmatrix'];
        foreach($wordmatrix as $wordline){
            $word = strtolower($wordline['word']);
            echo '<div class="eachword">'.$word.'</div>';
        }
        ?>
    </div>
	<div class="wrapper">
		<button class="startBtn">START</button>
		<div class="outerWrap">
			<div class="scoreWrap">
				<p>Score</p>
				<span class="score">0</span>
			</div>
			<div class="timeWrap">
				<p>Time left</p>
				<span class="time">60</span>
			</div>
		</div>
		<div class="wordsWrap">
			<p class="words"></p>
		</div>
    </div>
    
</body>
</html>