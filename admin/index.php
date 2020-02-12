<?php
require_once('../load.php');
confirm_logged_in();
setcookie(time()); //this needs to be placed BEFORE html
date_default_timezone_set("America/Toronto"); // Sets the timezone to EST (America/Toronto)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="css/main.css">
    <title>Dashboard</title>
</head>

<body>

    <h2>Hello, <?php echo $_SESSION['user_name']; ?></h2>

    <hr>

    <section id="loginPage">

    <?php
    $hour = date("H");
    if ($hour < "12") {
        echo "Rise and shine! The early bird gets the worm!";
    } else if ($hour >= "12" && $hour < "22") {
        echo "Mid day mood! All day everyday!";
    } else {
        echo "It's pretty late! You should get some sleep!";
    }


    //Begin start of login time

    $loginTime = ($_COOKIE['user_date']); //establishes a cookie for when user is last logged in
    $timeQuery = 'SELECT * FROM tbl_user WHERE user_date = ' . $loginTime;

    if (!isset($_COOKIE[$timeQuery])) {
        echo 'You last visited on: ' . date('D, M. d, Y \a\t g:ia'); //This formats as the Day, Month, day (number), year at hour:minute
    } else {
        echo 'Welcome to my site!';
    }
    //End of login time

    ?>



    <a href="admin_login.php" id="return">index</a>

</body>

</html>