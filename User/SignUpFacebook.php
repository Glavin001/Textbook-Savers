<?php 
session_start(); 

require '../Scripts/facebook-php-sdk/src/facebook.php';
$facebook = new Facebook(array(
  'appId'  => '491456304233582',
  'secret' => 'b45471665c2327a933a9de4abb3c8031',
));
// Get User ID
$user = $facebook->getUser();
if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

?>

<!DOCTYPE html>
<html>

<head>
<title>Sign Up using Facebook</title>

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

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=491456304233582";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

  // Additional JS functions here
  window.fbAsyncInit = function() {
  FB.init({
  appId      : '491456304233582', // App ID
  channelUrl : '//cs.smu.ca/~g_wiechert/TextbookSavers/Scripts/channel.html', // Channel File
  status     : true, // check login status
  cookie     : true, // enable cookies to allow the server to access the session
  xfbml      : true  // parse XFBML
  });
  
  // Additional init code here
  FB.getLoginStatus(function(response) {
      if (response.status === 'connected') {
          // User logged into FB and authorized
          testAPI();
          document.getElementById('fb-logout').style.display = 'block';
      } else if (response.status === 'not_authorized') {
          // User logged into FB but not authorized
          login();
      } else {
          // User not logged into FB
          login();
          document.getElementById('fb-logout').style.display = 'block';
      }
  });
  
  };
  
  function login() {
  FB.login(function(response) {
  if (response.authResponse) {
  // connected
  testAPI();
  } else {
  // cancelled
  }
  });
  }
  
  function logout() {
    FB.logout(function(response) {
        console.log('User is now logged out');
    });
  }
  
  function testAPI() {
  console.log('Welcome!  Fetching your information.... ');
  FB.api('/me', function(response) {
  console.log('Good to see you, ' + response.name + '.');
  console.log(response);
  document.getElementById("firstName").value = response.first_name;
  document.getElementById("lastName").value = response.last_name;
  });
  }
  
  // Load the SDK Asynchronously
  (function(d){
  var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement('script'); js.id = id; js.async = true;
  js.src = "//connect.facebook.net/en_US/all.js";
  ref.parentNode.insertBefore(js, ref);
  }(document));
  
</script>

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<?php if ($user): ?>
  <a href="<?php echo $logoutUrl; ?>">Logout</a>
<?php else: ?>
  <div>
    Login using OAuth 2.0 handled by the PHP SDK:
    <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
  </div>
<?php endif ?>
  
<?php if ($user): ?>
<h3>You</h3>
<img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

<h3>Your User Object (/me)</h3>
<pre><?php 
//print_r($user_profile); 
?></pre>
<?php else: ?>
<strong><em>You are not yet logged into Facebook for Textbook Savers.</em></strong>
<?php endif ?>

<div id="text" class="FeedbackForm">
          <h4>Sign Up</h4>
          <p>
          Please fill out the form below to sign up and start saving and earning more money with textbooks!
          </p>
          
           <button id="fb-login" onclick="login()">Log in</button>
           <button id="fb-logout" onclick="logout()">Log out</button>
          <div class="fb-login-button" data-show-faces="true" data-width="200" data-max-rows="1"></div>
          
          <form id="register" name="register" action="User/CompleteSignUp.php"
            method="post" onsubmit="return validateRegistrationForm();">
            <fieldset>
            <legend><strong>Personal Information</strong></legend>
            
            <table summary="Registration Form">
              <tr valign="top">
                <td>First Name:</td>
                <td><input  id="firstName" type="text" name="firstName" size="40" placeholder="(Required)" value="<?PHP echo $user_profile['first_name']; ?>" /></td>
              </tr>
              <tr valign="top">
                <td>Middle Name:</td>
                <td><input  id="middleInitial" type="text" name="middleInitial" size="40" placeholder="(Optional)" /></td>
              </tr>
              <tr valign="top">
                <td>Last Name:</td>
                <td><input  id="lastName" type="text" name="lastName" size="40" placeholder="(Required)" value="<?PHP echo $user_profile['last_name']; ?>" /></td>
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
                <td><input id="email" type="text" name="email" size="40" value="<?PHP echo $user_profile['username'].'@facebook.com'; ?>" /></td>
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

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>

