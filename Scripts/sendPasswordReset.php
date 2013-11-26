<?php 
session_start();
require "db.php";
include "common.php";

// Get email
$username = $_POST['UserName'];

// Check against User table
$sql = "SELECT UserId, EmailAddress FROM User WHERE EmailAddress = '".mysql_real_escape_string(strip_tags($username))."' LIMIT 0,1;";
$result = mysql_query($sql);
if (mysql_num_rows($result) > 0)
{
  list($UserId, $EmailAddress) = mysql_fetch_row($result);
  
  // Create SpecialActionId
  $specialActionId = substr(md5(rand()), 0, 32);
  $sql = "UPDATE User SET SpecialActionId='".$specialActionId."' WHERE EmailAddress='".mysql_real_escape_string(strip_tags($username))."' AND UserId='".$UserId."';";
  $result = mysql_query($sql);
  $resetURL = "http://cs.smu.ca/~g_wiechert/TextbookSavers/User/ResetPassword.php".
                "?username=".$username."&resetid=".$specialActionId;
  
  // Send email
  $to = $EmailAddress;
  $from = "g_wiechert@cs.smu.ca";
  $subject = "Password Reset for Textbook Savers";
  
  if (endsWith($EmailAddress,"@facebook.com")) // Check if is Facebook email 
  {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/plain;charset=iso-8859-1" . "\r\n";
    $message = "Go to here and reset your password: ".$resetURL."\r\n";
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
    <p>Go to here and reset your password: </p><a href=\"".$resetURL."\">".$resetURL."</a>
    </body>
    </html>
    ";
  }
  // More headers
  $headers .= 'From: <'.$from.'>' . "\r\n";
  //$headers .= 'Cc: myboss@example.com' . "\r\n";
  mail($to,$subject,$message,$headers);
  
  ?>

<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
?>
<!-- <link rel="stylesheet" type="text/css" href="Styles/login.php"> -->
<?PHP require '../Scripts/db.php'; ?>
<script src="Scripts/search.js"></script>
</head>
<body>
<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>
<div>
<?PHP  
if (endsWith($EmailAddress,"@facebook.com")) // Check if is Facebook email 
{
  echo "<p>A Facebook message has been sent to $username.</p>"; 
  echo "Note: This message will most likely appear in your <em>Other</em> messages box.";
  echo "To change that please find the message in <em>Other</em> and click on the <strong>Actions</strong> button above, ";
  echo "then select <strong>Move to Inbox</strong>.";  
}
else
{
  echo "<p>An email has been sent to $username.</p>"; 
}
?>
</div>
<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>

<?php
}
else
{
  // Username not found
header('Location: ../User/ForgotPassword.php?retry=true');
exit;

}

?>