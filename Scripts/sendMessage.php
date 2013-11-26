<?php
session_start(); 
require_once '../Scripts/db.php';
require_once '../Scripts/common.php';
//sendMessage.php

if (isset($_SESSION['UserId']))
{

  if (validateInput())
  {
    
    // Add links to messages.
    $messageContent = strip_tags($_POST['messageContent']);
    $messageContent = makeLink($messageContent);
    
      $query = "INSERT INTO Message (
          MessageId, FromId, ToId,
          MessageContent
      )
      VALUES (
          NULL, '".mysql_real_escape_string(strip_tags($_SESSION['UserId']))."', '".
          mysql_real_escape_string(strip_tags($_POST['ToId']))."', '". 
          mysql_real_escape_string(($messageContent))."');";
     $result = mysql_query($query) or die(mysql_error());
  }

}
else
{
  // Blank or Error
  //echo "<h3>Please go to our <a href=\"User/Login.php\">Login page</a> to login to your account!</h3>"; 
  header("Location: User/Login.php");
}

function validateInput()
{
  
  // For now, this simply checks if the page has been submitted without input.
  // Blank input can occur when the processRegistration.php page has been opened 
  // without being redirected from the register.php page.
  /*
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
  */
  if ($_POST['ToId'] <= 0)
  {
    return False;
  }
  
  return True;
  
  
}

?>
