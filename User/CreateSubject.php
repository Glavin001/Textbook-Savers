<?php 
session_start(); 
?>


<!DOCTYPE html>
<html>

</style>

<head>
<title>Add a new Subject</title>

<?PHP 
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

<div class="page">

<?PHP

// Check if signed in already
if (isset($_SESSION['UserId']))
{
// If signed in display the full create Textbook page
?>
<form action="User/CompleteCreateSubject.php" method="post">

<h3>Add a new Subject!</h3> <br />

<!-- <span>User: <?PHP echo $_SESSION['UserId']; ?></span> <br /> -->

<span><label for="title">Subject Full Title:</label>
<input type="text" id="title" name="title" placeholder="Psychology"></input></span><br />

<span><label for="shortTitle">Subject's Short Title:</label>
<input type="text" id="shortTitle" name="shortTitle" placeholder="PSYC"></input></span><br />
<br />
<input type="submit" value="Add this new subject!" />
<input type="reset" value="Reset Form" />

</form>

<script type="text/javascript">
  var field1 = new LiveValidation('title', { validMessage: "Thank you.", failureMessage: "Please enter the new subject's full title." });
  field1.add( Validate.Presence );
  <?php
  $sql = "SELECT Title FROM Subject;";
  $result = mysql_query($sql);
  $rows = array();
  while ( list($column) = mysql_fetch_row($result) )
  {
  $rows[] = $column;
  }
  ?>
  var usedSubjectTitle = <?php echo json_encode($rows); ?>;
  field1.add( Validate.Exclusion, { within: usedSubjectTitle , caseInsensitive: true , partialMatch: false, failureMessage: "Already in use!" } );
  
  var field2 = new LiveValidation('shortTitle', {validMessage: "Thank you.", failureMessage: "Please enter the subject's short title." });
  field2.add( Validate.Presence );
  field2.add( Validate.Length, { minimum: 4 } );
  field2.add( Validate.Exclusion, { within: [ ' ' ], partialMatch: true, failureMessage: "No spaces!" } );
  <?php
  $sql = "SELECT ShortTitle FROM Subject;";
  $result = mysql_query($sql);
  $rows = array();
  while ( list($column) = mysql_fetch_row($result) )
  {
  $rows[] = $column;
  }
  ?>
  var usedShortTitle = <?php echo json_encode($rows); ?>;
  field2.add( Validate.Exclusion, { within: usedShortTitle , caseInsensitive: true , partialMatch: false, failureMessage: "Already in use!" } );
  
  
  field1.form.onsubmit = function() {
    var valid = LiveValidation.massValidate([field1, field2]);
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

