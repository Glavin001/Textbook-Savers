<?php session_start(); ?>

<!DOCTYPE html>
<html>

<head>
<title>Completing Course Creation</title>

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
<?php include "../Scripts/createTextbook.php"; ?>
</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>

