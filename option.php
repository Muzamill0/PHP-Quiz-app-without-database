<?php 
 session_start();
//  if (isset($_SESSION['nickname'])) {
//     $nickname = $_SESSION['nickname'];
//     // Now you can use $nickname in your code
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Homepage</title>
    <link rel="stylesheet" href="css/option.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to our Quiz Homepage</h1>
        <div class="button-container">
            <a href="music.php" class="button">Music</a>
            <a href="countries.php" class="button">Countries</a>
            <a href="leader_board.php" class="button">Leaderboard</a>
            <a href="index.php" class="button">Exit</a>
        </div>
    </div>
</body>
</html>
