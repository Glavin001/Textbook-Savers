<div class="textbookCatalog">

<?PHP
		
		if (isset($TextbookId)) 
		{
      $sql = "SELECT `SaleId`, `SellerId`, `TextbookId`, `StartingBid`, `Condition` FROM Sale WHERE TextbookId = \"".($TextbookId)."\";";
		}
		else
		{
      $sql = "SELECT `SaleId`, `SellerId`, `TextbookId`, `StartingBid`, `Condition` FROM Sale;";
		}
		$salesResult = mysql_query($sql);
		while ( list($SaleId, $SellerId, $TextbookId, $StartingBid, $Condition, $SellingCount, $SoldCount) = mysql_fetch_row($salesResult) )
		{      
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
            <span class="title"><?PHP echo "<a href=\"Info/Textbook.php?tid=$TextbookId\">"; echo $TextbookTitle.(($Edition>1)?" (Edition $Edition)":""); ?></a></span>
            <span> is being sold by <?PHP echo "<a href=\"Info/User.php?uid=$SellerId\" class=\"sellerName\">"; echo $FirstName." ".$LastName; ?></a>.</span>
            <span class="bid">Asking Price: <span class="price">$<?PHP echo $CurrentBid; ?></span></span>
          </div>
          <div class="details">
            <?PHP
            //if (isset($_SESSION['UserId']))
            //{
              //echo "<input type=\"image\" src=\"Images/IWantThis.png\" alt=\"I Want This\" style=\"float: right; \" width=\"90\" height=\"40\" onClick=\"window.open('User/ContactSeller.php?sid=" . $SaleId . "', 'WindowC', 'width=931, height=564,scrollbars=yes'); return false;\">";
            ?>
              <a class="linkButton" href="User/ContactSeller.php?sid=<?PHP echo $SaleId; ?>"><div>I Want This</div></a>
            <?PHP
            //}
            ?>
            
            
            <!--
            <h3>Course:</h3>
            <span class="course">
            -->
            <?PHP             
            /*
            $sql = "SELECT CourseId, CourseNumber, Title, SubjectId FROM Course WHERE CourseId = '".($CourseId)."' ORDER BY SubjectId LIMIT 0,1;";
            $result = mysql_query($sql);
            list($CourseId, $CourseNumber, $CourseTitle, $SubjectId) = mysql_fetch_row($result);
            $sql = "SELECT Title, ShortTitle FROM Subject WHERE SubjectId = '".$SubjectId."' LIMIT 0,1;";
            $CourseResult = mysql_query($sql);
            list($SubjectTitle, $ShortTitle) = mysql_fetch_row($CourseResult);
            //echo "<option value=\"".($CourseId)."\">".($CourseTitle)." - ".($ShortTitle)." ".($CourseNumber)."</option>";
            
            echo ($ShortTitle)." ".($CourseNumber)." - ".($CourseTitle);
            echo "</span>";
            */
            ?>
            
            <h3>Condition and Sales Notes:</h3>
            <div class="condition">
            <?PHP echo $Condition; ?>
            </div>
            
          </div>
        </div>
      <?PHP
		}
?>

</div>
