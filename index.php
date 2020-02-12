<?php

require_once 'load.php';

// use php session
session_start();
$ip = $_SERVER['REMOTE_ADDR'];

//if submit  failed 
if(isset($_POST['submit'])){
    
           
// login username and password, trim extra space
$username = trim($_POST['username']);
$password = trim($_POST['password']);

// if user entered info 
if(!empty($username) && !empty($password)) {
    // log in
    $message = login($username, $password, $ip);
} 
}

echo 'Login attempts: '.$_SESSION['loggedin-status'];




 ?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
</head>
<body>
    <fieldset>
        <form name="LoginForm" method="post" action="#">

        <label for="username" class="label">Username:</label>
        <input id="username" name="username" type="text" class="input" />
     
        <label for="password" class="label">Password:</label>
        <input id="password" name="password" type="password" class="input" />

        <input type="submit" name="submit" value="Login" class="left" />
        </form>
        <?php echo !empty($message)? $message: ''; ?>
        </fieldset>
</body>
</html>