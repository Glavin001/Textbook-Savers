<?PHP
require 'db.php';

$listType = $_GET['listType'];

$searchQuery = $_GET['query'];
$allColumns = array("Title","ShortTitle");
$terms = explode(' ', $searchQuery);
$bits = array();
foreach ($terms as $term) {
  $pieces = array();
  foreach ($allColumns as $column) {
      $pieces[] = ($column)." LIKE '%".mysql_real_escape_string(strip_tags($term))."%'";
  }
  $bits[] = "(".implode(' OR ', $pieces).")";
}
$sql = "SELECT SubjectId, Title, ShortTitle FROM Subject WHERE (".implode(' AND ', $bits).") ORDER BY Title;";
$result = mysql_query($sql);
echo "<ul class=\"normalList\">";
if (mysql_num_rows($result) > 0)
{
  while ( list($SubjectId, $FullTitle, $ShortTitle) = mysql_fetch_row($result) )
  {      
    if ($listType == "select")
    {
      echo "<option value=\"$SubjectId\">".$ShortTitle." - ".$FullTitle."</option>";    
    }
    else
    {
      echo "<li><a href=\"User/BuyTextbook.php?q=".$FullTitle."\">".$ShortTitle." - ".$FullTitle."</a></li>";
    }
  }
} else
{
  if ($listType == "select")
    {
      echo "<option value=\"0\">No subjects found matching all of <em>$searchQuery</em>.</option>";    
    }
    else
    {
      echo "No subjects found matching all of <em>$searchQuery</em>. ";
      echo "You can add a new subject <a href=\"User/CreateSubject.php\">here</a>. ";
    }
}
echo "</ul>";

?>