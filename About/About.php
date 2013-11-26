<?php 
session_start(); 
?>

<!DOCTYPE html>
<html>

<head>
<title>About Us</title>

<?PHP 
require_once '../Scripts/common.php';
require '../Common/base.php'; 
include '../Common/meta.php';
?>
<!-- <link rel="stylesheet" type="text/css" href="Styles/home.css"> -->

<?PHP require '../Scripts/db.php'; ?>
<script src="Scripts/search.js"></script>

</head>

<body>

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="page">

<h1>The Team</h1>
<h2>Mike Pratt</h2>
<img src="http://graph.facebook.com/mikepratt17/picture/" alt="Mike Pratt profile photo" />


<h2>Glavin Wiechert</h2>
<img src="http://graph.facebook.com/gwiechert/picture/" alt="Glavin Wiechert profile photo" />


<br /><br /><hr />
<div id="statsBanner">
<?PHP
$sql = "SELECT SUM(Status) FROM Sale;";
$result = mysql_query($sql);
list($salesCount) = mysql_fetch_row($result);
?>

<h1>The Idea</h1>
<h2>What is Textbook Savers?</h2>
<br />
Textbook Savers is a website designed to allow students, or anyone interested 
in books, a place to buy and sell their used books.
<br /><br />
<h2>What has Textbook Savers done so far?</h2>
<br />
Textbook Savers has helped <span class="value" id="soldCount"></span><span class="title"> users sell their books, for a total of </span><strong><span class="value">$</span><span class="value" id="totalSold1">0</span>.<span class="value" id="totalSold2">00</span></strong>. That number is increasing all the time!
<br /><br />

<?PHP
  echo "<script>";
  echo "var salesCount = animatedCounter(document.getElementById(\"soldCount\"), 0, ".(intval($salesCount)).", 1, null, 10, function(){ });";
?>
</script>

<!--<div class="widget"><span class="value">$</span><span class="value" id="totalSold1">0</span>.<span class="value" id="totalSold2">00</span><br /><span class="title">Total Sold</span></div>-->
<?PHP
$sql = "SELECT SUM(SoldPrice * Status) as TotalSold FROM Sale;";
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


<h2>Why shop on Textbook Savers?</h2>
<br />
The main goal of Textbook Savers is to ensure that our customers get top dollar in
return for their used textbooks. Bookstores offer as little as they can, while charging
a very high price for used books. We cut out the books store, and allow our sellers 
a chance to sell their books for a higher price than book store would pay, and our buyers
a chance to buy their books for a lower price than the book store would charge. 
<br /><br />
<h2>What does Textbook Savers charge?</h2>
<br />
Textbook Savers charges a $3 (plus tax) fee to list each textbook. Similar websites charge between 10%-15% selling price per book to sell your textbooks. There are no charges to the buyers.
<br />
We deal directly with PayPal to ensure a 100% safe and secure payment environment.
<br /><br />
<h2>Do I need a PayPal account to use the selling features?</h2>
<br />
No, you don't! PayPal offers an instant transaction feature where all you'll need is a valid credit card. Just click the "Buy Now!" 
 button, select "Don't have a Paypal account?" and fill in your information. It's that easy!
<br /><br />
<h2>Will Textbook Savers share my personal information?</h2>
<br />
Textbook Savers will not disclose any personal information to the public, unless otherwise authorized by you. Only information that you select will be provided to the book seller.
<br /><br />

</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>

