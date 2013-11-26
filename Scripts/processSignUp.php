<?php
//processRegistration.php
///////////////////// main begins ///////////////////////
/*
if ($gender == "Female") $gender = "F";
else if ($gender == "Male") $gender = "M";
else $gender = "O";
*/
require_once ('common.php'); 
require_once ('facebook-php-sdk/src/facebook.php');
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

if ($facebookUserId) {
  $firstName = $user_profile['first_name'];
  $middleName = "";
  $lastName = $user_profile['last_name'];
  $facebookUsername = $user_profile['username'];
  $facebookEmail = $facebookUsername."@facebook.com";
/*
  $password = $user_profile['id'];
  
  $cleanpw = crypt(
    md5(strip_tags($password)),
    md5(strip_tags($email))
    );
*/
    
  if ( facebookExists($facebookUsername) )
  {
      echo "<h3>Sorry, but you appear to already be registered.</h3>";
  }
  else
  {
    
    $query = "INSERT INTO User (
        UserId, FirstName, MiddleName,
        LastName, EmailAddress, FacebookUsername,
        LoginPassword, PhoneNumber
    )
    VALUES (
        NULL, '".mysql_real_escape_string(strip_tags($firstName))."', '".
        mysql_real_escape_string(strip_tags($middleName))."', '". 
        mysql_real_escape_string(strip_tags($lastName))."', '".
        mysql_real_escape_string(strip_tags($facebookEmail))."', '".
        mysql_real_escape_string(strip_tags($facebookUsername))."', NULL, NULL );";
   $result = mysql_query($query) or die(mysql_error());
        
    echo "<h3>";
    echo "Thank you for registering your Facebook.";
    echo "A confirmation Facebook message has been sent.</h3>";
    echo "Note: This message will most likely appear in your <em>Other</em> messages box.";
    echo "To change that please find the message in <em>Other</em> and click on the <strong>Actions</strong> button above, ";
    echo "then select <strong>Move to Inbox</strong>.";
    
    // Send email
  $verifyURL = "http://cs.smu.ca/~g_wiechert/TextbookSavers/User/Login.php"; // FIX ME
  $to = $EmailAddress;
  $from = "g_wiechert@cs.smu.ca";
  $subject = "Password Reset for Textbook Savers";
  
  if (endsWith($EmailAddress,"@facebook.com")) // Check if is Facebook email 
  {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/plain;charset=iso-8859-1" . "\r\n";
    $message = "Go to here and reset your password: ".$verifyURL."\r\n";
    $message .= "Note: If applicable, to stop these messages from being hidden in the 'Other' inbox, ".
    "click on the 'Actions' button above, ".
    "then select 'Move to Inbox'.";
  }
  else
  {
    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $message = "
    <!DOCTYPE HTML>
    <html>
    <head>
    <title>Password Reset for Textbook Savers</title>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
    </head>
    <body>
    <p>Go to here and reset your password: </p><a href=\"".$verifyURL."\">".$verifyURL."</a>
    </body>
    </html>
    ";
  }
  // More headers
  $headers .= 'From: <'.$from.'>' . "\r\n";
  //$headers .= 'Cc: myboss@example.com' . "\r\n";
  mail($to,$subject,$message,$headers);
  
    
    
  }
}
else if (validateInput() == True)
{

  if (emailExists($email))
  {
      echo "<h3>Sorry, but your e-mail address is already registered.</h3>";
  }
  else
  {
    /*
      $unique_login = getUniqueID($loginName);
      if ($unique_login != $loginName)
      {
          echo "<h3 class=\"margin10\">Your preferred login name exists.<br />
              So ... we have assigned $unique_login as your login name.</h3>";
      }
    */
      
      $cleanpw = crypt(
      md5(strip_tags($_POST['loginPassword'])),
      md5(strip_tags($_POST['email']))
      );
  
      $query = "INSERT INTO User (
          UserId, FirstName, MiddleName,
          LastName, EmailAddress,
          LoginPassword, PhoneNumber
      )
      VALUES (
          NULL, '".mysql_real_escape_string(strip_tags($_POST['firstName']))."', '".
          mysql_real_escape_string(strip_tags($_POST['middleInitial']))."', '". 
          mysql_real_escape_string(strip_tags($_POST['lastName']))."', '".
          mysql_real_escape_string(strip_tags($_POST['email']))."', '".
          mysql_real_escape_string(strip_tags($cleanpw))."', '".
          mysql_real_escape_string(strip_tags($_POST['phone']))."'".
      ");";
      $customers = mysql_query($query)
          or die(mysql_error());
          
      echo "<h3>Thank you for registering.</h3>";

      // Send email
      $verifyURL = "";
      $to = $_POST['email'];
      $from = "g_wiechert@cs.smu.ca";
      $subject = "New User Verification for Textbook Savers";
      
      if (endsWith($EmailAddress,"@facebook.com")) // Check if is Facebook email 
      {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/plain;charset=iso-8859-1" . "\r\n";
        $message = "Go to here and sign in to complete verification: ".$verifyURL."\r\n";
        $message .= "Note: If applicable, to stop these messages from being hidden in the 'Other' inbox, ".
        "click on the 'Actions' button above, ".
        "then select 'Move to Inbox'.";
      }
      else
      {
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        $message = "
        <html>
        <head>
        <title>Password Reset for Textbook Savers</title>
        </head>
        <body>
        <p>Go to here and sign in to complete verification: </p><a href=\"".$verifyURL."\">".$resetURL."</a>
        </body>
        </html>
        ";
      }
      // More headers
      $headers .= 'From: <'.$from.'>' . "\r\n";
      //$headers .= 'Cc: myboss@example.com' . "\r\n";
      mail($to,$subject,$message,$headers);
      
      echo "<h3>A confirmation email has been sent.</h3>";
    }

}
else
{
  // Blank or Error
  echo "<h3>Please go to our <a href=\"User/SignUp.php\">Sign Up page</a> to register your account!</h3>"; 
}

///////////////////// main ends functions begin ///////////////////////
function emailExists($email)
{
    $query = "SELECT UserId FROM User WHERE EmailAddress = '".$email."'";
    $users = mysql_query($query)
        or die(mysql_error());
    $numRecords = mysql_num_rows($users);
    if ($numRecords > 0)
        return true;
    else
        return false;
}

function facebookExists($fusername)
{
    $query = "SELECT UserId FROM User WHERE FacebookUsername = '".$fusername."'";
    $users = mysql_query($query)
        or die(mysql_error());
    $numRecords = mysql_num_rows($users);
    if ($numRecords > 0)
        return true;
    else
        return false;
}

function checkEmail( $email ){
    return filter_var( $email, FILTER_VALIDATE_EMAIL );
}

function validateInput()
{
  
  // For now, this simply checks if the page has been submitted without input.
  // Blank input can occur when the processRegistration.php page has been opened 
  // without being redirected from the register.php page.
  
  if ( (strlen($_POST['firstName']) < 2 ) && (strpos($_POST['firstName'],' ') !==false) )
  {
    return False;
  }
  if ( (strlen($_POST['lastName']) < 2 ) && (strpos($_POST['lastName'],' ') !==false) )
  {
    return False;
  }
  if ( ($_POST['email'] == "") || !(checkEmail($_POST['email'])) )
  {
    return False;
  }
  if ($_POST['phone'] == "")
  {
    return False;
  }
  if ($_POST['loginPassword'] == "")
  {
    return False;
  }
  
  return True;
  
}

/*
function getUniqueID($loginName)
{
    $unique_login = $loginName;
    $query = "SELECT * FROM my_customers WHERE login_name = '$unique_login'";
    $customers = mysql_query($query)
        or die(mysql_error());
    $numRecords = mysql_num_rows($customers);
    for ($i = 0; $numRecords > 0; $i++)
    {
        $unique_login = $loginName.$i;
        $query = "SELECT * FROM my_customers WHERE login_name = '$unique_login'";
        $customers = mysql_query($query)
            or die(mysql_error());
        $numRecords = mysql_num_rows($customers);
    }
    return $unique_login;
}
*/

?>
