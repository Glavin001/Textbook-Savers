<?php 
session_start();
require "db.php";
include "common.php";
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
// Get email
$username = $_POST['username'];
$resetid = $_POST['resetid'];
$newPassword = $_POST['loginPassword'];

// Reset Password
$cleanpw = crypt(
      md5(strip_tags($newPassword)),
      md5(strip_tags($username))
      );
$sql = "UPDATE User SET SpecialActionId=NULL, LoginPassword='".mysql_real_escape_string(strip_tags($cleanpw))."' WHERE EmailAddress='".mysql_real_escape_string(strip_tags($username))."' AND SpecialActionId='".mysql_real_escape_string(strip_tags($resetid))."';";
$result = mysql_query($sql);

// Send email
$to = $username;
$from = "g_wiechert@cs.smu.ca";
$subject = "Password Reset for Textbook Savers";
$message = "There was just recently a password reset on your account.
If you did not perform this, we advise you change your password now, again, to protect your account from the party responsible.";
if ( !(endsWith($username,"@facebook.com")) ) // Check if is Facebook email 
{
  $message = "
  <html>
  <head>
  <title>Password Reset for Textbook Savers</title>
  </head>
  <body>
  <p>".$message."</p>
  </body>
  </html>
  ";
}
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
// More headers
$headers .= 'From: <'.$from.'>' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";
mail($to,$subject,$message,$headers);

?>

<p>Password reset complete.</p>

</div>
<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>