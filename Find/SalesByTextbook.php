<?php session_start(); ?>

<!DOCTYPE html>
<html>

<head>
<title>Textbook</title>

<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
?>

<link rel="stylesheet" type="text/css" href="Styles/catalog.php">

<?PHP require '../Scripts/db.php'; ?>
<script src="Scripts/search.js"></script>

</head>

<body>

<!--
<div id="window" style="position:absolute; z-index:10; top: 50%; left: 50%; margin-left: -200px; width:400px; background-color:#dde3eb; border:1px solid #464f5a; ">
Floating "I Want This" box. Possibly future feature.
</div>
-->

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="page">

<div class="searchBox">
<form> 
<div class="searchInput"><input class="searchInput" type="text" placeholder="Search for a Sale, Textbook, Course, or more!" onkeyup="showSuggestion(this.value)"></div>
</form>
<div class="suggestionResults">
<!-- <p><strong>Suggestions:</strong><br /> -->
<ul class="normalList"><span id="suggestionResults">
<!-- <li>Type your search in the box above.</li> -->
</span></ul>
</p>
</div>

</div>

</div>

<hr />

<?PHP 
$TextbookId = $_GET['tid'];

$sql = "SELECT Title, Edition, Author, CourseId FROM Textbook WHERE TextbookId = '".$TextbookId."' LIMIT 0,1;";
$result = mysql_query($sql);
list($TextbookTitle, $Edition, $Author, $CourseId) = mysql_fetch_row($result);

$sql = "SELECT CourseNumber, Title, SubjectId FROM Course WHERE CourseId = '".$CourseId."' LIMIT 0,1;";
$CourseResult = mysql_query($sql);
list($CourseNumber, $CourseTitle, $SubjectId) = mysql_fetch_row($CourseResult);

$sql = "SELECT Title, ShortTitle FROM Subject WHERE SubjectId = '".$SubjectId."' LIMIT 0,1;";
$subjectResult = mysql_query($sql);
list($SubjectTitle, $ShortSubjectTitle) = mysql_fetch_row($subjectResult);

echo $TextbookTitle.(($Edition>1)?" (Edition $Edition)":"")." by ". $Author ."<br />".
      $ShortSubjectTitle." ".$CourseNumber." - ".$CourseTitle. "<br />"."<br />".
      $Description;


include("../Scripts/salesCatalog.php"); 

?>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>

