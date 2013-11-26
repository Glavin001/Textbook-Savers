<?php
//createTextbook.php

if (validateInput() == True)
{
  
      $query = "INSERT INTO Course (
          `CourseId`, `CourseNumber`, `Title`,
          `SubjectId` 
          )
      VALUES (
          NULL, '".mysql_real_escape_string(strip_tags($_POST['courseNumber']))."', '".
          mysql_real_escape_string(strip_tags($_POST['title']))."', '".
          mysql_real_escape_string(strip_tags($_POST['subject']))."');";
      $createTextbook = mysql_query($query)
          or die(mysql_error());
      echo "<h3>Thank you for adding to our database of courses!</h3>";
      // echo "<h3>A confirmation email has been sent.</h3>";
}
else
{
  // Not valid input
  //header("Location: " . $_SERVER['HTTP_REFERER']);
  echo "<h3>Please try again to add a new courses and closely follow the requirements.</h3>"; 
}

///////////////////// main ends functions begin ///////////////////////

function validateInput()
{
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
  }
  */
  
  return True;
  
}

?>
