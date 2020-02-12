<?php


// session variables

$_SESSION['user-login'] = 0;

$_SESSION['user-loggedin'] = 0; // 0 is loggedin, 1 is logged out


// login function
function login($username, $password, $ip) {
    
    //logged in status
    
    $_SESSION['user-loggedin'] += 1;
    
    // connect to database
     $pdo = Database::getInstance()->getConnection();

     //Check existence
     $check_exist_query = 'SELECT COUNT(*) FROM tbl_user WHERE user_name= :username';
     $user_set = $pdo->prepare($check_exist_query);
     $user_set->execute(
         array(
             ':username' => $username,
         )
     );

  

     if ($_SESSION['user-loggedin'] == 1) {

        $message = 'You reached the maximum log in, please wait and try again';
              
            // fetch current time and take the number of seconds
              $now =  substr(date("Y-m-d H:i:s"),-2);
                $message = "What's your password? Wait and think!";
              // give them another 3 attempts after the wait

              if ($now >= 15){

                  $_SESSION['user-login'] = 0;
                  $_SESSION['user-loggedin'] = 0;
              } 

       //

    } elseif ($_SESSION['user-login'] > 3) {
        // lock the user out 

        redirect_to('../logout.php');
        
        $_SESSION['user-loggedin'] = 1;
        $_SESSION['user-login'] = 0;

       

        $message = 'maximum log in attempts reached, please wait 30 seconds';


    } else {

// if the user isnt locked out and has not reached 3 attempts, then check their credentials to see if 
// the username and pw is valid 


        if($user_set->fetchColumn()>0){
        
            //User exists
            $get_user_query = 'SELECT * FROM tbl_user WHERE user_name = :username';
            $get_user_query .= ' AND user_pass = :password';
            $user_check = $pdo->prepare($get_user_query);
            $user_check->execute(
                array(
                    ':username'=>$username,
                    ':password'=>$password
                )
                );
    
            while($found_user = $user_check->fetch(PDO::FETCH_ASSOC)){
                $id = $found_user['user_id'];
               
                $message = 'You just logged in';
                
    
                // updates user ip when logged in
                $update_query = 'UPDATE tbl_user SET user_ip = :ip WHERE user_id = :id';
                $update_set = $pdo->prepare($update_query);
                $update_set->execute(
                    array(
                      ':ip'=>$ip,
                      ':id'=>$id
                    )
                );


                // reset and go to the landing page 
                $_SESSION['user-login'] = 0;
                $_SESSION['user-loggedin'] = 0;
                redirect_to('admin/landing.php');
            }

            if(empty($id)){
                $message = "Failed to login";
                return $message;
            }
            redirect_to('index.php');
      
    }

}

}