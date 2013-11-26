<?php 
session_start(); 
// notifySeller.php
require '../Scripts/common.php';
require '../Scripts/db.php'; 

require ('../Scripts/facebook-php-sdk/src/facebook.php');
$facebook = new Facebook(array(
  'appId'  => '491456304233582',
  'secret' => 'b45471665c2327a933a9de4abb3c8031',
));
$user = $facebook->getUser();
?>


<!DOCTYPE html>
<html>
<head>
<?PHP
require '../Common/base.php'; 
include '../Common/meta.php';
?>
</head>
<body>
<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<?
$SaleId = $_POST['sid'];

if (isset($_SESSION['UserId']))
{
/*
$sql = "SELECT SellerId, TextbookId FROM Sale WHERE SaleId='".$sid."' LIMIT 0,1;";
$result = mysql_query($sql);
list($SellerId, $TextbookId) = mysql_fetch_row($result);

$sql = "SELECT Title FROM Textbook WHERE TextbookId='".$TextbookId."' LIMIT 0,1;";
$result = mysql_query($sql);
list($Title) = mysql_fetch_row($result);

$sql = "SELECT FirstName, LastName, EmailAddress, PhoneNumber, FacebookUsername FROM User WHERE UserId='".$sid."'";
$result = mysql_query($sql);
list($FirstName, $LastName, $Email, $Phone, $Facebook) = mysql_fetch_row($result);

$sql = "SELECT FirstName, LastName, EmailAddress, PhoneNumber, FacebookUsername FROM User WHERE UserId='".$_SESSION['UserId']."';";
$result = mysql_query($sql);
list($BuyerFirstName, $BuyerLastName, $BuyerEmail, $BuyerPhone, $BuyerFacebook) = mysql_fetch_row($result);
*/

function IsChecked($chkname,$value)
{
    if(!empty($_POST[$chkname]))
    {
        foreach($_POST[$chkname] as $chkval)
        {
            if($chkval == $value)
            {
                return true;
            }
        }
    }
    return false;
}

$sale = getSale($SaleId);
$textbook = getTextbook($sale['TextbookId']);
$sellerUser = getUser($sale['SellerId']);
$buyerUser = getUser($_SESSION['UserId']);

if (IsChecked("contact","PhoneNumber") || IsChecked("contact","FacebookUsername") || IsChecked("contact","EmailAddress"))
{
$messageToSelf =
  "Dear ".$sellerUser['FirstName']." " 
	        .$sellerUser['LastName'].",\r\n\r\n" 
	.$buyerUser['FirstName']." ".$buyerUser['LastName']." is interested in purchasing your textbook: ".$textbook['Title']."\r\n\r\n" .
	"".$buyerUser['FirstName']." can be contacted via:\r\n" .
	((IsChecked("contact","PhoneNumber"))?"Phone Number: " .$buyerUser['PhoneNumber']. "\r\n" : "" ).
	((IsChecked("contact","FacebookUsername"))?"Facebook Email: " .$buyerUser['FacebookUsername']. "@facebook.com\r\n" : "").
	((IsChecked("contact","EmailAddress"))?"Email Address: " .$buyerUser['EmailAddress']."\r\n" : "" );
	if ($_POST['message'] == '')
	{}
	else
	{	
	$messageToSelf .= "Message: ".$_POST['message']."\r\n";
	}

	 $query = "INSERT INTO Message (
  MessageId, FromId, ToId,
  MessageContent
  )
  VALUES (
  NULL, '".mysql_real_escape_string(strip_tags($buyerUser['UserId']))."', '".
  mysql_real_escape_string(strip_tags($sellerUser['UserId']))."', '". 
  mysql_real_escape_string(strip_tags($messageToSelf))."');";
/* // ***************************************************** BELOW HERE ***********************************************************************************
  $result = mysql_query($query) or die(mysql_error());
*/	
  $messageToSelf .= "\r\n--------------------\r\n This message was brought to you by Textbook Savers\r\n".
  "<a href=\"http://cs.smu.ca/~g_wiechert/TextbookSavers/Home.php\">http://cs.smu.ca/~g_wiechert/TextbookSavers/Home.php</a>\r\n--------------------\r\n";
	
	//Send the e-mail to business
$headerToSelf = "From: Textbook Savers <textbooksavers@hotmail.com>";
/* // ***************************************************** BELOW HERE ***********************************************************************************
mail($sellerUser['EmailAddress'], "Someone would like to purchase your Textbook!", $messageToSelf, $headerToSelf);
*/
//mail($buyerUser['EmailAddress'], "Someone would like to purchase your Textbook!", $messageToSelf, $headerToSelf);
$messageToClient =
//Construct the confirmation message to client
$messageToSelf.

//Send the confirmation to the client
$headerToClient = "";
//mail("textbooksavers@hotmail.com", "Textbook Savers", $messageToClient, $headerToSelf);
$display = str_replace("\r\n", "<br />\r\n", $messageToClient);
/*
$display =
  "<html><head><title>Textbook Savers - Your Message</title><body>".
  "<a href=\"User/Messages.php?uid=".$sellerUser['UserId']."\">Click here to view your message.</a><br /><br />".
  "<tt>".
	$display.
	"</tt></body></html>";
*/	
	
  /* ============ Using Message API =========== */	
	$baseURL = "http://cs.smu.ca/~g_wiechert/TextbookSavers/";
	$relativeURL = "User/Messages.php?uid=".$buyerUser['UserId'];
	$messageOptions = array( 'plaintext' => $buyerUser['FirstName']." ".$buyerUser['LastName']." wants to buy your textbook.".
    "\r\n For more info, please go to this link: ".$baseURL.$relativeURL, 
	'HTML' => $display."<h1>For more info, please go to this link: </h1><a href=\"".$baseURL.$relativeURL."\">".$baseURL.$relativeURL."</a>" );
	$replyOptions =  array( 'Facebook' => true, 'Email' => true, 'Phone' => true ); // ******** NOT YET IMPLEMENTED 
  //= Options 1) Message through all mediums.
  //$sendMessage =  sendMessage( $sellerUser['UserId'], $buyerUser['UserId'], $messageOptions, $replyOptions ); // MESSAGES USING ALL MEDIUMS.
  //= Option 2) Controlled messaging: more options, more control, more fun.
  // Get User Information
  //$FromUser = getUser($FromUserId);
  //$ToUser = getUser($ToUserId);
  //== Internal Message
  $messageWidget = iWantWidget($SaleId, $buyerUser, $_POST['message']);
  //$messageWidget = $display; // Widgets will be the future of Messaging!
  $sendInternalMessage = sendInternalMessage($buyerUser, $sellerUser, $messageWidget);
  //== Email
  sendEmail($buyerUser, $sellerUser, array('plaintext'=>$messageOptions['plaintext'], 'HTML'=>$display ), "Message from a Textbook Saver!", NULL);
  //== Facebook
  $facebookMessage = sendFacebookMessage($buyerUser, $sellerUser, $messageOptions['plaintext']);
  //== Facebook Notification
  //// sendFacebookNotification($buyerUser, $sellerUser, $message); // Currently using JavaScript, must find a way to do this in PHP...
  //== SMS 
  $SMS = sendSMS($buyerUser, $sellerUser, $messageOptions['plaintext']);
  
	?>
	<div class="page">

<?PHP 
echo $display;
//print_r($facebookMessage);
}
else
{
  ?>
	<script type="text/javascript">
	window.alert("ERROR: You did not provide a way to be contacted!")
	javascript:history.back()
	</script>
	<?php
}

}
else
{
?>
Please login.
<?PHP
}
?>

</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>


</body>
</html>

