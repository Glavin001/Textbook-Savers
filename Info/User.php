<?php 
session_start(); 
require_once '../Scripts/db.php';
require_once '../Scripts/common.php';

$userid = mysql_real_escape_string($_GET['uid']);

$sql = "SELECT UserId, FirstName, MiddleName, LastName, EmailAddress, PhoneNumber FROM User WHERE UserId = '".$userid."';";
$result = mysql_query($sql);
list($userid, $FirstName, $MiddleName, $LastName, $EmailAddress, $PhoneNumber) = mysql_fetch_row($result);

?>

<!DOCTYPE html>
<html>

<head>
<title>User Account - <?PHP echo $FirstName. 
  (isset($MiddleName)?" ".$MiddleName." ":""). 
  $LastName; ?></title>

<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
?>
<link rel="stylesheet" type="text/css" href="Styles/catalog.php">
<link rel="stylesheet" type="text/css" href="Styles/profile.php">


<?PHP require '../Scripts/db.php'; ?>
<script src="Scripts/search.js"></script>

</head>

<body>

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="page">

<?PHP

// echo "Current Session UserId: ".$_SESSION['UserId'];
$sql = "SELECT UserId, FirstName, MiddleName, LastName, EmailAddress, PhoneNumber, FacebookUsername FROM User WHERE UserId = '".$userid."';";
$result = mysql_query($sql);
if (mysql_num_rows($result) > 0)
{
  list($userid, $FirstName, $MiddleName, $LastName, $EmailAddress, $PhoneNumber, $FacebookUsername) = mysql_fetch_row($result);
  
?>
<!-- <div>
<?PHP
/*
$sql = "SELECT Sale.SaleId, Sale.SellerId, Textbook.Title, Textbook.TextbookId, Textbook.ISBN10, Textbook.ISBN13  FROM `Sale`, `Textbook` WHERE Sale.TextbookId=Textbook.TextbookId AND Sale.SellerId='".mysql_real_escape_string(strip_tags($UserId))."' GROUP BY Textbook.TextbookId;";
$result = mysql_query($sql);
while ( list($SaleId, $SellerId, $TextbookTitle, $TextbookId, $ISBN10, $ISBN13) = mysql_fetch_row($result) )
{
  $json_output = getGoogleBookData($ISBN13);
  $imageLinks = $json_output['volumeInfo']['imageLinks'];
  if (isset($imageLinks)) 
    echo "<img alt=\"Textbook thumbnail image\" width=\"128px\" src=\"".$imageLinks['thumbnail']."\">";
}
$sql = "SELECT Wishlist.WishlistId, Wishlist.UserId, Textbook.TextbookId, Textbook.ISBN10, Textbook.ISBN13 FROM `Wishlist`, `Textbook` WHERE Wishlist.TextbookId=Textbook.TextbookId AND Wishlist.UserId='".mysql_real_escape_string(strip_tags($UserId))."' GROUP BY Textbook.TextbookId;";
$result = mysql_query($sql);
while ( list($WishlistId, $WisherId, $TextbookId, $ISBN10, $ISBN13) = mysql_fetch_row($result) )
{
  $json_output = getGoogleBookData($ISBN13);
  $imageLinks = $json_output['volumeInfo']['imageLinks'];
  if (isset($imageLinks)) 
    echo "<img alt=\"Textbook thumbnail image\" width=\"128px\" src=\"".$imageLinks['thumbnail']."\">";
}
*/
?>
</div> --> 
<br /> 

  <h1 class="title username" style="display: inline;">
  <?PHP 
  if (isset($FacebookUsername) && ($FacebookUsername != NULL || $FacebookUsername != "")) echo "<img src=\"http://graph.facebook.com/".$FacebookUsername."/picture/\" alt=\"User's Facebook profile photo\" />";
  echo $FirstName.(isset($MiddleName)?" ".$MiddleName." ":"").$LastName; 
  ?>
  </h1>
  <?PHP 
	/*
   $baseURL = "http://cs.smu.ca/~g_wiechert/TextbookSavers/";
	$relativeURL = "User/Messages.php?uid=".$userid;
  echo '<a href="'.$baseURL.$relativeURL.'">Click here to Message</a>';
	*/
  ?>
  <br /> <hr /> <br /> 
 <?PHP
  // Selling Textbooks
  echo "<h3 class=\"title selling\">Selling Textbooks</h3>";
  $sql = "SELECT SaleId, SellerId, TextbookId, StartingBid FROM Sale WHERE SellerId = '".$userid."';";
  $saleresult = mysql_query($sql);
  if (mysql_num_rows($saleresult) > 0)
  {
    echo "<table class=\"selling\">";
    echo "<th>Textbook</th>";
    echo "<th>Course</th>";
    echo "<th>Starting Price</th>";
    echo "<th>I Want This</th>";
    while ( list($SaleId, $SellerId, $TextbookId, $StartingBid) = mysql_fetch_row($saleresult) )
    {       
      $textbook = getTextbook($TextbookId);
      $course = getCourse($textbook['CourseId']);
      $subject = getSubject($course['SubjectId']);

      echo "<tr>";
      echo "<td>";
      $json_output = getGoogleBookData($textbook['ISBN13']);
      $imageLinks = $json_output['volumeInfo']['imageLinks'];
      if (isset($imageLinks)) 
        echo "<img alt=\"Textbook thumbnail image\" style=\"float: left;\" src=\"".$imageLinks['smallThumbnail']."\">";
      echo $textbook['Title'].(($textbook['Edition']>1)?" (Edition ".$textbook['Edition'].")":"")."</td>";
      echo "<td>".$subject['ShortTitle']." ".$course['CourseNumber']." - ".$course['Title']."</td>";
      echo "<td>\$".$StartingBid."</td>";
      ?>
      <td><a class="linkButton" href="Find/SalesByTextbook.php?tid=<?PHP echo $TextbookId; ?>"><div>I Want This</div></a></td>
      <?PHP
      //echo "<td><button>I Want This</button></td>";
      echo "</tr>";
      
    }
  } else
  {
  ?>
  <strong>Not currently selling any textbooks.</strong>
  <?PHP
  }   
  echo "</table>";
  
  ?>
  <br /> <hr /> <br /> 
  <?PHP
  // Wish-list Textbooks
  echo "<h3 class=\"title wishlist\">Wish-List Textbooks</h3>";
  $sql = "SELECT WishlistId, TextbookId FROM Wishlist WHERE UserId = '".$userid."';";
  $wishlistresult = mysql_query($sql);
  if (mysql_num_rows($wishlistresult) > 0)
  {
    echo "<table class=\"wishlist\">";
    echo "<th>Textbook</th>";
    echo "<th>Course</th>";
    echo "<th>I Have This</th>";
    while ( list($WishlistId, $TextbookId) = mysql_fetch_row($wishlistresult) )
    {   
      /*   
      $sql = "SELECT Title, Edition, Author, CourseId, ISBN13 FROM Textbook WHERE TextbookId = '".$TextbookId."' LIMIT 0,1;";
      $textbookresult = mysql_query($sql);
      list($TextbookTitle, $Edition, $Author, $CourseId, $ISBN13) = mysql_fetch_row($textbookresult);      
      
      $sql = "SELECT CourseId, CourseNumber, Title, SubjectId FROM Course WHERE CourseId='".mysql_real_escape_string(strip_tags($CourseId))."' LIMIT 0,1;";
      $courseresult = mysql_query($sql);
      list($CourseId, $CourseNumber, $CourseTitle, $SubjectId) = mysql_fetch_row($courseresult);
   
      $sql = "SELECT Title, ShortTitle FROM Subject WHERE SubjectId = '".$SubjectId."' LIMIT 0,1;";
      $subjectResult = mysql_query($sql);
      list($SubjectTitle, $SubjectShortTitle) = mysql_fetch_row($subjectResult);
      */

      $textbook = getTextbook($TextbookId);
      $course = getCourse($textbook['CourseId']);
      $subject = getSubject($course['SubjectId']);

      echo "<tr>";
      echo "<td>";
      $json_output = getGoogleBookData($textbook['ISBN13']);
      $imageLinks = $json_output['volumeInfo']['imageLinks'];
      if (isset($imageLinks)) 
        echo "<img alt=\"Textbook thumbnail image\" style=\"float: left;\" src=\"".$imageLinks['smallThumbnail']."\">";
      echo $textbook['Title'].(($textbook['Edition']>1)?" (Edition ".$textbook['Edition'].")":"")."</td>";
      echo "<td>".$subject['ShortTitle']." ".$course['CourseNumber']." - ".$course['Title']."</td>";
      //echo "<td><button>I Have This</button></td>";
      ?>
      <td><a class="linkButton" href="User/SellTextbook.php?tid=<?PHP echo $textbook['TextbookId']; ?>"><div>I Have This</div></a></td>
      <?PHP
      echo "</tr>";
    }
    echo "</table>";
  } else
  {
  ?>
  <strong>No textbooks currently in Wish-List.</strong>
  <?PHP
  }  
  
  /*
  $sql = "SELECT SaleId, SellerId, TextbookId, StartingBid, SellingCount, SoldCount FROM Sale WHERE SellerId = '".$userid."';";
  $saleresult = mysql_query($sql);
  echo "<ul class=\"normalList\">";
  if (mysql_num_rows($saleresult) > 0)
  {
    while ( list($SaleId, $SellerId, $TextbookId, $StartingBid, $SellingCount, $SoldCount) = mysql_fetch_row($saleresult) )
    {      
      $sql = "SELECT Title, Edition, Author, CourseId FROM Textbook WHERE TextbookId = '".$TextbookId."' LIMIT 0,1;";
      $textbookresult = mysql_query($sql);
      list($TextbookTitle, $Edition, $Author, $CourseId) = mysql_fetch_row($textbookresult);      
      echo "<li>$TextbookTitle starting at \$$StartingBid </li>";
    }
  } else
  {
    echo "<li>No sales found matching $searchQuery.</li>";
  }  
  echo "</ul>";
  */
  
} else
{
  echo "No Users found matching $searchQuery.";
}

?>

</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>

