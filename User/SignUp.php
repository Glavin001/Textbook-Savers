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
  $redirectURI = $baseURI.'/CompleteSignUp.php';
  $params = array('redirect_uri' => $redirectURI , 'display' => 'popup');
  $loginUrl = $facebook->getLoginUrl($params);
//}

?>

<!DOCTYPE html>
<html>

<head>
<title>Sign Up</title>

<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
?>
<!-- <link rel="stylesheet" type="text/css" href="Styles/home.php"> -->

<?PHP require '../Scripts/db.php'; ?>
<script src="Scripts/search.js"></script>
<script src="Scripts/livevalidation_standalone.compressed.js"></script>

</head>

<body>

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="page">

<h2>Option 1: One-Click Facebook Connect</h2>
<br /><a href="<?php echo $loginUrl; ?>">
<img alt="Sign up with Facebook" src="http://static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_light_medium_long.gif" />
</a>
<p><br />One-Click connection with your own Facebook account. 
You can receive messages sent from here to your Facebook Inbox, and login with a simply click of a button.</p>
<br />
<br />
<hr/>
<br />

<h2>Option 2: Registration Form</h2>
<div id="text" class="FeedbackForm">
          <h4>Sign Up</h4>
          <p>
          Please fill out the form below to sign up and start saving and earning more money with textbooks!
          </p>
          
          <form id="register" name="register" action="User/CompleteSignUp.php"
            method="post" onsubmit="return validateRegistrationForm();">
            <fieldset>
            <legend><strong>Personal Information</strong></legend>
            
            <table summary="Registration Form">
              <tr valign="top">
                <td>First Name:</td>
                <td><input  id="firstName" type="text" name="firstName" size="40" placeholder="(Required)" /></td>
              </tr>
              <tr valign="top">
                <td>Middle Name:</td>
                <td><input  id="middleInitial" type="text" name="middleInitial" size="40" placeholder="(Optional)" /></td>
              </tr>
              <tr valign="top">
                <td>Last Name:</td>
                <td><input  id="lastName" type="text" name="lastName" size="40" placeholder="(Required)" /></td>
              </tr>
              </table>
              </fieldset>
              
              <table summary="Break">
              <tr><td>&nbsp;</td></tr>
              </table>
              
              <fieldset>
              <legend><strong>Login Account Information</strong></legend>
              
              <table summary="User Login Account Information">
              
              <tr valign="top">
                <td>Login E-mail (Username):</td>
                <td><input id="email" type="text" name="email" size="40" /></td>
              </tr>
              <tr valign="top">
                <td>Login Password:</td>
                <td><input id="loginPassword" type="password" name="loginPassword"
                size="40" /></td>
              </tr>
              <tr valign="top">
                <td>Confirm Password:</td>
                <td><input id="confirmPassword" type="password" name="confirmPassword"
                size="40" /></td>
              </tr>
              <tr valign="top">
                <td>Phone Number:</td>
                <td><input id="phone" type="tel" name="phone" size="40" /></td>
              </tr>
              <tr>
                <td><input type="submit" value="Create your user account!" /></td>
                <td align="right"><input type="reset" value="Reset Form" /></td>
              </tr>
            </table>
            
            </fieldset>
            
          </form>
        
          <script type="text/javascript">
            var firstName = new LiveValidation('firstName', {validMessage: "Thank you.", failureMessage: "Please enter your first name." });
            firstName.add( Validate.Presence );
            firstName.add( Validate.Exclusion, { within: [ ' ' ], partialMatch: true, failureMessage: "No spaces!" } );
            firstName.add( Validate.Length, { minimum: 2 } );
            
            var lastName = new LiveValidation('lastName', {validMessage: "Thank you.", failureMessage: "Please enter your last name." });
            lastName.add( Validate.Presence );
            lastName.add( Validate.Exclusion, { within: [ ' ' ], partialMatch: true, failureMessage: "No spaces!" } );
            lastName.add( Validate.Length, { minimum: 2 } );
            
            var loginEmail = new LiveValidation( 'email', { wait: 500, validMessage: "Valid email address!", failureMessage: "Please enter a valid email address." } );
            loginEmail.add( Validate.Presence );
            loginEmail.add( Validate.Email );
            
            <?php
            /*
            $sql = "SELECT UserId, EmailAddress FROM User;";
            $result = mysql_query($sql);
            $rows = array();
            while ( list($UserId, $EmailAddress) = mysql_fetch_row($result) )
            {
              $rows[] = $EmailAddress;
            }
            */
            ?>
            //var usedEmails = <?php echo json_encode($rows); ?>;
            //loginEmail.add( Validate.Exclusion, { within: usedEmails , caseInsensitive: true , partialMatch: false, failureMessage: "Email already in use!" } );
            
            
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
</div>

</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>