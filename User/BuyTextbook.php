<?php 
session_start(); 
require_once '../Scripts/common.php';

if (isset($_GET['theme'])) $_SESSION['theme'] = $_GET['theme'];

 require ('../Scripts/facebook-php-sdk/src/facebook.php');
    $facebook = new Facebook(array(
    'appId'  => '491456304233582',
    'secret' => 'b45471665c2327a933a9de4abb3c8031',
));
?>

<!DOCTYPE html>
<html>

<head>
<title>Buy Textbook</title>

<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
?>
<link rel="stylesheet" type="text/css" href="Styles/catalog.php">

<?PHP require '../Scripts/db.php'; 
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

<script>
  function typeSearch(str, i, speed, callback)
  {
    var searchInput = $(".searchInput");
    searchInput.val(str.substr(0,i)).keyup();
    if (i != str.length)
    {
      if (!searchInput.is(":focus")) setTimeout(function () { typeSearch(str,i+1,speed, callback); }, speed);
    }
    else
    {
      callback();
    }
  }
  
  $(function () {
    var typingInterval = 100;
    var searchArray = [
      'ACCT 2241',
      'Computer Science Web Programming',
      'Psychology Mind and Brain',
      'Introduction to Psychology PSYC 1200'
      ];
    var randomNumber = Math.floor(Math.random()*searchArray.length);
    var searchQuery = searchArray[randomNumber];
    if ("<?PHP echo $_GET['q']; ?>" != "")
    {
      searchQuery = "<?PHP echo $_GET['q']; ?>";
      typingInterval /= 4;
    }
    typeSearch(searchQuery,0,typingInterval, function () { console.log("Finished: "+searchQuery); $("#suggestionResults li ul li").first().delay(1000).effect("highlight", {}, 5000); } );
  });
  
</script>

</head>

<body>

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="page">

<h1>Buy Textbook</h1>
<br />
<h3>This is our search bar. Simply enter a User, Textbook title, Course name, Course number, or subject related to the textbook you're looking for and the results will be shown below.
*Note: Users shown will either have the textbook on their for sale list, or their wish-list*</h3>


<!--
<div id="statsBanner">
<div class="widget"><span class="value" id="soldCount">0</span><br /><span class="title">Number of Sales</span></div>
<?PHP
$sql = "SELECT SUM(Status) FROM Sale;";
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
$sql = "SELECT SUM(StartingBid * Status) as TotalSold FROM Sale;";
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


<div class="searchBox">
<form> 
<div class="searchInput"><input class="searchInput" type="text" placeholder="Search for a User, Textbook, Course, Subject or more!" onkeyup="showSuggestion(this.value)"></div>
</form>
<div class="suggestionResults">
<ul class="normalList"><span id="suggestionResults">
</span></ul>
</p>
</div>
</div>

<hr />

<!--
<div class="" style="vertical-align: top; width:100%;">
<div id="textbookCatalog" style="display: inline-block; vertical-align: top; width: 49%; " >
<?PHP 
//include("../Scripts/textbookCatalog.php"); 
?>
<strong>Loading Textbook Catalog. Please make sure JavaScript is enabled.</strong>
</div>
<div id="wishlistCatalog" style="display: inline-block; vertical-align: top; width: 49%; " >
<?PHP 
//include("../Scripts/wishlistCatalog.php"); 
?>
<strong>Loading Wish-List Catalog. Please make sure JavaScript is enabled.</strong>
</div>
</div>
-->

</div>

</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

<script>

$(function () {

var refreshInterval = 5000;
var highlightDuration = 1000;

var textbookCatalog = function (overwrite) { 
//console.log("Refreshing textbookCatalog");
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
  }
}); 
} 

textbookCatalog(true);
setInterval(textbookCatalog, refreshInterval);

var wishlistCatalog = function (overwrite) { 
//console.log("Refreshing textbookCatalog");
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

</body>
</html>

