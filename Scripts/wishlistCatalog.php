<?PHP
// Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$updateIdentifier = "";

?>

<div class="wishlistCatalog">

<h3 class="catalogTitle">Most Wanted</h3>

<?PHP
require_once 'common.php';
require_once 'db.php';

$sql = "SELECT TextbookId, count(WishlistId) as popularity FROM Wishlist GROUP BY TextbookId ORDER BY popularity DESC LIMIT 0,10;";
$wishresult = mysql_query($sql);
while ( list($TextbookId, $popularity) = mysql_fetch_row($wishresult) )
{

  $updateIdentifier .= $TextbookId.",";

  $sql = "SELECT Title, Edition, Author, CourseId FROM Textbook WHERE TextbookId = '".$TextbookId."' LIMIT 0,1;";
  $result = mysql_query($sql);
  list($TextbookTitle, $Edition, $Author, $CourseId) = mysql_fetch_row($result);
  
  $sql = "SELECT FirstName, LastName, EmailAddress FROM User WHERE UserId = '".$SellerId."' LIMIT 0,1;";
  $result = mysql_query($sql);
  list($FirstName, $LastName, $EmailAddress) = mysql_fetch_row($result);
  
  $CurrentBid = $StartingBid;
  
  ?>
  <div class="catalogItem">
    <div class="title">
		  <h4><span class="title"><?php echo "<a href=\"Info/Textbook.php?tid=$TextbookId\">"; echo $TextbookTitle.(($Edition>1)?" (Edition $Edition)":""); ?> by <?PHP echo $Author; echo " (".$popularity." user".(($popularity>1)?"s":"")." wants this)"; ?></a></span>
      <!-- <span class="bid"><?PHP echo "<a href=\"User/SellTextbook.php?tid=$TextbookId\">I have this textbook!</a>";?></span> --> </h4>
    </div>
        <!--<span class="bid">Current Bid: <span class="price">$<?PHP echo $CurrentBid; ?></span></span> -->
    <div class="details">
  <?PHP
    $sql = "SELECT `SaleId`, `SellerId`, `TextbookId`, `StartingBid`, `Condition` FROM Sale WHERE SellerId=\"".($_SESSION['UserId'] || $_GET['UserId'])."\" AND TextbookId = \"".($TextbookId)."\";";
    $salesResult = mysql_query($sql);
    if (mysql_num_rows($salesResult) > 0)
    {
    ?>
      <a class="linkButton" href="User/MyAccount.php"><div>Currently Selling</div></a>
    <?PHP
    }
    else
    {
    ?>
      <a class="linkButton" href="User/SellTextbook.php?tid=<?PHP echo $TextbookId; ?>"><div>I Have This</div></a>
  <?PHP } ?>
    <!--
      <span class="course">
      <select class="course">    
      <?PHP 
      /*
      $sql = "SELECT CourseId, CourseNumber, Title, SubjectId FROM Course WHERE TextbookId = '".($TextbookId)."' ORDER BY SubjectId;";
      $courseResult = mysql_query($sql);
      while ( list($CourseId, $CourseNumber, $CourseTitle, $SubjectId) = mysql_fetch_row($courseResult) )
      {
          $sql = "SELECT Title, ShortTitle FROM Subject WHERE SubjectId = '".$SubjectId."' LIMIT 0,1;";
          $subjectResult = mysql_query($sql);
          list($SubjectTitle, $ShortTitle) = mysql_fetch_row($subjectResult);
          echo "<option value=\"".($CourseId)."\">".($CourseTitle)." - ".($ShortTitle)." ".($CourseNumber)."</option>";
      }
      */
      ?>      
      </select></span>  -->
      
        <?PHP 
      
        try
        {
        
        $textbook = getTextbook($TextbookId);
        $ISBN13 = $textbook['ISBN13'];
        /*
        $jsonurl = "https://www.googleapis.com/books/v1/volumes?q=isbn:$ISBN13&key=AIzaSyCnMoqGsZpKt_0tY6QfQOW5L7lvU9DiC9s";
        //$json = file_get_contents($jsonurl,0,null,null);
        
        $json = url_get_contents($jsonurl);
        $json_output = json_decode($json, true);
        $textbookurl = $json_output['items'][0]['selfLink'];
        $textbookurl .= "?key=AIzaSyCnMoqGsZpKt_0tY6QfQOW5L7lvU9DiC9s";
        //$json = file_get_contents($textbookurl,0,null,null);
        $json = url_get_contents($textbookurl);
        $json_output = json_decode($json, true);
        */        
        $wishbook_output = getGoogleBookData($ISBN13);
        $imageLinks = $wishbook_output['volumeInfo']['imageLinks'];
      
        if (isset($imageLinks)) echo "<img src=\"".$imageLinks['smallThumbnail']."\" alt=\"Textbook thumbnail image\" style=\"float: left;\" />";
        } catch (Exception $e)
        {
        // echo "Error message: ".$e->getMessage();
        }
        
        echo "Course: ";
        $course = getCourse($CourseId);
        $subject = getSubject($course['SubjectId']);
        echo $subject['ShortTitle']." ".$course['CourseNumber']." - ".$course['Title'];
        ?>
    </div>
	</div>

<?PHP
}
?>   

<!-- Used to verify if catalog has changed. -->
<input type="hidden" class="updateIdentifier" value="<?PHP echo $updateIdentifier; ?>"/>
   

</div>