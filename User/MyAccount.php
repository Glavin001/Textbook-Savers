<?php 
session_start(); 
require_once '../Scripts/db.php';
require_once '../Scripts/common.php';
require_once '../Styles/theme.php';

if (!isset($_SESSION['UserId'])) header("Location: Login.php");

?>

<!DOCTYPE html>
<html>

<style>
a.accountlinks{
border-bottom: 1px dotted;
border-bottom-color: <?PHP echo $linkUnderlineColour; ?>;
}
a.accountlinks:hover {
border-bottom: 1px solid;
border-bottom-color: <?PHP echo $linkUnderlineColour; ?>;
}
</style>


<head>
<title>My Account<?PHP 
              //echo $_SESSION['UserId'];  
              echo $_SESSION['FirstName']. 
              (isset($_SESSION['MiddleName'])?" ".$_SESSION['MiddleName']." ":""). 
              $_SESSION['LastName']; 
              ?></title>

<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
?>
<link rel="stylesheet" type="text/css" href="Styles/profile.php">

<script src="Scripts/search.js"></script>

<script>

function updateSalePrice(SaleId, originalPrice) { 
  var updateWindow = '<div id="updateWindow">';
  updateWindow += '<label for="newPrice">New Price: $</label>';
  updateWindow += '<input type="text" id="newPrice" value="'+originalPrice+'" />';  
  updateWindow += '<input type="submit" id="updateButton" value="Update Sale" style="width: 100%;" />';
  updateWindow += '<p id="errorMessage"></p>';  
  updateWindow += '</div>';
  inWindowPopup("Update Sale", updateWindow );
  $("input#updateButton").click(function() 
  {  
  var newPrice = $("input#newPrice").val();
  console.log("Updating Sale: "+SaleId+", price="+newPrice);
    $.ajax({ 
    type: "POST", 
      url: "Scripts/updateSale.php", 
      data: { SaleId: SaleId, newPrice: newPrice }, 
      dataType: "text" 
    }).done(function( data ) {
    console.log(data);  
      if (data == "")
      {
        $(".closeButton").click();  
        location.reload();
      } 
      else
      {
        $("div#updateWindow p#errorMessage").html(data);
      }
  });
  });
} 

function updateSale(SaleId, originalPrice) { 
  var updateWindow = '<div id="updateWindow">';
  updateWindow += '<label for="newPrice">Sale Price: $</label>';
  updateWindow += '<input type="text" id="newPrice" value="'+originalPrice+'" />';  
  updateWindow += '<input type="submit" id="updateButton" value="Mark As Sold!" style="width: 100%;" />';
  updateWindow += '<p id="errorMessage"></p>';  
  updateWindow += '</div>';
  inWindowPopup("Update Sale", updateWindow );
  $("input#updateButton").click(function() 
  {  
  var newPrice = $("input#newPrice").val();
	var newStatus = 1;
  console.log("Updating Sale: "+SaleId+", price="+newPrice+", status="+newStatus);
    $.ajax({ 
    type: "POST", 
      url: "Scripts/updateSold.php", 
      data: { SaleId: SaleId, newPrice: newPrice, Status: newStatus }, 
      dataType: "text" 
    }).done(function( data ) {
    console.log(data);  
      if (data == "")
      {
        $(".closeButton").click();  
        location.reload();
      } 
      else
      {
        $("div#updateWindow p#errorMessage").html(data);
      }
  });
  });
} 

function updateContactInfo(UserId, EmailAddress, PhoneNumber) { 
  var updateWindow = '<div id="updateWindow">';
  updateWindow += '<label for="newEmail">New Email Address: </label>';
  updateWindow += '<input type="text" id="newEmail" size="50" value="'+EmailAddress+'" />'; 
  updateWindow += '<label for="newPhone"><br />New Phone Number: </label>';
  updateWindow += '<input type="text" id="newPhone" size="50" value="'+PhoneNumber+'" />';    
  updateWindow += '<input type="submit" id="updateInfo" value="Update Contact Info" style="width: 100%;" />';
  updateWindow += '<p id="errorMessage"></p>';  
  updateWindow += '</div>';
  inWindowPopup("Update Contact Info", updateWindow );
	$("input#updateInfo").click(function() 
  {  
  var newEmail = $("input#newEmail").val();
  var newPhone = $("input#newPhone").val();
  console.log("Updating User: "+UserId+", price="+newEmail);
    $.ajax({ 
    type: "POST", 
      url: "Scripts/updateUser.php", 
      data: { UserId: UserId, newEmail: newEmail, newPhone: newPhone}, 
      dataType: "text" 
    }).done(function( data ) {
    console.log(data);  
      if (data == "")
      {
        $(".closeButton").click();  
        location.reload();
      } 
      else
      {
        $("div#updateWindow p#errorMessage").html(data);
      }
  });
  });
} 

function updateWish(WishlistId) { 
  var updateWindow = '<div id="updateWindow">';
  updateWindow += '<label>Are you sure you would like to remove this?</label>'; 
  updateWindow += '<input type="submit" id="updateButton" value="Remove From Wishlist!" style="width: 100%;" />';
  updateWindow += '<p id="errorMessage"></p>';  
  updateWindow += '</div>';
  inWindowPopup("Remove From Wishlist?", updateWindow );
  $("input#updateButton").click(function() 
  {  
	var newStatus = 1;
  console.log("Updating WishlistId: "+WishlistId+", status="+newStatus);
    $.ajax({ 
    type: "POST", 
      url: "Scripts/updateWishlist.php", 
      data: { WishlistId: WishlistId, Status: newStatus }, 
      dataType: "text" 
    }).done(function( data ) {
    console.log(data);  
      if (data == "")
      {
        $(".closeButton").click();  
        location.reload();
      } 
      else
      {
        $("div#updateWindow p#errorMessage").html(data);
      }
  });
  });
} 

function updateListing(SaleId) { 
  var updateWindow = '<div id="updateWindow">';
	updateWindow += '<label>Are you sure you would like to remove this?</label>';
  updateWindow += '<input type="submit" id="updateButton" value="Remove Sale" style="width: 100%;" />';
  updateWindow += '<p id="errorMessage"></p>';  
  updateWindow += '</div>';
  inWindowPopup("Remove Sale", updateWindow );
  $("input#updateButton").click(function() 
  {  
	var newStatus = 1;
  console.log("Updating Sale: "+SaleId+", status="+newStatus);
    $.ajax({ 
    type: "POST", 
      url: "Scripts/updateListing.php", 
      data: { SaleId: SaleId, Status: newStatus }, 
      dataType: "text" 
    }).done(function( data ) {
    console.log(data);  
      if (data == "")
      {
        $(".closeButton").click();  
        location.reload();
      } 
      else
      {
        $("div#updateWindow p#errorMessage").html(data);
      }
  });
  });
}  


</script>

</head>

<body>

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="page">
<?PHP

if (isset($_SESSION['UserId']))
{

/*
echo "_SESSION = ".$_SESSION['UserId']." ";
echo $_SESSION['UserFirstName']. 
(isset($_SESSION['UserMiddleName'])?" ".$_SESSION['UserMiddleName']." ":""). 
$_SESSION['UserLastName']; 
echo "<br />";
*/

$sql = "SELECT UserId, FirstName, MiddleName, LastName, EmailAddress, FacebookUsername, PhoneNumber, Credits FROM User WHERE UserId = '".$_SESSION['UserId']."';";
$result = mysql_query($sql);
if (mysql_num_rows($result) > 0)
{
  list($UserId, $FirstName, $MiddleName, $LastName, $EmailAddress, $FacebookUsername, $PhoneNumber, $Credits) = mysql_fetch_row($result);
  //echo $_SESSION['UserId']; 
  $baseURL = "http://cs.smu.ca/~g_wiechert/TextbookSavers/";
	$relativeURL = "Info/User.php?uid=".$UserId;
  ?>
  <div>
    <h1 class="title username">
    <?PHP 
    if (isset($FacebookUsername) && ($FacebookUsername != NULL || $FacebookUsername != "")) echo "<img src=\"http://graph.facebook.com/".$FacebookUsername."/picture/\" alt=\"User's Facebook profile photo\" />";
    echo $FirstName.(isset($MiddleName)?" ".$MiddleName." ":"").$LastName; 
    ?>
    </h1>
    <a class="accountlinks" href="<?PHP echo $baseURL.$relativeURL; ?>">Click here to see how your profile looks to the public</a>
    <br /> <br />	
    <a class="accountlinks" href="User/Messages.php">Click here to check your messages!</a>
    <br /><br />
    <hr />
		<?PHP 
		if ($FacebookUsername == "")
		{
		?>
		<a href="User/LinkFacebook.php">
		<img alt="Sign up with Facebook" src="http://static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_light_medium_long.gif" />
		</a>
		<?PHP
		}
		?>
		<span class="email"><strong>Email:</strong> <a href="mailto:<?PHP echo $EmailAddress; ?>"><?PHP echo $EmailAddress; ?></a></span>
		<?PHP
		if ($FacebookUsername != "")
		{
		?>
    <br />
    <span class="facebook"><strong>Facebook:</strong> <a href="http://www.facebook.com/<?PHP echo $FacebookUsername; ?>"><?PHP echo $FacebookUsername."@facebook.com"; }?></a></span>
    <br />
    <span class="phone"><strong>Phone-number:</strong> <a href="tel:<?PHP echo $PhoneNumber; ?>"><?PHP echo $PhoneNumber; ?></a></span>
		<br />
    <!-- UPDATE CONTACT INFO -->
		<?PHP
		echo 
				 "<table>".
				 "<td>".
        "<button class=\"changePrice\" onclick=\"updateContactInfo('".$UserId."','".$EmailAddress."','".$PhoneNumber."');\">Change Contact Info</button>".
        "</td>";
      echo "</tr>"."</table>";
			?>		
    <br />
		<span class="credits"><strong>Credits Available:</strong> <?PHP echo $Credits; ?></span>
    <br /> 
		If you want to purchase more credits, click the button below.
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_s-xclick">
    <?php
    echo "<input type=\"hidden\" name=\"custom\" value=\"".$_SESSION['UserId']."\">";
    ?>
    <input type="hidden" name="hosted_button_id" value="ZLG4AFYCJ4ST6">
    <input type="image" src="Images/buynow.png" width="200px" height="100px" name="submit" alt="PayPal - The safer, easier way to pay online!">
    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
  </div>
  
  <br /> <hr /> <br />

	
  <h3>Change Theme</h3>
  <ul class="normalList">
    <li><a class="accountlinks" href="Home.php?theme=default">Minimalist (Default)</a></li>
    <li><a class="accountlinks" href="Home.php?theme=White">White</a></li>
    <li><a class="accountlinks" href="Home.php?theme=FacebookBlue">Facebook-Blue</a></li>
    <li><a class="accountlinks" href="Home.php?theme=Green">Green</a></li>
    <li><a class="accountlinks" href="Home.php?theme=Red">Pink</a></li>
  </ul>
  
  <br /> <hr /> <br />

  <h3 class="title selling">Selling Textbooks</h3>
  <a class="accountlinks" href="User/SellTextbook.php">Sell a textbook</a>  
   <?PHP
  // Selling Textbooks
  $sql = "SELECT SaleId, SellerId, TextbookId, StartingBid, Status FROM Sale WHERE SellerId = '".$UserId."';";
  $saleresult = mysql_query($sql);
  if (mysql_num_rows($saleresult) > 0)
  {
		  echo "<table class=\"selling\">";
      echo "<th>Textbook</th>";
      echo "<th>Course</th>";
      echo "<th>Starting Price</th>";
      echo "<th>Edit</th>";
      while ( list($SaleId, $SellerId, $TextbookId, $StartingBid, $Status) = mysql_fetch_row($saleresult) )
      {      
    /*
      $sql = "SELECT Title, Edition, Author, CourseId, ISBN13 FROM Textbook WHERE TextbookId='".$TextbookId."' LIMIT 0,1;";
      $textbookresult = mysql_query($sql);
      list($TextbookTitle, $Edition, $Author, $CourseId, $ISBN13) = mysql_fetch_row($textbookresult);      
    
      $sql = "SELECT CourseNumber, Title, SubjectId FROM Course WHERE CourseId='".mysql_real_escape_string(strip_tags($CourseId))."' LIMIT 0,1;";
      $courseresult = mysql_query($sql);
      list($CourseNumber, $CourseTitle, $SubjectId) = mysql_fetch_row($courseresult);
   
      $sql = "SELECT Title, ShortTitle FROM Subject WHERE SubjectId='".$SubjectId."' LIMIT 0,1;";
      $subjectResult = mysql_query($sql);
      list($SubjectTitle, $SubjectShortTitle) = mysql_fetch_row($subjectResult);

      echo "<tr>";
      echo "<td>";
      $json_output = getGoogleBookData($ISBN13);
      $imageLinks = $json_output['volumeInfo']['imageLinks'];
      if (isset($imageLinks)) 
        echo "<img alt=\"Textbook thumbnail image\" style=\"float: left;\" src=\"".$imageLinks['smallThumbnail']."\">";
      echo $TextbookTitle.(($Edition>1)?" (Edition $Edition)":"")."</td>";
      echo "<td>$SubjectShortTitle $CourseNumber - $CourseTitle</td>";
      echo "<td>\$$StartingBid</td>";
      echo "<td>$SellingCount</td>"; 
      echo "<td><button>Edit</button></td>";
      echo "</tr>";
      */
			if ($Status < 1)
			{
      $textbook = getTextbook($TextbookId);
      $course = getCourse($textbook['CourseId']);
      $subject = getSubject($course['SubjectId']);

      echo "<tr>";
      echo "<td>";
      echo "<a href=\"Info/Textbook.php?tid=".$textbook['TextbookId']."\" >";
      $json_output = getGoogleBookData($textbook['ISBN13']);
      $imageLinks = $json_output['volumeInfo']['imageLinks'];
      if (isset($imageLinks)) 
        echo "<img alt=\"Textbook thumbnail image\" style=\"float: left;\" src=\"".$imageLinks['smallThumbnail']."\">";
      echo $textbook['Title'].(($textbook['Edition']>1)?" (Edition ".$textbook['Edition'].")":"");
      echo "</a></td>";
      echo "<td>".$subject['ShortTitle']." ".$course['CourseNumber']." - ".$course['Title']."</td>";
      echo "<td>\$".$StartingBid."</td>";
      echo "<td>".
        "<button class=\"changePrice\" onclick=\"updateSalePrice('".$SaleId."','".$StartingBid."');\">Change Price</button>".
        "<button class=\"markSold\" onclick=\"updateSale('".$SaleId."','".$StartingBid."');\">Mark as Sold!</button>".
        "<button class=\"markSold\" onclick=\"updateListing('".$SaleId."');\">Remove</button>";
      echo "</td></tr>";
      }
			}
  } else
  {
    echo "You currently have no sales.";
  }  
  echo "</table>";
  
  ?>
  
  <br /> <hr /> <br /> 

  <h3 class="title wishlist">Wish-List Textbooks</h3>
  <a class="accountlinks" href="User/AddToWishlist.php">Add to my wishlist</a>  

  <?PHP
  // Wish-list Textbooks
  $sql = "SELECT WishlistId, TextbookId, Status FROM Wishlist WHERE UserId = '".$UserId."';";
  $wishlistresult = mysql_query($sql);
  if (mysql_num_rows($wishlistresult) > 0)
  {
    echo "<table class=\"wishlist\">";
    echo "<th>Textbook</th>";
    echo "<th>Course</th>";
    echo "<th>Options</th>";
    while ( list($WishlistId, $TextbookId, $Status) = mysql_fetch_row($wishlistresult) )
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
			if ($Status < 1)
			{
      $textbook = getTextbook($TextbookId);
      $course = getCourse($textbook['CourseId']);
      $subject = getSubject($course['SubjectId']);

      echo "<tr>";
      echo "<td>";
      echo "<a href=\"Info/Textbook.php?tid=".$textbook['TextbookId']."\" >";
      $json_output = getGoogleBookData($textbook['ISBN13']);
      $imageLinks = $json_output['volumeInfo']['imageLinks'];
      if (isset($imageLinks)) 
        echo "<img alt=\"Textbook thumbnail image\" style=\"float: left;\" src=\"".$imageLinks['smallThumbnail']."\">";
      echo $textbook['Title'].(($textbook['Edition']>1)?" (Edition ".$textbook['Edition'].")":"")."</a></td>";
      echo "<td>".$subject['ShortTitle']." ".$course['CourseNumber']." - ".$course['Title']."</td>";
      echo "<td>".
      "<button class=\"removeWish\" onclick=\"updateWish('".$WishlistId."');\">Remove</button>".
      "</td>";
      echo "</tr>";
    }
		}
  } else
  {
    echo "You currently have no textbooks on your wish-list.";
  }  
  echo "</table>";
 
} else
{
  echo "No User found.";
}

}
else
{
?>
<p>Please login.</p>
<br />
<em>
  <a href="User/Login.php">Click here to login</a>
  or <a href="User/SignUp.php">Click here to register!</a>
</em>
<?PHP
}
?>


</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>

