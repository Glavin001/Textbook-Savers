<?PHP
session_start(); 
//require '../Common/base.php'; 
//include '../Common/meta.php';
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

$uid = $facebook->getUser();
$pic =  "http://graph.facebook.com/".$uid."/picture";
$FacebookUsername = $user_profile['username'];
$FacebookId = $user_profile['id'];

if (isset($FacebookId) && isset($FacebookUsername))
{
  $query = ("UPDATE User SET 
  FacebookId = '".mysql_real_escape_string(strip_tags($FacebookId))."',
  FacebookUsername = '".mysql_real_escape_string(strip_tags($FacebookUsername))."' 
  WHERE UserId='".mysql_real_escape_string(strip_tags($_SESSION['UserId']))."';"); 
  $result = mysql_query($query)
  or die(mysql_error());
  header("Location: ../User/MyAccount.php");
}
else
{
  header("Location: ../User/LinkFacebook.php");
}

?>