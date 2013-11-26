<?PHP

require 'db.php';

$searchQuery = $_GET['query'];

$allColumns = array("a.CourseNumber","a.Title","c.ShortTitle", "c.SubjectTitle");
$terms = explode(' ', $searchQuery);
$bits = array();
foreach ($terms as $term) {
  $pieces = array();
  foreach ($allColumns as $column) {
      $pieces[] = ($column)." LIKE '%".mysql_real_escape_string(strip_tags($term))."%'";
  }
  $bits[] = "(".implode(' OR ', $pieces).")";
}
//$sql = "SELECT CourseId, CourseNumber, Title, SubjectId FROM Course WHERE (".implode(' AND ', $bits).") ORDER BY SubjectId, CourseNumber, Title;";
$sql = "SELECT a.CourseId, a.CourseNumber, a.Title, a.SubjectId, c.ShortTitle FROM Course a
JOIN ( SELECT b.SubjectId AS SubjectId, b.ShortTitle AS ShortTitle, b.Title AS SubjectTitle FROM Subject b ) c 
ON ( a.SubjectId = c.SubjectId ) 
WHERE (".implode(' AND ', $bits).") 
ORDER BY a.SubjectId, a.CourseNumber, a.Title;";
/*
SELECT c.CourseId, c.CourseNumber, c.Title, c.SubjectId, a.ShortTitle
FROM Course c
JOIN
( 
SELECT s.SubjectId AS SubjectId, s.ShortTitle AS ShortTitle FROM Subject s 
) a
ON ( c.SubjectId = a.SubjectId )
WHERE ((c.CourseNumber LIKE '%acct%' OR c.Title LIKE '%acct%' OR a.ShortTitle LIKE '%acct%' ) 
AND (c.CourseNumber LIKE '%2241%' OR c.Title LIKE '%2241%' OR a.ShortTitle LIKE '%2241%' )) 
ORDER BY c.SubjectId, c.CourseNumber, c.Title
*/
//$sql = "SELECT CourseId, CourseNumber, Title, SubjectId FROM Course WHERE Title LIKE '%".($searchQuery)."%';";
$result = mysql_query($sql);
echo "<ul class=\"normalList\">";
if (mysql_num_rows($result) > 0)
{
  while ( list($CourseId, $CourseNumber, $Title, $SubjectId, $ShortTitle) = mysql_fetch_row($result) )
  {      
  /*
    $sql = "SELECT Title, ShortTitle FROM Subject WHERE SubjectId = '".$SubjectId."' LIMIT 0,1;";
    $subjectResult = mysql_query($sql);
    list($SubjectTitle, $ShortTitle) = mysql_fetch_row($subjectResult);
*/
    if ($listType == "select")
    {
      echo "<option value=\"$CourseId\">".$ShortTitle." ".$CourseNumber." - ".$Title."</option>";    
    }
    else
    {
      echo "<li><a href=\"User/BuyTextbook.php?q=".$Title."\">".$ShortTitle." ".$CourseNumber." - ".$Title."</a></li>";
    }  
  }
} else
{
if ($listType == "select")
    {
      echo "<option value=\"-1\">No courses found matching all of <em>$searchQuery</em>.</option>";    
    }
    else
    {
      echo "No courses found matching all of <em>$searchQuery</em>. ";
      echo "You can add a new course <a href=\"User/CreateCourse.php\">here</a>. ";
    }}
echo "</ul>";

?>
