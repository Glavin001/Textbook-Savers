<?PHP
// Date in the past
header("Expires: Wed, 1 Dec 1993 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$updateIdentifier = "";

?>

<div class="textbookCatalog">

<h3 class="catalogTitle">Top Sellers</h3>

<?PHP
require_once 'common.php';
require_once 'db.php';

//$sql = "SELECT TextbookId, SUM(SoldCount) as OverallSoldCount FROM Sale GROUP BY TextbookId HAVING `OverallSoldCount` > '0' ORDER BY OverallSoldCount DESC LIMIT 0,10;";
$sql = "SELECT TextbookId, COUNT(*) as OverallSoldCount FROM Sale WHERE `SoldDate` != 'NULL' GROUP BY TextbookId HAVING `OverallSoldCount` > '0' ORDER BY OverallSoldCount DESC LIMIT 0,10;";

$saleResult = mysql_query($sql);
while ( list($TextbookId, $SoldCount) = mysql_fetch_row($saleResult) )
{

  $updateIdentifier .= $TextbookId."=".$SoldCount.",";


  $sql = "SELECT Title, Edition, Author, CourseId, ISBN13 FROM Textbook WHERE TextbookId = '".$TextbookId."' LIMIT 0,1;";
  $result = mysql_query($sql);
  list($TextbookTitle, $Edition, $Author, $CourseId, $ISBN13) = mysql_fetch_row($result);
  
  $sql = "SELECT FirstName, LastName, EmailAddress FROM User WHERE UserId = '".$SellerId."' LIMIT 0,1;";
  $result = mysql_query($sql);
  list($FirstName, $LastName, $EmailAddress) = mysql_fetch_row($result);
  
  $CurrentBid = $StartingBid;

  ?>
  <div class="catalogItem">
    <div class="title">
		  <h4>
        <span class="title">
          <?php 
          echo "<a href=\"Info/Textbook.php?tid=$TextbookId\">"; echo $TextbookTitle.(($Edition>1)?" (Edition $Edition)":""); ?> by <?PHP echo $Author; echo " (".$SoldCount . " Sold!)"; echo "</a>"; 
          ?>
        </span>
        <!-- <span class="bid"><?PHP echo "<a href=\"Find/SalesByTextbook.php?tid=$TextbookId\">I want this textbook!</a>";?></span>--> 
      </h4>
    </div>
        <!--<span class="bid">Current Bid: <span class="price">$<?PHP echo $CurrentBid; ?></span></span> -->
    <div class="details">
      <a class="linkButton" href="Find/SalesByTextbook.php?tid=<?PHP echo $TextbookId; ?>"><div>I Want This</div></a>        

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
        $json_output = getGoogleBookData($ISBN13);
        //print_r($json_output);      
        $imageLinks = $json_output['volumeInfo']['imageLinks'];
      
        if (isset($imageLinks)) echo "<img alt=\"Textbook thumbnail image\" style=\"float: left;\" src=\"".$imageLinks['smallThumbnail']."\">";
        } catch (Exception $e)
        {
        // echo "Error message: ".$e->getMessage();
        }
        
        
        
        $course = getCourse($CourseId);
        $subject = getSubject($course['SubjectId']);
        echo "Course: " . $subject['ShortTitle']." ".$course['CourseNumber']." - ".$course['Title'];
        
        ?>
    </div>
	</div>

<?PHP
}
?>      

<!-- Used to verify if catalog has changed. -->
<input type="hidden" class="updateIdentifier" value="<?PHP echo $updateIdentifier; ?>"/>

</div>