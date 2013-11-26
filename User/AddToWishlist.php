<?php 
session_start(); 
?>

<!DOCTYPE html>
<html>

<head>
<title>Add To Wishlist</title>

<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
?>

<!-- <link rel="stylesheet" type="text/css" href="Styles/home.php"> -->

<?PHP 
require '../Scripts/db.php'; 
?>

<script src="Scripts/search.js"></script>
<script src="Scripts/livevalidation_standalone.compressed.js"></script>

</head>

<body>

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>


<div class="page">

<?PHP
// Check if signed in already
if (isset($_SESSION['UserId']))
{
// If signed in display the full Sell Textbook page
?>
<form action="User/CompleteAddToWishlist.php" method="post">

<h3>Add Textbook to Your Wish-list!</h3> <br />
<div id="images">
 
</div>
<label for="textbookfilter">Textbook:</label>
<input type="text" id="textbookfilter" placeholder="Filter textbook selection here" />
<select id="textbook" name="textbook">
<option value="0">Type the Textbook's name in the box.</option>
<!--
<?PHP 
$sql = "SELECT TextbookId, Title, Edition, Author, CourseId FROM Textbook ORDER BY Title;";
$result = mysql_query($sql);
while ( list($TextbookId, $TextbookTitle, $Edition, $Author, $CourseId) = mysql_fetch_row($result) )
{
  echo "<option value=\"".($TextbookId)."\">".($TextbookTitle)." by ".$Author."</option>";
}            
?>
-->
</select>
<a href="User/CreateTextbook.php" target="_blank">Add a new textbook</a>
<br />
<input type="submit" value="Add this textbook to my Wishlist!" />
</form>


<script type="text/javascript">
  /*
  var StartingBid = new LiveValidation('StartingBid', { validMessage: "Thank you.", failureMessage: "Please enter your desired minimum price." });
  StartingBid.add( Validate.Presence );
  StartingBid.add( Validate.Numericality , { minimum: 0.01 });
  StartingBid.add( Validate.Exclusion, { within: [ ' ' ], partialMatch: true, failureMessage: "No spaces!" } );
  
  var SellingCount = new LiveValidation('SellingCount', {validMessage: "Thank you.", failureMessage: "Please enter your desired minimum price." });
  SellingCount.add( Validate.Presence );
  SellingCount.add( Validate.Numericality , { minimum: 1 });
  SellingCount.add( Validate.Exclusion, { within: [ ' ' ], partialMatch: true, failureMessage: "No spaces!" } );
  
  var Condition = new LiveValidation('Condition', {validMessage: "Thank you.", failureMessage: "Please enter your desired minimum price." });
  Condition.add( Validate.Presence );
  Condition.add( Validate.Length, { minimum: 4 } );
  
  var textbookSelect = new LiveValidation('textbook', { validMessage: "Thank you.", failureMessage: "You must select a Textbook!" } );
  textbookSelect.add( Validate.Presence );
  textbookSelect.add(Validate.Exclusion, { within: ['Type the Textbook\'s name in the box.'] });
  textbookSelect.add(Validate.Exclusion, { within: [ 'No textbooks found matching' ], allowNull: true, partialMatch: true, caseSensitive: false } );
  
  StartingBid.form.onsubmit = function() {
    var valid = LiveValidation.massValidate([StartingBid, SellingCount, Condition, textbookSelect]);
    // if (valid) alert('The form is valid!');
    return valid;
  } 
  */ 
</script>
    	  
<?PHP
}
else
{
echo "You should go login.";
?>
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

