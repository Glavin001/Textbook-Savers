<?php
//createSale.php
$userCredits = getUserCredits($_SESSION['UserId']);
if (($userCredits > 1) && (validateInput() == True))
{
  
      $query = "INSERT INTO Sale (
          `SaleId`, `SellerId`, `TextbookId`,
          `StartingBid`, `Condition`
      )
      VALUES (
          NULL, '".mysql_real_escape_string(strip_tags($_SESSION['UserId']))."', '".
          mysql_real_escape_string(strip_tags($_POST['textbook']))."', '". 
          mysql_real_escape_string(strip_tags($_POST['StartingBid']))."', '".
          mysql_real_escape_string(strip_tags($_POST['Condition']))."');";
      //echo "<pre>".$query."</pre>";
      $createSale = mysql_query($query)
          or die(mysql_error());
          
      echo "<h3>Thank you for submitting your textbook sale.</h3>";
      // echo "<h3>A confirmation email has been sent.</h3>";
			
			// Record the reduction of credits into the User table
			$query = ("Update User SET Credits = Credits - 1 WHERE UserId='".$UserId."'");
						 $credits = mysql_query($query)
						     or die(mysql_error());
						     
			// Record the reduction of credits into the Credits table
			$purchase = "INSERT INTO Credits (UserId, CreditValue)
					VALUES ($UserId, '-1');";
  					 $creditpurchase = mysql_query($purchase)
						     or die(mysql_error());		
						     
}
else
{
 	if (isset($_SESSION['UserId']) && ($userCredits < 1))
	{
	  echo "<h3>You don't have enough credits to purchase this textbook!</h3>";
	}
	else
	{  
    // Not valid input
    echo "<h3>There was invalid input. Please try again.</h3>";
    echo "<h4>Note: Make sure that you have JavaScript enabled to fully see what is allowed and not allowed as valid input.</h4>";
    echo "<h3>Please go to our <a href=\"User/SignUp.php\">registration page</a> to register your account before purchasing.</h3>"; 
  }
}

///////////////////// main ends functions begin ///////////////////////

function validateInput()
{

	if ($_POST['textbook'] < 1)
	{
	  return false;
	}  
	
  /*
  if ( (strlen($_POST['firstName']) < 2 ) && (strpos($_POST['firstName'],' ') !==false) )
  {
    return False;
  }
  if ( (strlen($_POST['lastName']) < 2 ) && (strpos($_POST['lastName'],' ') !==false) )
  {
    return False;
  }
  if ($_POST['email'] == "")
  {
    return False;
  }
  if ($_POST['phone'] == "")
  {
    return False;
  }
  if ($_POST['Condition'] == "")
  {
    return False;
  } */
  
  return True;
  
}

function getUserCredits($userid) {
  $sql = "SELECT UserId, Credits FROM User WHERE UserId = '".$userid."';";
	$creditresult = mysql_query($sql)
    or die(mysql_error());
		list($UserId, $Credits) = mysql_fetch_row($creditresult);
		return $Credits;
}

?>
