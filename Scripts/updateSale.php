<?php
session_start(); 
require_once '../Scripts/db.php';
require_once '../Scripts/common.php';
//updateSale.php

if (validateInput())
{
  // Update the Sale
  $query = ("Update Sale 
  SET StartingBid = '".mysql_real_escape_string(strip_tags($_POST['newPrice']))."' 
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
	if (!is_numeric($_POST['newPrice']))
	{
	  echo "New price is not a number.";
	  return false;
	}
  return True;
  
}

?>
