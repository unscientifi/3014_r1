<?php
require_once '../load.php';

$ip = $_SERVER['REMOTE_ADDR'];

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        //Put the login here
        $message = login($username, $password, $ip);
    } else {
        $message = 'Please fill out the required fields';
    }
}

//failed login attempts section here
if (!empty($password)) { //if the password is incorrect or left empty, itll be a FAILED login
    if (isset($_SESSION['loginAttempts'])) {
        $_SESSION['loginAttempts']++; //this adds the number of logins you can do before getting blocked
        if ($_SESSION['loginAttempts'] > 3) {
            echo 'You have exceeded the amount of login attempts! Please try again later! Sorry about that :(';
?>

<?php
        }
    } else {
        $_SESSION['loginAttempts'] = 1; //this shows a message on the first attempt of logging in
        echo 'Please make sure to fill in the correct information';
    }
}

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

    <title>Welcome to Login page</title>
</head>

<body>

    <section>
        <h1>Welcome back! Welcome to the sign in page!</h1>
    </section>
    <?php echo !empty($message) ? $message : ''; ?>
    <form action="admin_login.php" method="post">
        <label>Username: </label><br>
        <input type="text" name="username" value="" /><br>

        <label>Password:</label><br>
        <input type="password" name="password" value="" /><br>

        <button name="submit">Submit</button>
    </form>
</body>

</html>