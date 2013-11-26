<?php
// processAddToWishlist.php

if (validateInput() == True)
{
  $sql = "SELECT * FROM Wishlist WHERE UserId='".mysql_real_escape_string(strip_tags($_SESSION['UserId']))."' AND TextbookId='".mysql_real_escape_string(strip_tags($_POST['textbook']))."';";
  $result = mysql_query($sql);
  $num_rows = mysql_num_rows($result);
  if ($num_rows) {
   //trigger_error('It exists.', E_USER_WARNING);
   echo "<p>You already have this textbook in your wish-list.</p>";
  }
 else
 { 
      $query = "INSERT INTO Wishlist (
          `WishlistId`, `UserId`, `TextbookId`,
          `DateAdded`
      )
      VALUES (
          NULL, '".mysql_real_escape_string(strip_tags($_SESSION['UserId']))."', '".
          mysql_real_escape_string(strip_tags($_POST['textbook']))."', NULL );";
      $result = mysql_query($query)
          or die(mysql_error());
          
      echo "<p>The textbook has been added to your wish-list.</p>";
  }
}
else
{
  // Not valid input
  //header("Location: " . $_SERVER['HTTP_REFERER']);
  //header("Location: "."../User/MyAccount.php");
  echo "<h3>Please try again to add a new textbook and closely follow the requirements.</h3>"; 
}

///////////////////// main ends functions begin ///////////////////////

function validateInput()
{
  
  if ($_POST['textbook'] < 1)
  {
    echo "Please select a textbook.<br />";
    return False;
  }
  
  return True;
  
}

?>
