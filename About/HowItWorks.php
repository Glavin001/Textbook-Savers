<?php 
session_start(); 
require_once '../Scripts/db.php';
require_once '../Styles/theme.php';

?>

<!DOCTYPE html>
<html>

<head>
<title>How It Works</title>
<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
?>
<!-- <link rel="stylesheet" type="text/css" href="Styles/home.php"> -->
<?PHP require '../Scripts/db.php'; ?>

<style>
a.howitworks{
border-bottom: 1px dotted;
border-bottom-color: <?PHP echo $linkUnderlineColour; ?>;
}
a.howitworks:hover {
border-bottom: 1px solid;
border-bottom-color: <?PHP echo $linkUnderlineColour; ?>;
}
.selling.highlight {
    background-color: rgba(255,0,0,0.5);
}
.looking.highlight {
    background-color: rgba(0,0,255,0.5);
}
/*
.highlight {
    background-color: #FFF;
}*/

ul.userlist {
  float: left;
}
</style>
</head>

<body>
<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="page" style="overflow: auto;">

<br /><hr /><br />
<h2><a name="create-an-account">1. Create An Account</a></h2>
<p>The first step is to sign up and <a class="howitworks" href="User/SignUp.php">create your account!</a> 
The purpose of creating your own account is to provide each user their own personal page. On this page, you can manage your 
book listings, and your own personal wish-list!
<!-- TODO: Why you need an account. --></p>
<br /><hr /><br />
<h2><a name="create-an-account">2. Managing Your Account</a></h2>
<p>Once you've created <a class="howitworks" href="User/MyAccount.php"> your account</a>, you may edit your contact information,
 view your available credits, change the website theme, view your textbooks that are for sale, as well as update your wish-list.
</p>
<br /><hr /><br />
<h2><a name="sell-textbook">3. Buying & Selling Textbooks</a></h2>
<p>You can choose which textbooks to put on <a class="howitworks" href="User/SellTextbook.php">sale</a>, and for what price.
Listing your book for sale will cost 1 credit. <!--Credits can be purchased for $2 CAD.--> Once your book is listed, it will
 be available to everyone who uses our website. There are no time limits on how long your book is listed.  
<!--TODO: More on the Seller credit system.--></p>
<br /><hr /><br />
<h2><a name="wish-list">4. Wish-List</a></h2>
<p>To help you find the textbooks you need you can complete your <a class="howitworks" href="User/AddToWishlist.php">Wish-list</a>!
 Once your wish-list is updated, the website will display all of the books that are in demand will be displayed to the public. 
</p>
<br /><hr /><br />
<h2><a name="the-exchange">5. The Exchange</a></h2>
<p>After <em>the Buyer</em> has decided on a textbook they can press the <em>I Want This</em>
button and fill out the simple form, providing the <em>Seller</em> a way for you to be contacted. If the <em>Seller</em> has activated their account via Facebook, a notification will
 be sent to them. An e-mail and personal message on Textbook Savers will also be sent letting them know a buyer has been found.</p>
<br /><hr /><br />
  <h2><a name="behind-the-scenes">Behind-The-Scenes Connections</a></h2>
<p>This is my favourite part, and what makes this website so useful and powerful: the automation.</p>


<div style="overflow:auto;">
<div style="float: left; margin: 10px;">
User <strong>Bob</strong>:
<ul class="userlist normalList">
    <li class="selling ss1">Selling Textbook 1</li>
    <li class="looking ww2">Looking for Textbook 2</li>
    <li class="selling ss3">Selling Textbook 3</li>
</ul>
</div>

<div style="float: left; margin: 10px;">
User <strong>Alice</strong>:
<ul class="userlist normalList">
    <li class="selling ss2">Selling Textbook 2</li>
    <li class="looking ww1">Looking for Textbook 1</li>
</ul>
</div>


<div style="float: left; margin: 10px;">
User <strong>Carlos</strong>:
<ul class="userlist normalList">
    <li class="looking ww3">Looking for Textbook 3</li>
    <li class="selling ss1">Selling Textbook 1</li>
</ul>
</div>
</div>
<small>Important: Hover over the textbooks listed above to see who is selling and who is buying and how they link up.</small>

</p>

<script>
$(".userlist li").hover(function () {
    var n = $(this).attr('class').split(' ')[1].substr(2);
    $(".ss" + n + ", .ww" + n).toggleClass("highlight");
    console.log(n);
});
</script>
</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>

