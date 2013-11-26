<?php
// logout.php
session_start();
if ($_SESSION["UserId"] == "") $notLoggedIn = true;
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html>

<head>
<title>Home</title>

<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
?>
<!-- <link rel="stylesheet" type="text/css" href="Styles/home.php"> -->

<?PHP require '../Scripts/db.php'; ?>
<script src="Scripts/search.js"></script>

</head>

<body>

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="page">

  <?php if ($notLoggedIn) { ?>
  <p>You have not yet logged in.</p>
  <p><a href="User/Login.php">Click here if you wish to
    log in.</a></p>
  <?php } else { ?>
  <p>You have successfully logged out.</p>
  <p><a href = "User/Login.php">Click here if you wish
    to log back in.</a></p>
  <?php } ?>

</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>
