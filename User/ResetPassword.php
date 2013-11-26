<?php session_start(); ?>

<!DOCTYPE html>
<html>

<head>
<title>Reset Password</title>

<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
?>
<link rel="stylesheet" type="text/css" href="Styles/login.php">

<?PHP require '../Scripts/db.php'; ?>
<script src="Scripts/search.js"></script>
<script src="Scripts/livevalidation_standalone.compressed.js"></script>

</head>

<body>

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="page">

<?PHP 
// Check username and resetid
$username = $_GET['username'];
$resetid = $_GET['resetid'];

$sql = "SELECT UserId, FirstName, LastName, EmailAddress FROM User WHERE EmailAddress = '".mysql_real_escape_string(strip_tags($username))."' AND SpecialActionId = '".mysql_real_escape_string(strip_tags($resetid))."' LIMIT 0,1;";
$result = mysql_query($sql);
if (mysql_num_rows($result) > 0)
{
// Valid
  list($UserId, $FirstName, $LastName, $EmailAddress) = mysql_fetch_row($result);
?>
<form id="passwordResetForm" name="passwordResetForm" 
                action="Scripts/processResetPassword.php" method="post"> 
        <p>Reseting password for<br />User: <?PHP echo $FirstName." ".$LastName; ?>
        <!--<br />Username: <?PHP echo $EmailAddress; ?> -->
        <br /><hr /><br />
        <label for="loginPassword">Password:</label>
        <input type="password" id="loginPassword" name="loginPassword" />
        <label for="confirmPassword">Confirm:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" />
        <input type="submit" value="New Password" name="submit" style="width: 100%;" />
        <?PHP 
        echo "<input type=\"hidden\" name=\"username\" value=\"".$username."\" />";
        echo "<input type=\"hidden\" name=\"resetid\" value=\"".$resetid."\" />";        
        ?>
        <p>Don't have an account with us? Click <a href="User/SignUp.php">here</a> to sign up!</p>            
</form>  
<?PHP
}
else
{
// Invalid
?>
<p>You cannot reset the password. <a href="User/ForgotPassword.php">Please try signing in again.</a></p>
<p>Don't have an account with us? Click <a href="User/SignUp.php">here</a> to sign up!</p>            
<?PHP 
}
?>

<script>
var loginPass = new LiveValidation('confirmPassword', {validMessage: "Thank you.", failureMessage: "Please enter your password." });
loginPass.add( Validate.Presence );
loginPass.add( Validate.Confirmation, { match: 'loginPassword' } );    
loginPass.add( Validate.Exclusion, { within: [ ' ' ], partialMatch: true, failureMessage: "No spaces!" } );

loginEmail.form.onsubmit = function(){
var valid = LiveValidation.massValidate([firstName, lastName, loginEmail, loginPass]);
//if (valid) alert('The form is valid!');
return valid;
}

</script>


</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>

