<?php
session_start(); 
require_once '../Scripts/db.php';
require_once '../Scripts/common.php';
//updateWishlist.php

if (validateInput())
{
  // Update the Wishlist
  $query = ("Update Wishlist
  SET Status = 1
  WHERE UserId='".mysql_real_escape_string(strip_tags($_SESSION['UserId']))."' 
  AND WishlistId ='".mysql_real_escape_string(strip_tags($_POST['WishlistId']))."';");
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

	if (!is_numeric($_POST['WishlistId']) || $_POST['WishlistId'] < 1)
	{
	  echo "Not a valid Sale Id.";
	  return false;
	}
  return true;  
}

?>
