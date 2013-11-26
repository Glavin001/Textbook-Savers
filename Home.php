<?php 
session_start(); 
require_once 'Scripts/common.php';

if (isset($_GET['theme'])) $_SESSION['theme'] = $_GET['theme'];

 require ('Scripts/facebook-php-sdk/src/facebook.php');
    $facebook = new Facebook(array(
    'appId'  => '491456304233582',
    'secret' => 'b45471665c2327a933a9de4abb3c8031',
));
?>

<!DOCTYPE html>
<html>

<head>
<title>Textbook Savers</title>

<?PHP 
require 'Common/base.php'; 
include 'Common/meta.php';
?>
<link rel="stylesheet" type="text/css" href="Styles/catalog.php">
<link rel="stylesheet" type="text/css" href="Styles/home.php">


<?PHP require 'Scripts/db.php'; 
//UPDATE FACEBOOKID
if (isset($_SESSION['UserId']))
{
$user = $facebook->getUser();
    $query = "UPDATE User SET FacebookId = $user WHERE UserId='".$_SESSION['UserId']."';";
						 $credits = mysql_query($query)
						     or die(mysql_error());



}


?>
<script src="Scripts/search.js"></script>

<!-- <script src="Scripts/jsdiff.js"></script> -->

<script>
/*
  function typeSearch(str, i, speed, callback)
  {
    var searchInput = $(".searchInput");
    searchInput.val(str.substr(0,i)).keyup();
    if (i != str.length)
    {
      setTimeout(function () { typeSearch(str,i+1,speed, callback); }, speed);
    }
    else
    {
      callback();
    }
  }
  
  $(function () {
  var searchArray = [
    'ACCT 2241',
    'Computer Science Web Programming',
    'Psychology Mind and Brain',
    'Introduction to Psychology PSYC 1200'
    ];
  var randomNumber = Math.floor(Math.random()*searchArray.length);

    typeSearch(searchArray[randomNumber],0,100, function () { console.log("Finished: "+searchArray[randomNumber]); $("#suggestionResults li ul li").first().delay(1000).effect("highlight", {}, 5000); } );
  });
  */
</script>

<script>

$(function () {

var refreshInterval = 5000;
var highlightDuration = 1000;

var textbookCatalog = function (overwrite) { 
//console.log("Refreshing textbook catalog");
$.ajax({
  type: "POST",
  url: "Scripts/textbookCatalog.php",
  data: { },
  dataType: "html"
}).done(function( data ) {
  //if ($("#textbookCatalog").html() != data)
  if (overwrite || ($("#textbookCatalog").find(".updateIdentifier").val() != $(data).find(".updateIdentifier").val()))
  {
    //var pattern = "$amp;", re = new RegExp(pattern, "g");
    //$("#getStarted").html( diffString( $("#textbookCatalog").html().replace(re,"&") , data.replace(re,"&") ) );
    $("#textbookCatalog").html(data);
    $("#textbookCatalog").effect("highlight", {}, highlightDuration);    
  }
  else
  {
    //console.log("Not updating");
    //console.log( $(data).find(".updateIdentifier").val() );
  }
}); 
} 

textbookCatalog(true);
setInterval(textbookCatalog, refreshInterval);

var wishlistCatalog = function (overwrite) { 
//console.log("Refreshing wishlist catalog");
$.ajax({
  type: "GET",
  url: "Scripts/wishlistCatalog.php",
  data: { 'UserId' : '<?PHP echo $_SESSION['UserId']; ?>' },
  dataType: "html"
}).done(function( data ) {
  //console.log("Received back HTML data");
  //if ($("#wishlistCatalog").html() != data)
  if (overwrite || ($("#wishlistCatalog").find(".updateIdentifier").val() != $(data).find(".updateIdentifier").val()))
  {
    $("#wishlistCatalog").html(data);
    $("#wishlistCatalog").effect("highlight", {}, highlightDuration);    
    //console.log(data);
    //console.log("Finished refreshing");
  }
      
}); 
} 

wishlistCatalog(true);
setInterval(wishlistCatalog, refreshInterval);


});

</script>

</head>

<body>

<header>
<?PHP require 'Common/header_menu.php'; ?>
</header>

<div class="textbookWall" id="wallMessage">
<!-- <div style="background-color: black; opacity: 0.0; width: 100%; height: 200px;" > -->
<!-- <span style="float: left;" ><img src="Images/logo.png" height="120" alt="Textbook Savers Logo" /></span> -->
<!-- <span style="float: right;" ><img src="Images/beta.png" height="120" alt="Beta Logo" /></span> -->
<span style="position: absolute; bottom: 100px; left: 0%; width: 100%;">
<!--
<span style="font-size: 2em; font-weight: bold; box-shadow: 10px; background-color: rgba(255,255,255,0.9); box-shadow: 0 0 100px 40px #FFF; z-index: -6;"><span style="z-index: 6;">Textbook Savers is an efficient way to sell and buy used Textbooks by introducing you to others!</span></span><br />
<div style="font-size: 1.5em; font-weight: bold; background-color: rgba(255,255,255,0.9); box-shadow: 0 0 100px 40px #FFF; z-index: -5; "><span style="z-index: 5;">Easy. Social. Money Saver.</span></div>
-->

<div id="messageBlock"><span style="z-index: 6;">Textbook Savers is an efficient way to sell and buy used Textbooks by introducing you to others!</span><br />
<span style="z-index: 5;">Easy. Social. Money Saver.</span></div>

<h4 class="signupNowButton">
<!-- <a href="javascript:activateGetStarted();">Get Started Now</a></h3> -->
<a href="About/HowItWorks.php">Learn How To Get Started</a></h3>
</span>
</div>

<div class="textbookWall" id="wallImages">
<?PHP
$sql = "SELECT TextbookId, ISBN10, ISBN13, TextbookId*0+RAND() AS random_record FROM Textbook ORDER BY random_record;";
$displayedCount = 0; 
$maxDisplay = 120;
while ($displayedCount < $maxDisplay)
{
  $result = mysql_query($sql);
  while ( ($displayedCount < $maxDisplay) && ( list($TextbookId, $ISBN10, $ISBN13) = mysql_fetch_row($result) ) )
  {
    $json_output = getGoogleBookData($ISBN13);
    $imageLinks = $json_output['volumeInfo']['imageLinks'];
    if (isset($imageLinks)) 
    {
      //  echo "<img alt=\"Textbook thumbnail image\" width=\"128\" height=\"160\" src=\"".$imageLinks['thumbnail']."\">";
      echo "<img alt=\"Textbook thumbnail image\" width=\"64\" height=\"80\" src=\"".$imageLinks['smallThumbnail']."\">";
      $displayedCount++;
    }
  }
}
?>
</div>

<div id="getStarted" class="deactivated">
<iframe width="960" height="720" src="http://www.youtube.com/embed/0JGHI4TAC5U?rel=0" frameborder="0" allowfullscreen></iframe> 
</div>
<script>
// $("#getStarted").hide();
function deactivateGetStarted()
{
  var getStarted = $("#getStarted");
  getStarted.attr("href","javascript:");
  getStarted.removeClass("activated");
  getStarted.addClass("deactivated");
}
function activateGetStarted()
{
  var getStarted = $("#getStarted");
  getStarted.removeClass("deactivated");
  getStarted.addClass("activated");
}
deactivateGetStarted();
</script>

<div class="page">

<!--
<div id="statsBanner">
<div class="widget"><span class="value" id="soldCount">0</span><br /><span class="title">Number of Sales</span></div>
<?PHP
$sql = "SELECT SUM(SoldCount) FROM Sale;";
$result = mysql_query($sql);
list($salesCount) = mysql_fetch_row($result);
?>

<?PHP
  echo "<script>";
  echo "var salesCount = animatedCounter(document.getElementById(\"soldCount\"), 0, ".(intval($salesCount)).", 1, null, 10, function(){ });";
?>
</script>

<div class="widget"><span class="value">$</span><span class="value" id="totalSold1">0</span>.<span class="value" id="totalSold2">00</span><br /><span class="title">Total Sold</span></div>
<?PHP
$sql = "SELECT SUM(StartingBid * SoldCount) as TotalSold FROM Sale;";
$result = mysql_query($sql);
if (mysql_num_rows($result) > 0)
{
  list($TotalSold) = mysql_fetch_row($result);
}
  echo "<script>";
  echo "var totalSold1 = animatedCounter(document.getElementById(\"totalSold1\"), 0, ".(intval($TotalSold)).", 1, null, 1, function(){ animatedCounter(document.getElementById(\"totalSold2\"), 0, ".(($TotalSold*100)%100).", 1, 2, 1, function(){ }); });";
?>
</script>

</div>
-->

<!--
<div class="searchBox">
<form> 
<div class="searchInput"><input class="searchInput" type="text" placeholder="Search for a Textbook, Course, Subject or more!" onkeyup="showSuggestion(this.value)"></div>
</form>
<div class="suggestionResults">
<ul class="normalList"><span id="suggestionResults">
</span></ul>
</p>
</div>
</div>
<hr />
-->

<div class="" style="vertical-align: top; width:100%;">
<div id="textbookCatalog" style="display: inline-block; vertical-align: top; width: 49%; " >
<?PHP 
//include("Scripts/textbookCatalog.php"); 
?>
<strong>Loading Textbook Catalog. Please make sure JavaScript is enabled.</strong>
</div>
<div id="wishlistCatalog" style="display: inline-block; vertical-align: top; width: 49%; " >
<?PHP 
//include("Scripts/wishlistCatalog.php"); 
?>
<strong>Loading Wish-List Catalog. Please make sure JavaScript is enabled.</strong>
</div>
</div>

</div>

</div>

<footer>
<?PHP require 'Common/footer_menu.php'; ?>
</footer>

</body>
</html>

