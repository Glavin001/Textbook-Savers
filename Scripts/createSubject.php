<?php
//createTextbook.php

if (validateInput() == True)
{
  
      $query = "INSERT INTO Subject (
          `SubjectId`, `Title`, `ShortTitle`
      )
      VALUES (
          NULL, '".mysql_real_escape_string(strip_tags($_POST['title']))."', '".
          mysql_real_escape_string(strip_tags($_POST['shortTitle']))."');";
      $createTextbook = mysql_query($query)
          or die(mysql_error());
      echo "<h3>Thank you for adding to our database of subjects!</h3>";
      // echo "<h3>A confirmation email has been sent.</h3>";
}
else
{
  // Not valid input
  //header("Location: " . $_SERVER['HTTP_REFERER']);
  echo "<h3>Please try again to add a new subject and closely follow the requirements.</h3>"; 
}

///////////////////// main ends functions begin ///////////////////////

function validateInput()
{
  
  if ( (strlen($_POST['title']) < 2 ) )
  {
    return False;
  }
  if ( (strlen($_POST['shortTitle']) < 4 ) && (strpos($_POST['shortTitle'],' ') !==false) )
  {
    return False;
  }
  
  return True;
  
}

?>
