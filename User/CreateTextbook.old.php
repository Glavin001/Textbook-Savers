<?php 
session_start(); 

?>

<!DOCTYPE html>
<html>

<head>
<title>Sell Textbook</title>

<?PHP 
require_once '../Styles/theme.php';
require '../Common/base.php'; 
include '../Common/meta.php';
?>

<!-- <link rel="stylesheet" type="text/css" href="Styles/home.php"> -->

<?PHP require '../Scripts/db.php'; ?>
<script src="Scripts/search.js"></script>
<script src="Scripts/livevalidation_standalone.compressed.js"></script>

</head>

<body>

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="content">

<?PHP

// Check if signed in already
if (isset($_SESSION['UserId']))
{
// If signed in display the full Sell Textbook page
?>
<form action="User/CompleteSellTextbook.php" method="post">

<h3>Sell Textbook!</h3> <br />

<!-- <span>User: <?PHP echo $_SESSION['UserId']; ?></span> <br /> -->

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
<a href="" target="_blank">Add a new course</a>
</span>
<br />
<span>Textbook:
<select id="textbook" name="textbook">
<?PHP 
$sql = "SELECT TextbookId, Title, Edition, Author, SubjectId FROM Textbook ORDER BY Title;";
$result = mysql_query($sql);
while ( list($TextbookId, $TextbookTitle, $Edition, $Author, $SubjectId) = mysql_fetch_row($result) )
{
  echo "<option value=\"".($TextbookId)."\">".($TextbookTitle)." by ".$Author."</option>";
}            
?></select>
<a href="User/CreateTextbook.php" target="_blank" >Add a new textbook</a>
</span>
<br />
<span>Starting Bid: $<input type="text" value="1.00" placeholder="1.00" id="StartingBid" name="StartingBid" ></input></span>
<br />
<span>Number of Textbooks Selling: <input type="text" value="1" placeholder="1" id="SellingCount" name="SellingCount" ></input></span>
<br />

<div>
Condition:<br />
<span>
<textarea placeholder="Does your textbook have highlights? Any writing or markup?" id="Condition" name="Condition"></textarea>
</span>
</div>

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
  
  
  StartingBid.form.onsubmit = function(){
    var valid = LiveValidation.massValidate([StartingBid, SellingCount, Condition]);
    // if (valid) alert('The form is valid!');
    return valid;
  }
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

