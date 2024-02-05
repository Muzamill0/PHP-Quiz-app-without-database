<?php
session_start();

$input = 0;

// Example quiz questions and answers (replace with your own)
$quizQuestions = [
    [
        "question" => "New Zealand has more sheep than people?",
        "correctAnswer" => "True"
    ],
    [
        "question" => "In Netherlands could you find a 'Cupboard Minister'",
        "correctAnswer" => "True"
    ],
    [
        "question" => "In Netherlands national animal is a mythical creature?",
        "correctAnswer" => "False"
    ],
    [
        "question" => "Switzerland consumes the most chocolate per capita?",
        "correctAnswer" => "True"
    ],
    [
        "question" => "In Pakistan it is illegal to step on money?",
        "correctAnswer" => "False"
    ],
    [
        "question" => "Spain has a festival dedicated to throwing tomatoes?",
        "correctAnswer" => "True"
    ],
    [
        "question" => "In Denmark you can find a building shaped like a basket?",
        "correctAnswer" => "False"
    ],
    [
        "question" => "In Australia Christmas celebrated every June?",
        "correctAnswer" => "True"
    ],
    [
        "question" => "Turkey has the world's oldest continuously operating amusement park?",
        "correctAnswer" => "False"
    ],
    [
        "question" => "In Turkey there is a town named Batman?",
        "correctAnswer" => "True"
    ]
];
if(isset($_SESSION['score']) || !empty($_SESSION['score'])){
    $Score = $_SESSION['score'];
} else{
    $_SESSION['score'] = 0;
}

if(isset($_SESSION['correct_question'])){
    $correct_question = $_SESSION['correct_question'];
} else{
    $correct_question = 0;
}
$incorrect = 0;
// Check for form submission
if (isset($_POST['answer'])) {

    $submittedAnswer = trim($_POST['answer']);
    // echo $submittedAnswer;
    $currentQuestion = $quizQuestions[$_SESSION['question_no']];

    if ($submittedAnswer == $quizQuestions[$_SESSION['question_no']]['correctAnswer']) {
        $Score = $Score + 4;
        $_SESSION['score'] = $Score;
        $correct_question++;
        if(isset($_SESSION['correct_question'])){
            $_SESSION['correct_question']++;
        } else{
            $_SESSION['correct_question'] = 1;
        }
    }


    // Move to the next question
    $_SESSION['question_no']++; 
    if($_SESSION['question_no'] >= 10){
        $input = 1;
    }
    loadQuestion($Score, $correct_question); 
} else {
    $Score = 0;
    $_SESSION['question_no'] = 0;
    loadQuestion($Score , $correct_question);
}

function loadQuestion($Score , $correct_question) {
    global $currentQuestionIndex, $quizQuestions, $question_no, $show_question;

    if (isset($_SESSION['question_no']) && $_SESSION['question_no'] < count($quizQuestions)) {
        $currentQuestionIndex = $_SESSION['question_no'];
        $currentQuestion = $quizQuestions[$currentQuestionIndex];
        $question_no = "<h1>Question " . ($currentQuestionIndex + 1) . "</h1>";
        $show_question = "<p>" . $currentQuestion['question'] . "</p>";
        $feedback = '';
    }  else {
        if (isset($_SESSION['nickname']) || isset($_SESSION['score'])){
            $user = $_SESSION['nickname'];
            $Score = $_SESSION['score'] ? $_SESSION['score'] : 0;
            if(isset($_SESSION['leaderboard'])){
                $leaderboard = $_SESSION['leaderboard'];
            } else{
                $leaderboard = [];
            }
        } else {
            $user = '';
        }

        
        $totalQuestions = $_SESSION['question_no'];
        $incorrectQuestions = $totalQuestions - $correct_question;

        $incorect_point = $incorrectQuestions * 2;

        $total_score = $Score - $incorect_point;
        
        $scoreArray = [
            'name' => $user,
            'quiz' => 'Countries',
            'score' => $total_score 
        ];

        
        array_push($leaderboard, $scoreArray);
        $_SESSION['leaderboard'] = $leaderboard;
        $question_no = "<h1>No more questions!</h1>";
        $show_question = "<p>Current Score is: $total_score</p>";

        if (isset($_SESSION['leaderboard'])) {
            $rawLeaderBoard = $_SESSION['leaderboard'];
        } else {
            $rawLeaderBoard = [];
        }
        
        // Aggregate scores for each user
        $aggregatedScores = [];
        foreach ($rawLeaderBoard as $entry) {
            $name = htmlspecialchars($entry['name']);
            $score = htmlspecialchars($entry['score']);
        
            if (!array_key_exists($name, $aggregatedScores)) {
                $aggregatedScores[$name] = $score;
            } else {
                $aggregatedScores[$name] += $score;
            }
        }
        
        // Convert aggregated scores back to the format suitable for the leaderboard
        $leaderBoard = [];
        $rank = 1;
        foreach ($aggregatedScores as $name => $score) {
            array_push($leaderBoard, ['rank' => $rank++, 'name' => $name, 'score' => $score]);
        }
        
        // Calculate the overall score
        $overallScore = array_sum(array_column($leaderBoard, 'score'));

        $show_question .= "<p>Total Score : $overallScore <br>Correct questions: $correct_question<br>Incorrect questions: $incorrectQuestions</p>";
        unset($_SESSION['score']);
        unset($_SESSION['correct_question']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Question</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <?php echo $question_no ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div>
                <?php echo $show_question ?>
            </div>
            <?php if($input == 0){ ?>
                <input type="radio" id="true" name="answer" value="True" checked>
                <label for="true">True</label><br>
                <input type="radio" id="false" name="answer" value="False">
                <label for="false">False</label><br>
            <button type="submit">Submit Answer</button>
            <?php } else{ ?>
                <a href='leader_board.php' class='button'>Exit</a>
                <?php } ?>
                <div>
            </div>
        </form>
    </div>
</body>
</html>
