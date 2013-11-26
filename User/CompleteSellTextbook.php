<?php session_start(); ?>

<!DOCTYPE html>
<html>

<head>
<title>Completing Textbook Sale Creation</title>

<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
?>

<?PHP require '../Scripts/db.php'; ?>
<script src="Scripts/search.js"></script>

</head>

<body>

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="page">
<?php include "../Scripts/createSale.php"; ?>
</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>

