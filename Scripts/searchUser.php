<?PHP
require 'db.php';

$listType = $_GET['listType'];

$searchQuery = $_GET['query'];
$allColumns = array("u.FirstName", "u.MiddleName", "u.LastName", "u.EmailAddress", "u.PhoneNumber", "u.FacebookUsername", "t.ISBN10","t.ISBN13","t.TextbookTitle","t.Edition","t.Author", "c.CourseNumber","c.CourseTitle","s.ShortTitle", "s.SubjectTitle");
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
$sql = "SELECT 
u.UserId, u.FirstName, u.MiddleName, u.LastName, u.EmailAddress, u.PhoneNumber, u.FacebookUsername
FROM User u 
LEFT JOIN ( SELECT se.SaleId, se.SellerId, se.TextbookId FROM Sale se ) sa
ON ( u.UserId=sa.SellerId)
LEFT JOIN ( SELECT w.WishlistId, w.UserId, w.TextbookId FROM Wishlist w ) wi
ON ( u.UserId=wi.UserId)
LEFT JOIN ( SELECT tb.TextbookId, tb.ISBN10, tb.ISBN13, tb.Title AS TextbookTitle, tb.Author, tb.Edition, tb.CourseId FROM Textbook tb ) t
ON ( sa.TextbookId=t.TextbookId or wi.TextbookId=t.TextbookId )
LEFT JOIN ( SELECT a.CourseId, a.CourseNumber, a.Title AS CourseTitle, a.SubjectId FROM Course a ) c
ON ( t.CourseId=c.CourseId )
LEFT JOIN ( SELECT b.SubjectId AS SubjectId, b.ShortTitle AS ShortTitle, b.Title AS SubjectTitle FROM Subject b ) s 
ON ( c.SubjectId = s.SubjectId ) 
WHERE (".implode(' AND ', $bits).") 
GROUP BY UserId
ORDER BY u.FirstName;";

//echo "<pre>".$sql."</pre>";

$result = mysql_query($sql);
echo "<ul class=\"normalList\">";
if (mysql_num_rows($result) > 0)
{
  while ( list($UserId, $FirstName, $MiddleName, $LastName, $EmailAddress, $PhoneNumber, $FacebookUsername) = mysql_fetch_row($result) )
  {      
    if ($listType == "select")
    {
      echo "<option value=\"$UserId\">".$FirstName." ".$LastName."</option>";    
    }
    else
    {
      echo "<li><a href=\"Info/User.php?uid=".$UserId."\">".$FirstName." ".$LastName."</a></li>";
    }
  }
} else
{
  if ($listType == "select")
    {
      echo "<option value=\"-1\">No users found matching all of <em>$searchQuery</em>.</option>";    
    }
    else
    {
      echo "<li>";
      echo "No users found matching all of <em>$searchQuery</em>. ";      
      echo "You can add a new textbook <a href=\"User/CreateTextbook.php\">here</a>. ";
      echo "</li>";
    }
}
echo "</ul>";

?>