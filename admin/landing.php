<?php
require_once '../load.php';

$time = time();

// define which timezone we are using/in
date_default_timezone_set('America/Toronto');

// define the current hour
$currentTime = date("H");


if ($currentTime < "12") {
echo "Morning! My friend!";
} 
//if they log in before 12pm, show good morning greeting

elseif ($currentTime >= "12" && $currentTime < "18") {
echo "Good afternoon!";
} 
//if they log in after or on 12pm and before 6pm, show afternoon greeting

elseif ($currentTime >= "18") {
echo "Good evening pal!";
} 
//if they log in after or on 6pm, show evening greeting


// last successful login 
setcookie('lastLogin', date("g:i - m/d/y"));
// use cookie to store user data of date and time of last login

if(isset($_COOKIE['lastLogin'])){
//if that cookie is set, show date and time

$showdatetime = $_COOKIE['lastLogin'];
echo " Your last visit was ". $showdatetime;

}


else{
echo "Haven't seen you in a while, welcome back!"; }

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome</h1>
</body>
</html>