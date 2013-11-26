<?php 
session_start(); 
require '../Scripts/db.php'; 
require '../Scripts/common.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:fb="https://www.facebook.com/2008/fbml">
<script src="http://connect.facebook.net/en_US/all.js"></script>
<!DOCTYPE html>
<html>
	

<head>
<title>Contact Seller</title>

<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
require ('../Scripts/facebook-php-sdk/src/facebook.php');
$facebook = new Facebook(array(
  'appId'  => '491456304233582',
  'secret' => 'b45471665c2327a933a9de4abb3c8031',
));
$userTest = $facebook->getUser();
echo $userTest;
?>

<!-- <link rel="stylesheet" type="text/css" href="Styles/home.php"> -->

<script src="Scripts/search.js"></script>
<script src="Scripts/livevalidation_standalone.compressed.js"></script>

</head>

<body>
<script type="text/javascript" src="scripts/validateEmail.js"></script>


<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="page">

<?PHP
if (isset($_SESSION['UserId']))
{
?>
<form id='myform' name="contact" method="post" action="Scripts/notifySeller.php">

<h3>Contact Seller</h3>
<?PHP
$SaleId = $_GET['sid'];
$sale = getSale($SaleId);
$user = getUser($sale['SellerId']);
$textbook = getTextbook($sale['TextbookId']);

$query = "SELECT SellerId FROM Sale WHERE SaleId='".$SaleId."';";
$seller = mysql_query($query);
list($SellerId) = mysql_fetch_row($seller);

$sql = "SELECT FacebookId FROM User WHERE UserId='".$SellerId."';";
$result = mysql_query($sql);
list($FacebookId) = mysql_fetch_row($result);

$sql = "SELECT PhoneNumber FROM User WHERE UserId='".$_SESSION['UserId']."';";
$result = mysql_query($sql);
list($PhoneNumber) = mysql_fetch_row($result);

?>
<input type="hidden" value="<?= $FacebookId ?>" name="user_ids" /><br />
<?PHP
echo "<strong>Textbook</strong>: "; 
//echo $textbook['Title'].(($textbook['Edition']>1)?" (Edition ".$textbook['Edition'].")":"");
echo "<a href=\"Info/Textbook.php?tid=".$textbook['TextbookId']."\">"; 
echo $textbook['Title'].(($textbook['Edition']>1)?" (Edition ".$textbook['Edition'].")":""); ?> by <?PHP echo $textbook['Author']; 
?>
</a>
<input type="hidden" name="sid" value="<?PHP echo $SaleId; ?>" />

<br /><br />
<strong>Seller's Name</strong>: 
<?PHP
echo $user['FirstName']." ".$user['LastName'];
//echo "<a href=\"Info/User.php?uid=".$user['UserId']."\" class=\"sellerName\">"; echo $FirstName." ".$LastName; ?></a>

<br /><br />
<?PHP
if ($PhoneNumber != '')
{
?>
<input type="checkbox" id="contact1" name="contact[]" value="PhoneNumber"/> <label for="contact1">Provide the seller my phone number.</label><br />
<?PHP
}
?>
<input type="checkbox" id="contact2" name="contact[]" value="FacebookUsername"/> <label for="contact2">Provide the seller my facebook email address.</label><br />
<input type="checkbox" id="contact3" name="contact[]" value="EmailAddress"/> <label for="contact3">Provide the seller my personal email address.</label><br />

<br />
<strong>Message to seller</strong>:<br />
<textarea id="message" name="message" rows="12" cols="90" wrap="virtual" 
  placeholder="I would love to purchase this textbook! I'm available to meet you tomorrow and pay $<?PHP echo $sale['StartingBid']; ?> cash. Please contact me back!"></textarea>
<br />
<?php
//if (isset($_SESSION['UserId']))
//{
//echo "<input type=\"submit\" src=\"Images/IWantThis.png\" alt=\"I Want This\" width=\"90\" height=\"40\"onClick=\"window.open('Scripts/emailSeller.php?sid=" . $SaleId . "', 'WindowC', 'width=931, height=564,scrollbars=yes'); return false;\">";
//}
?>
<!-- <input align="right" type="submit" name="formSubmit" value="Send Message" /> -->
<input type="button" value="Submit" onclick="sendRequestToRecipients();">

<input type="reset" value="Cancel" />
</form>
</div>

			<script>
      FB.init({
        appId  : '491456304233582',
        frictionlessRequests: true
      });

      function sendRequestToRecipients() {
        var user_ids = document.getElementsByName("user_ids")[0].value;
        FB.ui({method: 'apprequests',
          message: 'would like to buy your book!',
          to: user_ids
        }, requestCallback);
      }
			
      function requestCallback(response) {
        // Handle callback here
      myform.submit();
			}
			
			function submitForm() {
			sendRequestToRecipients();      
			}
    </script>


<?PHP
}
else
{
echo "You should go login.";
?>
<br />
<em>
  <a href="User/Login.php">Click here to login</a>
  or <a href="User/SignUp.php">Click here to register!</a>
</em>
<?PHP
}
?>
</div>



<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>