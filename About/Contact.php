<?php 
session_start(); 
?>

<!DOCTYPE html>
<html>

<head>
<title>Contact Us</title>

<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
include '../Styles/theme.php';
?>
<!-- <link rel="stylesheet" type="text/css" href="Styles/home.css"> -->

<?PHP require '../Scripts/db.php'; ?>
<script src="Scripts/search.js"></script>

<style>
a.emaillink{
border-bottom: 1px dotted;
border-bottom-color: <?PHP echo $linkUnderlineColour; ?>;
color: blue;
}
a.emaillink:hover {
border-bottom: 1px solid;
border-bottom-color: <?PHP echo $linkUnderlineColour; ?>;
}
</style>

</head>

<body>

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="page">
<br /><br />
If you have any questions, or concerns regarding Textbook Savers, feel free to reach us at:
<a class="emaillink" href="mailto:textbooksavers@hotmail.com">textbooksavers@hotmail.com</a>  
<br /><br />

</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>

