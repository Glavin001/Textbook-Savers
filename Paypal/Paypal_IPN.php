<?php
session_start(); 
require '../Scripts/db.php';


class Paypal_IPN
{
    /** $var string $_url The paypal url to go to through cURL
		private $_url;

    /**
		* @param string $mode 'live' or 'sandbox
		*/
    
    public function __construct($mode = 'live')
		{
		  if ($mode == 'live')
			$this->_url = 'https://www..paypal.com/cgi-bin/webscr';
		  else
			$this->_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		}
		
    public function run()
		{
		  $postFields = 'cmd=_notify-validate';
			
		  foreach($_POST as $key => $value)
			{
			    $postFields .= "&$key=".urlencode($value);
			}
		
		  $ch = curl_init();
			
			curl_setopt_array($ch, array(
			  CURLOPT_URL => $this->_url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $postFields
			));
			
      $result = curl_exec($ch);
			curl_close($ch);
			
			// Store first name from sale
			$startpos = strpos($postFields, "first_name="); 
			$secondpart = substr($postFields, $startpos+11);
			$endpos = strpos($secondpart,"&");
			$first_name = substr($secondpart, 0, $endpos);
			// Store last name from sale
			$startpos = strpos($postFields, "last_name="); 
			$secondpart = substr($postFields, $startpos+10);
			$endpos = strpos($secondpart,"&");
			$last_name = substr($secondpart, 0, $endpos);
			// Store payer email from sale
			$startpos = strpos($postFields, "payer_email="); 
			$secondpart = substr($postFields, $startpos+12);
			$endpos = strpos($secondpart,"&");
			$payer_email = substr($secondpart, 0, $endpos);
			// Store payment type from sale
			$startpos = strpos($postFields, "payment_type="); 
			$secondpart = substr($postFields, $startpos+13);
			$endpos = strpos($secondpart,"&");
			$payment_type = substr($secondpart, 0, $endpos); 
			// Store payment status from sale
			$startpos = strpos($postFields, "payment_status="); 
			$secondpart = substr($postFields, $startpos+15);
			$endpos = strpos($secondpart,"&");
			$payment_status = substr($secondpart, 0, $endpos); 
			// Store UserId from sale
			$startpos = strpos($postFields, "custom="); 
			$secondpart = substr($postFields, $startpos+7);
			$endpos = strpos($secondpart,"&");
			$custom = substr($secondpart, 0, $endpos);
			// Store quantity ordered from sale
			$startpos = strpos($postFields, "quantity="); 
			$secondpart = substr($postFields, $startpos+9);
			$endpos = strpos($secondpart,"&");
			$quantity = substr($secondpart, 0, $endpos);
			// Store cost charged from sale
			$startpos = strpos($postFields, "mc_gross="); 
			$secondpart = substr($postFields, $startpos+9);
			$endpos = strpos($secondpart,"&");
			$cost = substr($secondpart, 0, $endpos);
			
			// Store the data into the database.
			$query = "INSERT INTO CreditPurchase (UserId, FirstName, LastName, CreditsPurchased, Cost, PayerEmail, PaymentStatus, PaymentType) 
			VALUES ('".mysql_real_escape_string(strip_tags($_POST[custom]))."',
			       '".mysql_real_escape_string(strip_tags($_POST[first_name]))."',
             '".mysql_real_escape_string(strip_tags($_POST[last_name]))."',
						 '".mysql_real_escape_string(strip_tags($_POST[quantity]))."',
						 $cost,
						 '".mysql_real_escape_string(strip_tags($_POST[payer_email]))."',
						 '".mysql_real_escape_string(strip_tags($_POST[payment_status]))."',
						 '".mysql_real_escape_string(strip_tags($_POST[payment_type]))."'
						 );";
						 $sales = mysql_query($query)
						     or die(mysql_error());			
								 
			if ($payment_type == "instant" && $payment_status == "Completed" && $quantity > 0)
			{
			    $query = ("Update User SET Credits = Credits + $_POST[quantity] WHERE UserId='$_POST[custom]'");
						 $credits = mysql_query($query)
						     or die(mysql_error());
								 
					$purchase = "INSERT INTO Credits (UserId, CreditValue)
					VALUES ($_POST[custom], $_POST[quantity]);";
  					 $creditpurchase = mysql_query($purchase)
						     or die(mysql_error());		
			}
		}
}