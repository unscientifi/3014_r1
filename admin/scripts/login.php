<?php


// session variables

$_SESSION['user-login'] = 0;
$_SESSION['loggedin-status'] = 0; // 0 is loggedin, 1 is logged out


// login function
function login($username, $password, $ip) {
     
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

      //logged in status
    $_SESSION['loggedin-status'] += 1;

    //  if ($_SESSION['loggedin-status'] == 1) {

    //     $message = 'maximum log in attempts reached, please wait 30 seconds';
              
    //         // get the current time and take the number of seconds
    //           $now =  substr(date("Y-m-d H:i:s"),-2);

    //           // if the number of seconds since the functoin was called is greater than 30, unlockout the user
    //           // and give them another 3 attempts

    //           if ($now >= 30){

    //               $_SESSION['user-login'] = 0;
    //               $_SESSION['loggedin-status'] = 0;
    //           } 

    //     // if the user is not locked out, check to see how many login attempts they took
    //     // if they tried to log in 3 times, then reset the attempts variable and lock the user out    

    // } elseif ($_SESSION['loggedin-status'] > 2) {
    //     // lock the user out 

    //     $_SESSION['loggedin-status'] = 1;
    //     $_SESSION['user-login'] = 0;
        
    //     $message = 'maximum log in attempts reached, please wait 30 seconds';


    // } else {

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
                $_SESSION['user_id'] = $id;
			    $_SESSION['user_name'] = $found_user['user_name'];
                
    
                // updates user ip when logged in
                $update_query = 'UPDATE tbl_user SET user_ip = :ip WHERE user_id = :id';
                $update_set = $pdo->prepare($update_query);
                $update_set->execute(
                    array(
                      ':ip'=>$ip,
                      ':id'=>$id
                    )
                );

                redirect_to('admin/landing.php');
            }

            if(empty($id)){
                $message = "Failed to login";
                return $message;
            }
            redirect_to('index.php');
      
    }

}
