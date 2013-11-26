<?php
//createTextbook.php

if (validateInput() == True)
{
  
      $query = "INSERT INTO Textbook (
          `TextbookId`, `ISBN10`, `ISBN13`,
          `Title`, `Edition`,
          `Author`, `CourseId`
      )
      VALUES (
          NULL, '".mysql_real_escape_string(strip_tags($_POST['ISBN10']))."', '".
          mysql_real_escape_string(strip_tags($_POST['ISBN13']))."', '". 
          mysql_real_escape_string(strip_tags($_POST['title']))."', '".
          mysql_real_escape_string(strip_tags($_POST['edition']))."', '".
          mysql_real_escape_string(strip_tags($_POST['author']))."', '".
          mysql_real_escape_string(strip_tags($_POST['course']))."');";
      $createTextbook = mysql_query($query)
          or die(mysql_error());
      echo "<h3>Thank you for adding to our database of textbooks!</h3>";
      // echo "<h3>A confirmation email has been sent.</h3>";
      
      
      //*** AUTOMATION STEP: PROCESS THIS TEXTBOOK AGAINST WISH-LIST OF OTHER USERS ***
      
}
else
{
  // Not valid input
  //header("Location: " . $_SERVER['HTTP_REFERER']);
  echo "<h3>Please try again to add a new textbook and closely follow the requirements.</h3>"; 
}

///////////////////// main ends functions begin ///////////////////////

function validateInput()
{
  
  if ( (strlen($_POST['firstName']) < 2 ) && (strpos($_POST['firstName'],' ') !==false) )
  {
    echo "First Name is not formatted properly.<br />";
    return False;
  }
  if ( (strlen($_POST['lastName']) < 2 ) && (strpos($_POST['lastName'],' ') !==false) )
  {
    echo "Last Name is not formatted properly.<br />";
    return False;
  }
  if ( ($_POST['ISBN10'] == "") || (!is_isbn_10_valid($_POST['ISBN10'])) )
  {
    echo "ISBN-10 is not formatted properly.<br />";
    return False;
  }
  if ($_POST['ISBN13'] == "" || (!is_isbn_13_valid($_POST['ISBN13'])) )
  {
    echo "ISBN-13 is not formatted properly.<br />";
    return False;
  }
  /*
  if ($_POST['description'] == "")
  {
    echo "Description is not formatted properly.<br />";
    return False;
  }
  */
	if ($_POST['course'] < 1)
	{
	  return false;
	}  
  
  return True;
  
}

function is_isbn_13_valid($n){
    $check = 0;
    for ($i = 0; $i < 13; $i+=2) $check += substr($n, $i, 1);
    for ($i = 1; $i < 12; $i+=2) $check += 3 * substr($n, $i, 1);
    return $check % 10 == 0;
}

function is_isbn_10_valid($ISBN10){
        if(strlen($ISBN10) != 10)
                return false;
 
        $a = 0;
        for($i = 0; $i < 10; $i++){
                if ($ISBN10[$i] == "X"){
                   $a += 10*intval(10-$i);
                } else {//running the loop
 $a += intval($ISBN10[$i]) * intval(10-$i); }
        }
        return ($a % 11 == 0);
}


?>
