<?PHP
require 'db.php';

$listType = $_GET['listType'];

/*$sql = "SELECT SUM(StartingBid) 
        FROM Sale;
				WHERE TextbookId = t";
$result = mysql_query($sql);
*/

$searchQuery = $_GET['query'];
$allColumns = array("t.ISBN10","t.ISBN13","t.Title","t.Edition","t.Author", "c.CourseNumber","c.Title","s.ShortTitle", "s.SubjectTitle");
$terms = explode(' ', $searchQuery);
$bits = array();
foreach ($terms as $term) {
  $pieces = array();
  foreach ($allColumns as $column) {
      $pieces[] = ($column)." LIKE '%".mysql_real_escape_string(strip_tags($term))."%'";
  }
  $bits[] = "(".implode(' OR ', $pieces).")";
}
//$sql = "SELECT TextbookId, ISBN10, ISBN13, Title, Author, Edition FROM Textbook WHERE (".implode(' AND ', $bits).") ORDER BY Title;";
$sql = "SELECT t.TextbookId, t.ISBN10, t.ISBN13, t.Title, t.Author, t.Edition 
FROM Textbook t
JOIN ( SELECT a.CourseId, a.CourseNumber, a.Title, a.SubjectId FROM Course a ) c
ON ( t.CourseId=c.CourseId )
JOIN ( SELECT b.SubjectId AS SubjectId, b.ShortTitle AS ShortTitle, b.Title AS SubjectTitle FROM Subject b ) s 
ON ( c.SubjectId = s.SubjectId ) 
WHERE (".implode(' AND ', $bits).") 
ORDER BY Title;";
$result = mysql_query($sql);
echo "<ul class=\"normalList\">";
if (mysql_num_rows($result) > 0)
{
  while ( list($TextbookId, $ISBN10, $ISBN13, $Title, $Author, $Edition) = mysql_fetch_row($result) )
  {      
    if ($listType == "select")
    {
      echo "<option value=\"$TextbookId\">".$Title.(($Edition>1)?" (Edition $Edition)":"")." - ".$Author."</option>";    
    }
    else
    {
      echo "<li><a href=\"Info/Textbook.php?tid=".$TextbookId."\" <strong>".$Title.(($Edition>1)?" (Edition $Edition)":"")." - ".$Author."</strong>".""."</a></li>";
    }
  }
} else
{
  if ($listType == "select")
    {
      echo "<option value=\"-1\">No textbooks found matching all of <em>$searchQuery</em>.</option>";    
    }
    else
    {
      echo "No textbooks found matching all of <em>$searchQuery</em>. ";      
      echo "You can add a new textbook <a href=\"User/CreateTextbook.php\">here</a>. ";
    }
}
echo "</ul>";

?>