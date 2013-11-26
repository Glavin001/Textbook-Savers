<?php 
session_start(); 
require_once '../Styles/theme.php';
require '../Common/base.php'; 
include '../Common/meta.php';
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
<title>Add a new Course</title>


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
<form action="User/CompleteCreateCourse.php" method="post">

<h3>Add a new Course!</h3> <br />

<span><label for="title">Course Title:</label>
<input type="text" id="title" name="title" placeholder="Enter course title here."></input></span><br />

<span><label for="courseNumber">Course Number:</label>
<input type="text" id="courseNumber" name="courseNumber" placeholder="Enter course number here."></input></span><br />

<label for="subjectfilter">Subject:</label>
<input type="text" id="subjectfilter" placeholder="Filter course selection here" />
<select name="subject" id="subject" >
<option value="0">Type the subject's name in the filter box.</option>
<!--
<?PHP
$sql = "SELECT SubjectId, Title, ShortTitle FROM Subject ORDER BY ShortTitle ASC, Title ASC, SubjectId ASC;";
$result = mysql_query($sql);
while ( list($SubjectId, $Title, $ShortTitle) = mysql_fetch_row($result) )
{
  echo "<option value=\"".($SubjectId)."\">".($ShortTitle)." - ".($Title)."</option>";
}            
?>
-->
</select>
<a class="accountlinks" href="User/CreateSubject.php" target="_blank">Add a new subject!</a>
<br />

<input type="submit" value="Add this new course!" />
<input type="reset" value="Reset Form" />

</form>

<script type="text/javascript">
  var field1 = new LiveValidation('title', { validMessage: "Thank you.", failureMessage: "Please enter the new textbook's title." });
  field1.add( Validate.Presence );
  field1.add( Validate.Length, { minimum: 2 , maximum: 4294967295 } );
  <?php
  $sql = "SELECT Title FROM Course;";
  $result = mysql_query($sql);
  $rows = array();
  while ( list($column) = mysql_fetch_row($result) )
  {
  $rows[] = $column;
  }
  ?>
  var usedTitle = <?php echo json_encode($rows); ?>;
  field1.add( Validate.Exclusion, { within: usedTitle , caseInsensitive: true , partialMatch: false, failureMessage: "Already in use!" } );
  
  
  var field2 = new LiveValidation('courseNumber', {validMessage: "Thank you.", failureMessage: "Please enter the author of the textbook." });
  field2.add( Validate.Presence );
  field2.add( Validate.Numericality, { onlyInteger: true } );
  field2.add( Validate.Length, { minimum: 2 , maximum: 10 } );
  field2.add( Validate.Exclusion, { within: [ ' ' ], partialMatch: true, failureMessage: "No spaces!" } );
  
  <?php
  /*
  $sql = "SELECT CourseNumber FROM Course;";
  $result = mysql_query($sql);
  $rows = array();
  while ( list($column) = mysql_fetch_row($result) )
  {
  $rows[] = $column;
  }
  */
  ?>
  //var usedCourseNumbers = <?php echo json_encode($rows); ?>;
  //field2.add( Validate.Exclusion, { within: usedCourseNumbers , caseInsensitive: true , partialMatch: false, failureMessage: "Already in use!" } );
  
  
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

