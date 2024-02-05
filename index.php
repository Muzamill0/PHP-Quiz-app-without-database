<?php
session_start();
$name = $error = '';

if(isset($_POST['submit'])){
    $name = htmlspecialchars($_POST['nickname']);

    if(empty($name)){
        $error = 'Please enter the Nickname';
    } else{
        $_SESSION['nickname'] = $name;
        header('Location: option.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nickname</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Funny Facts</h1>
        <p>Please enter your nickname below:</p>
        <p class="error"><?php echo $error ?></p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <input type="text" name="nickname" placeholder="Enter your nickname">
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
</body>
</html>
