<?PHP
session_start();
?>

<!DOCTYPE html>
<html>

<head>
<title>Completing Login</title>

<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
?>
<link rel="stylesheet" type="text/css" href="Styles/home.php">

<?PHP require '../Scripts/db.php'; ?>
<script src="Scripts/search.js"></script>
<meta http-equiv="REFRESH" content="0;url=./User/MyAccount.php">
</head>

<body>

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="page">
<?php 
require_once("../Scripts/processLogin.php"); 
?>
</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>

