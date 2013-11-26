<?php 
session_start(); 
require '../Scripts/common.php';
require_once '../Styles/theme.php';
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
<title>Sell Textbook</title>

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
<h1>Sell Textbook</h1>

<?PHP
// Check if signed in already
if (isset($_SESSION['UserId']))
{
// If signed in display the full Sell Textbook page

// Check if already selling this textbook
if (isset($_GET['tid'])) 
{
  $sql = "SELECT `SaleId`, `SellerId`, `TextbookId`, `StartingBid`, `Condition` FROM Sale WHERE SellerId=\"".($_SESSION['UserId'])."\" AND TextbookId = \"".($_GET['tid'])."\" LIMIT 0,1;";
  $salesResult = mysql_query($sql);
  if (mysql_num_rows($salesResult) > 0)
  {
    //while ( list($SaleId, $SellerId, $TextbookId, $StartingBid, $Condition, $SellingCount, $SoldCount) = mysql_fetch_row($salesResult)
    echo "<p><strong>You are already selling this textbook.</strong></p>";
    echo "<br /><hr /><br />";
  }
  else
  {
  
  }
}
?>
<form action="User/CompleteSellTextbook.php" method="post">

<h3>Sell Textbook!</h3> <br />

<!-- <span>User: <?PHP echo $_SESSION['UserId']; ?></span> <br /> -->

<!--
<span>Course: <select name="course" id="course" >
<?PHP 
$sql = "SELECT CourseId, CourseNumber, Title, SubjectId FROM Course ORDER BY SubjectId ASC, CourseNumber ASC;";
$result = mysql_query($sql);
while ( list($CourseId, $CourseNumber, $CourseTitle, $SubjectId) = mysql_fetch_row($result) )
{
  $sql = "SELECT Title, ShortTitle FROM Subject WHERE SubjectId = '".$SubjectId."' LIMIT 0,1;";
  $CourseResult = mysql_query($sql);
  list($SubjectTitle, $ShortTitle) = mysql_fetch_row($CourseResult);
  echo "<option value=\"".($CourseId)."\">".($ShortTitle)." ".($CourseNumber)." - ".($CourseTitle)."</option>";
}        
?></select>
<a href="User/CreateCourse.php" target="_blank">Add a new course</a>
</span>
<br />
-->

<label for="textbookfilter">Textbook:</label>
<input type="text" id="textbookfilter" placeholder="Filter textbook selection here" />
<select id="textbook" name="textbook">
<option value="0">Type the Textbook's name in the box.</option>
<?PHP 
if (isset($_GET['tid']))
{
  $tid = $_GET['tid'];
  $textbook = getTextbook($tid);
  echo "<option selected=\"selected\" value=\"".($textbook['TextbookId'])."\">".($textbook['Title'])." by ".$textbook['Author']."</option>";
}   
?>
</select>
<a class="accountlinks" href="User/CreateTextbook.php" target="_blank">Add a new textbook</a>
<br />
<label for="StartingBid">Asking Price:</label> $<input type="text" value="1.00" placeholder="1.00" id="StartingBid" name="StartingBid" ></input>
<br />
<!-- <span>Number of Textbooks Selling: <input type="text" value="1" placeholder="1" id="SellingCount" name="SellingCount" ></input></span>
<br /> -->
<label for="Condition">Condition:</label><br />
<textarea placeholder="Does your textbook have highlights? Any writing or markup?" id="Condition" name="Condition"></textarea>
<br />

<input type="submit" value="Create a Textbook Sale!" />
<input type="reset" value="Reset Form" />
</form>


<script type="text/javascript">
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
</script>
    	  


<?PHP
}
else
{
?>
<strong>To sell a textbook, you must first login.</strong>
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

