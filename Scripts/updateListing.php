<?php
session_start(); 
require_once '../Scripts/db.php';
require_once '../Scripts/common.php';
//updateListing.php

if (validateInput())
{
  // Update the Sale Status
  $query = ("Update Sale 
  SET Status = 1, SoldDate = NOW()
  WHERE SellerId='".mysql_real_escape_string(strip_tags($_SESSION['UserId']))."' 
  AND SaleId ='".mysql_real_escape_string(strip_tags($_POST['SaleId']))."';");
  $result = mysql_query($query)
      or die(mysql_error());
}
else
{
  echo "Error: Input did not correctly validate.";
  return False;
}

///////////////////// main ends functions begin ///////////////////////

function validateInput()
{

	if (!is_numeric($_POST['SaleId']) || $_POST['SaleId'] < 1)
	{
	  echo "Not a valid Sale Id.";
	  return false;
	}
  return True;
  
}

?>
