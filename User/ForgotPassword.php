<?php session_start(); ?>

<!DOCTYPE html>
<html>

<head>
<title>Forgot Password</title>

<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
?>
<link rel="stylesheet" type="text/css" href="Styles/login.php">

<?PHP require '../Scripts/db.php'; ?>
<script src="Scripts/search.js"></script>

</head>

<body>

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div>

<?PHP 
if (isset($_SESSION['UserId']))
{
// Already logged in
?>
<p>You are already logged in. Are you sure you forgot your password? ;)</p>
<?PHP 
}
else
{
// Not yet logged in
?>

<form id="forgotPasswordForm" name="forgotPasswordForm" 
                action="Scripts/sendPasswordReset.php" method="post"> 
        <label for="UserName">Username:</label>
            <input type="text" id="UserName" name="UserName" placeholder="Hint: It's your email!" />
        <input type="submit" value="Reset Password" name="submit" style="width: 100%;" />
        <?php if ($_GET['retry'] == true) { ?>
          <p class="LV_invalid">Username does not exist. 
          Please try again.</p>
           <br />
           <p>If you would like to reset your password click <a href="User/ForgotPassword.php">here</a>.</p>
           <br /><hr /><br />
        <?php } ?>
        <p>Don't have an account with us? Click <a href="User/SignUp.php">here</a> to sign up!</p>            
</form>  

<?PHP
}
?>

</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>

