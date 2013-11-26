<?php
// processLogin.php
session_start();
require "db.php";

if ($_GET['FacebookLogin']==True) {
  require ('facebook-php-sdk/src/facebook.php');
  $facebook = new Facebook(array(
    'appId'  => '491456304233582',
    'secret' => 'b45471665c2327a933a9de4abb3c8031',
  ));
  //save the access token for later
  $accessToken = $facebook->getAccessToken();
  // Get User ID
  $facebookUserId = $facebook->getUser();
  if ($facebookUserId) {
    try {
      // Proceed knowing you have a logged in user who's authenticated.
      $facebook->setAccessToken($accessToken);
      $user_profile = $facebook->api('/me');
    } catch (FacebookApiException $e) {
      error_log($e);
      $facebookUserId = null;
    }
  }
  
  if (isset($user_profile) && $user_profile != "")
  {
    
    $firstName = $user_profile['first_name'];
    $middleName = "";
    $lastName = $user_profile['last_name'];
    $facebookUsername = $user_profile['username'];
    $facebookEmail = $facebookUsername."@facebook.com";
    
    $UserName = mysql_real_escape_string(strip_tags($facebookUsername));
    $query = "SELECT * FROM User WHERE FacebookUsername = \"".$UserName."\";";
    $rowsWithMatchingLoginName = mysql_query($query)
        or die(mysql_error());
    $numRecords = mysql_num_rows($rowsWithMatchingLoginName);
    
    if ($numRecords == 1)
    {
    
      $row = mysql_fetch_array($rowsWithMatchingLoginName);
      if ($facebookUsername == $row['FacebookUsername']) // FIXME: Redundant // Temporarily
      {
        //echo "Found User";
        $_SESSION["UserId"] = $row["UserId"];
        //$_SESSION["salutation"] = $row["salutation"];
        $_SESSION["UserFirstName"] = $row["FirstName"];
        $_SESSION["UserMiddleName"] = $row["MiddleName"];
        $_SESSION["UserLastName"] = $row["LastName"];
        /*
        if (isset($_SERVER['HTTP_REFERER']) && 
        end(explode('/',$_SERVER['HTTP_REFERER'])) != 'Login.php' && 
        end(explode('/',$_SERVER['HTTP_REFERER'])) != 'Logout.php' && 
        end(explode('/',$_SERVER['HTTP_REFERER'])) != 'CompeteSignUp.php') {
          //echo("Location: " . $_SERVER['HTTP_REFERER']);
          //exit;
        } else {
          //echo("Location: ../Home.php");
          //exit;
        }
        */
        $query = "UPDATE `User` SET LastLogin=now() WHERE UserId='".$_SESSION['UserId']."';";
        $lastLogin = mysql_query($query) or die(mysql_error());
    
        echo "<p>Thank you for using Facebook Connect.</p>";
        echo "<p>You will be redirectly shortly to your person account page.</p>";
        echo "<p>If you are not redirected, please click <a href=\"User/MyAccount.php\">here</a>.</p>";
        //header("Location: ../User/MyAccount.php");	
      }
    }
    else
    {
      echo "<p>No user account is linked with this Facebook account.</p>";
      echo "<p>Please login normally and then connect your account with your Facebook account.</p>";
    }
    
  }
  else
  {
    echo "<p>You are not properly signed into Facebook. Please try again.</p>";
  }
  
}
else
{
  $UserName = mysql_real_escape_string(strip_tags($_POST['UserName']));
  $query = "SELECT * FROM User 
              WHERE EmailAddress = \"".$UserName."\";";
  $rowsWithMatchingLoginName = mysql_query($query)
      or die(mysql_error());
  $numRecords = mysql_num_rows($rowsWithMatchingLoginName);
  
  if ($numRecords == 1)
  {
  
    $cleanpw = crypt(
        md5(strip_tags($_POST['UserPassword'])),
        md5(strip_tags($_POST['UserName']))
        ); 
        
    $row = mysql_fetch_array($rowsWithMatchingLoginName);
    if ($cleanpw == $row["LoginPassword"])
    {
      //echo "Found User";
      $_SESSION["UserId"] = $row["UserId"];
      //$_SESSION["salutation"] = $row["salutation"];
      $_SESSION["UserFirstName"] = $row["FirstName"];
      $_SESSION["UserMiddleName"] = $row["MiddleName"];
      $_SESSION["UserLastName"] = $row["LastName"];
      /*
      if (isset($_SERVER['HTTP_REFERER']) && 
      end(explode('/',$_SERVER['HTTP_REFERER'])) != 'Login.php' && 
      end(explode('/',$_SERVER['HTTP_REFERER'])) != 'Logout.php' && 
      end(explode('/',$_SERVER['HTTP_REFERER'])) != 'CompeteSignUp.php') {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
      } else {
        header("Location: ../Home.php");
        exit;
      }
      */
      header("Location: ../User/MyAccount.php");
      exit;
    }
  }
//echo "Username and/or password is not correct.";
header('Location: ../User/Login.php?retry=true');
exit;
}

?>