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
<title>Add a new Textbook</title>

<!-- <link rel="stylesheet" type="text/css" href="Styles/home.php"> -->

<?PHP require '../Scripts/db.php'; ?>
<script src="Scripts/search.js"></script>
<script src="Scripts/livevalidation_standalone.compressed.js"></script>

<script type="text/javascript" src="http://isbnjs.googlecode.com/svn/trunk/isbn.js"></script>
<script type="text/javascript" src="http://isbnjs.googlecode.com/svn/trunk/isbn-groups.js"></script>
<script>
function displayTextbookInfo(isbn)
{
  $.getJSON("https://www.googleapis.com/books/v1/volumes?",
  {
    q: "isbn:"+isbn
  },
  function(data) {
    /*
    $.each(data.items, function(i,item){
      var thumbnailURL = (item.volumeInfo.imageLinks.thumbnail);
      console.log(thumbnailURL);
      document.getElementById('textbookThumbnail').src = thumbnailURL;
    });
    */
    console.log(data);
    if (data.totalItems > 0)
    {
      var item = data.items[0];
      console.log(item);
      var selfLink = item.selfLink;
      $.getJSON(selfLink,
        { },
        function(textbookData) {
          var textbook = textbookData;
          try { document.getElementById('textbookThumbnail').src = textbook.volumeInfo.imageLinks.thumbnail; } catch (err) { }
          try { document.getElementById('title').value = textbook.volumeInfo.title;  } catch (err) { }
          try { document.getElementById('author').value = (textbook.volumeInfo.authors).join(", ");  } catch (err) { }
          //try { document.getElementById('description').value = textbook.volumeInfo.description;  } catch (err) { }     
      });
   } 
   else
   {
    console.log("No textbook found.");
   }
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

// Check if signed in already
if (isset($_SESSION['UserId']))
{
// If signed in display the full create Textbook page
?>
<form action="User/CompleteCreateTextbook.php" method="post">

<h3>Add a new Textbook!</h3> <br />

<div>
<img alt="Textbook Thumbnail" src="" id="textbookThumbnail" />
</div>

<span>First enter the textbook's ISBN number</span><br />
<span><label for="isbn">ISBN</label>
<a href="#" onClick="window.open('Images/Barcode.gif', 'WindowC', 'width=510, height=392,scrollbars=yes');return false;">
    <img src="Images/Question.jpg" alt=""></a>
<input id="isbn" type="text" value="" placeholder="9784873113685" /></span>
<br />
<img alt="What is ISBN?" src="http://monograph.in/wp-content/themes/boldy/images/isbn_over.gif" height="150px" width="182px" />
<br />

<span><label for="title">Title:</label>
<input type="text" id="title" name="title" placeholder="Enter textbook title here."></input></span><br />

<span><label for="author">Author:</label>
<input type="text" id="author" name="author" placeholder="Enter textbook author here."></input></span><br />

<!-- <span><label for="ISBN10">Textbook ISBN10:</label>			
<a href="#" onClick="window.open('Images/Barcode.gif', 'WindowC', 'width=510, height=392,scrollbars=yes');return false;">
    <img src="Images/Question.jpg" alt=""></a> -->
<input type="hidden" id="ISBN10" name="ISBN10" size="10" placeholder="ISBN-10 number"></input></span>
<!-- <span><label for="ISBN13">Textbook ISBN13:</label>
<a href="#" onClick="window.open('Images/Barcode.gif', 'WindowC', 'width=510, height=392,scrollbars=yes');return false;">
			<img src="Images/Question.jpg" alt=""></a> -->
<input type="hidden" id="ISBN13" name="ISBN13" size="13" placeholder="ISBN-13 number"></input></span>

<!--
<span><label for="description">Description:</label><br />
<textarea id="description" name="description" placeholder="Enter textbook description here."></textarea></span><br />
-->

<span><label for="edition">Edition:</label>
<input type="text" id="edition" name="edition" value="" placeholder="1"></input></span><br />

<label for="coursefilter">Course:</label>
<input type="text" id="coursefilter" placeholder="Filter course selection here" />
<select name="course" id="course" >
<option value="0">Type the course's name in the filter box.</option>
<!--
<?PHP 
$sql = "SELECT CourseId, CourseNumber, Title, SubjectId FROM Course ORDER BY SubjectId, CourseNumber ASC;";
$result = mysql_query($sql);
while ( list($CourseId, $CourseNumber, $CourseTitle, $SubjectId) = mysql_fetch_row($result) )
{
  $sql = "SELECT SubjectId, Title, ShortTitle FROM Subject WHERE SubjectId = '".$SubjectId."' LIMIT 0,1;";
  $subjectResult = mysql_query($sql);
  list($SubjectId, $SubjectTitle, $SubjectShortTitle) = mysql_fetch_row($subjectResult);            
  echo "<option value=\"".($CourseId)."\">".($SubjectShortTitle)." ".$CourseNumber." - ".($CourseTitle)."</option>";
}            
?>
-->
</select>
<a class="accountlinks" href="User/CreateCourse.php" target="_blank">Add a new course!</a>
</span>
<br />

<input type="submit" value="Add this new textbook!" />
<input type="reset" value="Reset Form" />

</form>

<script type="text/javascript">
  var field1 = new LiveValidation('title', { validMessage: "Thank you.", failureMessage: "Please enter the new textbook's title." });
  field1.add( Validate.Presence );
  field1.add( Validate.Length, { minimum: 2 , maximum: 255 } );
  
  var field2 = new LiveValidation('author', {validMessage: "Thank you.", failureMessage: "Please enter the author of the textbook." });
  field2.add( Validate.Presence );
  field2.add( Validate.Length, { minimum: 2 , maximum: 255 } );
  //field2.add( Validate.Exclusion, { within: [ ' ' ], partialMatch: true, failureMessage: "No spaces!" } );
  
  /*
  var field3 = new LiveValidation('description', {validMessage: "Thank you.", failureMessage: "Please enter a description of the textbook." });
  field3.add( Validate.Presence );
  field3.add( Validate.Length, { minimum: 4 , maximum: 4294967295 } );
  */
  
  /*
  var field4 = new LiveValidation('ISBN10', {validMessage: "Thank you.", failureMessage: "Please enter the ISBN-10 for the textbook." });
  field4.add( Validate.Presence );
  field4.add( Validate.Exclusion, { within: [ ' ' ], partialMatch: true, failureMessage: "No spaces!" } );
  field4.add( Validate.Exclusion, { within: [ '-' ], partialMatch: true, failureMessage: "No need for -dashes-." } );
  //field4.add( Validate.Numericality, { onlyInteger: true } );
  field4.add( Validate.Length, { is: 10 } );
  <?php
  $sql = "SELECT ISBN10 FROM Textbook;";
  $result = mysql_query($sql);
  $rows = array();
  while ( list($column) = mysql_fetch_row($result) )
  {
  $rows[] = $column;
  }
  ?>
  var usedISBN10 = <?php echo json_encode($rows); ?>;
  field4.add( Validate.Exclusion, { within: usedISBN10 , caseInsensitive: true , partialMatch: false, failureMessage: "Already in use!" } );
  function isValidISBN10(isbn) { 
  isbn = isbn.replace(/[^\dX]/gi, ''); 
  if(isbn.length != 10){ 
    return false; 
  } 
  var chars = isbn.split(''); 
  if(chars[9].toUpperCase() == 'X'){ 
    chars[9] = 10; 
  } 
  var sum = 0; 
  for (var i = 0; i < chars.length; i++) { 
    sum += ((10-i) * parseInt(chars[i])); 
  }; 
  return ((sum % 11) == 0); 
  } 
  field4.add( Validate.Custom, { against: function(value,args){ return isValidISBN10(value); }, args: { } } );
  
  var field5 = new LiveValidation('ISBN13', {validMessage: "Thank you.", failureMessage: "Please enter the ISBN-13 for the textbook." });
  field5.add( Validate.Presence );
  field5.add( Validate.Exclusion, { within: [ ' ' ], partialMatch: true, failureMessage: "No spaces." } );
  field5.add( Validate.Exclusion, { within: [ '-' ], partialMatch: true, failureMessage: "No need for -dashes-." } );
  //field5.add( Validate.Numericality, { onlyInteger: true } );
  field5.add( Validate.Length, { is: 13 } );
  <?php
  $sql = "SELECT ISBN13 FROM Textbook;";
  $result = mysql_query($sql);
  $rows = array();
  while ( list($column) = mysql_fetch_row($result) )
  {
  $rows[] = $column;
  }
  ?>
  var usedISBN13 = <?php echo json_encode($rows); ?>;
  field5.add( Validate.Exclusion, { within: usedISBN13 , caseInsensitive: true , partialMatch: false, failureMessage: "Already in use!" } );
  */
  
  var field4 = new LiveValidation('isbn', {validMessage: "Thank you.", failureMessage: "Please enter the ISBN for the textbook." });
  field4.add( Validate.Presence );
  field4.add( Validate.Custom, { against: function(value,args){ var isbn = ISBN.parse(value); if (isbn) { document.getElementById("ISBN10").value = isbn.asIsbn10(); document.getElementById("ISBN13").value = isbn.asIsbn13(); return true; } else { return false; } }, args: { } } );
  field4.add( Validate.Custom, { against: function(value,args){ displayTextbookInfo(value); return true; }, args: { } } );
    
  var field6 = new LiveValidation('edition', {validMessage: "Thank you.", failureMessage: "Please enter the edition for the textbook." });
  field6.add( Validate.Exclusion, { within: [ ' ' ], partialMatch: true, failureMessage: "No spaces." } );
  field6.add( Validate.Numericality, { onlyInteger: true } );
  
  field1.form.onsubmit = function() {
    var valid = LiveValidation.massValidate([field1, field2, field4, field5 , field6 ]);
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

