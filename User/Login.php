<?php 
session_start(); 

require ('../Scripts/facebook-php-sdk/src/facebook.php');
$facebook = new Facebook(array(
  'appId'  => '491456304233582',
  'secret' => 'b45471665c2327a933a9de4abb3c8031',
));
//save the access token for later
$accessToken = $facebook->getAccessToken();
// Get User ID
$user = $facebook->getUser();
if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $facebook->setAccessToken($accessToken);
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }	
}

function getBaseURI()
 {
        $ThisLink = 'http'.(isset($_SERVER["HTTPS"]) ? $_SERVER["HTTPS"] == 'off' ? '' : 's' : '').
                    '://'.
                    $_SERVER['HTTP_HOST'].
                    $_SERVER['REQUEST_URI'];

        $UrlParts = parse_url($ThisLink);

        $Path = $UrlParts['path'];

        // Get rid of filename.html in /folder1/folder2/filename.html
        $Path = preg_replace('#(/)([^/]*?\..*?$)#i', '$1', $Path);

        // Make it standard to have trailing / at the end of a foldername
        if (substr($Path, -1) != '/')
         $Path .= '/';
        
        $absURI = $UrlParts['scheme'].'://'.$UrlParts['host'].$Path;

        return $absURI;
 }
$baseURI = getBaseURI();

/*
if ($user) {
  $redirectURI = $baseURI.'/Login.php';
  $params = array('redirect_uri' => $redirectURI );  
  $logoutUrl = $facebook->getLogoutUrl($params);
} else {
*/

  //$redirectURI = $baseURI.'../Scripts/processLogin.php';
  $redirectURI = $baseURI.'/CompleteLogin.php?FacebookLogin=True';
  $params = array('redirect_uri' => $redirectURI , 'display' => 'popup');
  $loginUrl = $facebook->getLoginUrl($params);
//}


?>

<!DOCTYPE html>
<html>

<head>
<title>Login</title>

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

<div class="page">

<?PHP 
if (isset($_SESSION['UserId']))
{
// Already logged in
?>
You are already logged in.<br />
<?PHP 
}
else
{
// Not yet logged in
?>

<form id="loginForm" name="loginForm" action="Scripts/processLogin.php" method="post" onsubmit="return validateLoginForm();"> 
  <a href="<?php echo $loginUrl; ?>">
  <img alt="Sign up with Facebook" style="width:100%;" src="http://static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_light_medium_long.gif" />
  </a>                

  <br />
  <br />
  <h3><hr /></h3>
  <br />

  <label for="UserName">Username:</label>
      <input type="text" id="UserName" name="UserName" placeholder="Hint: It's your email!" />
  <br />
  <label for="UserPassword">Password:</label>
      <input type="password" id="UserPassword" name="UserPassword" placeholder="" />
  <br />
  <input type="submit" value="Login" name="submit" />
  <input type="reset" value="Reset" name="reset" />
  <?php if ($_GET['retry'] == true) { ?>
    <p class="LV_invalid">There was an error in the login.
     Either username or password was incorrect.
     Please re-enter the correct login information.</p>
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

