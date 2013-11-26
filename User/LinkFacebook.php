<?php 
session_start(); 
require '../Common/base.php'; 
include '../Common/meta.php';
require '../Scripts/db.php';


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
  $redirectURI = $baseURI.'/CompleteLogin.php';
  $params = array('redirect_uri' => $redirectURI , 'display' => 'popup');
  $loginUrl = $facebook->getLoginUrl($params);
//}


?>
<!DOCTYPE html>
<html>

<head>
<script type="text/javascript">
function Redirect()
{
    window.location="http://cs.smu.ca/~g_wiechert/TextbookSavers/User/MyAccount.php";
}
</script>
</head>

<link rel="stylesheet" type="text/css" href="Styles/profile.php">

<title>Link Your Account</title>
<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="page">
<br /><br />
<form method="POST" action="Scripts/processFacebookLinking.php">
<?PHP 
$uid = $facebook->getUser();
$pic =  "http://graph.facebook.com/".$uid."/picture";
$FacebookUsername = $user_profile['username'];
echo "<img src=\"" . $pic . "\" />  ";
echo "<strong>";
echo json_decode(file_get_contents('http://graph.facebook.com/'.$uid.''))->name;
?>
<br /><br /><br />
Is this you?
<br />
<?PHP
echo "</strong>";
?>
<input type="submit" class="" name="linkFacebook" value="Yes, it is!"></input>
</form>
<br /><br />
</div>		

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</html>