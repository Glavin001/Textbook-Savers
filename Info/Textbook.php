<?php 
session_start(); 
require '../Scripts/db.php';
?>

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
          console.log(textbookData);
          try { document.getElementById('textbookThumbnail').src = textbook.volumeInfo.imageLinks.thumbnail; } catch (err) { }
          try { document.getElementById('textbookTitle').value = textbook.volumeInfo.title;  } catch (err) { }
          try { document.getElementById('textbookAuthor').value = (textbook.volumeInfo.authors).join(", ");  } catch (err) { }
          try { document.getElementById('textbookDescription').innerHTML = (textbook.volumeInfo.description == undefined)?"No textbook description available.":textbook.volumeInfo.description;  } catch (err) { }     
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
<br />
<div class="catalogItem">

<div class="title">
<img id="textbookThumbnail" src="" alt="" />
<?PHP

$TextbookId = $_GET['tid'];

$sql = "SELECT Title, Edition, Author, CourseId, ISBN10, ISBN13 FROM Textbook WHERE TextbookId = '".$TextbookId."' LIMIT 0,1;";
$result = mysql_query($sql);
list($TextbookTitle, $Edition, $Author, $CourseId, $ISBN10, $ISBN13) = mysql_fetch_row($result);

$sql = "SELECT CourseNumber, Title, SubjectId FROM Course WHERE CourseId = '".$CourseId."' LIMIT 0,1;";
$CourseResult = mysql_query($sql);
list($CourseNumber, $CourseTitle, $SubjectId) = mysql_fetch_row($CourseResult);

$sql = "SELECT Title, ShortTitle FROM Subject WHERE SubjectId = '".$SubjectId."' LIMIT 0,1;";
$subjectResult = mysql_query($sql);
list($SubjectTitle, $ShortSubjectTitle) = mysql_fetch_row($subjectResult);
?>
<a class="linkButton" href="Find/SalesByTextbook.php?tid=<?PHP echo $TextbookId; ?>"><div>I Want This</div></a>  
<a class="linkButton" href="User/SellTextbook.php?tid=<?PHP echo $TextbookId; ?>"><div>I Have This</div></a>
<?PHP
echo "<br />".$TextbookTitle.(($Edition>1)?" (Edition $Edition)":"")." by ". $Author ."<br />".
      $ShortSubjectTitle." ".$CourseNumber." - ".$CourseTitle. "<br />"."<br />";
?>
ISBN-13: <?PHP echo $ISBN13; ?>
</div>

<div class="details">
<div class="title">Textbook Description from Google Books:</div>
<pre id="textbookDescription" style="padding:5px;
display: block; width:100%; overflow:auto; 
white-space: pre-wrap; /* css-3 */
white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
white-space: -pre-wrap; /* Opera 4-6 */
white-space: -o-pre-wrap; /* Opera 7 */
word-wrap: break-word; /* Internet Explorer 5.5+ */
"></pre>
</div>

</div>

<script>
displayTextbookInfo("<?PHP echo $ISBN13; ?>");
</script>


</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>

