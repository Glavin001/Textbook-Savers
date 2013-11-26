<?php 
session_start(); 
require 'Scripts/db.php'; 
require 'Scripts/common.php';
require 'Common/base.php'; 
include 'Common/meta.php';
require ('Scripts/facebook-php-sdk/src/facebook.php');
$facebook = new Facebook(array(
  'appId'  => '491456304233582',
  'secret' => 'b45471665c2327a933a9de4abb3c8031',
));
$user = $facebook->getUser();
echo $user;
?>

<html xmlns="http://www.w3.org/1999/xhtml"
  xmlns:fb="https://www.facebook.com/2008/fbml">
  <head>
    <title>Request Example</title>
  </head>

  <body>
    <div id="fb-root"></div>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
    <p>
      <input type="button"
        onclick="sendRequestToRecipients(); return false;"
        value="Send Request to Users Directly"
      />
      <input type="text" value="<?= $user ?>" name="user_ids" />
			
      </p>

    
    <script>
      FB.init({
        appId  : '491456304233582',
        frictionlessRequests: true
      });

      function sendRequestToRecipients() {
        var user_ids = document.getElementsByName("user_ids")[0].value;
        FB.ui({method: 'apprequests',
          message: 'Someone wants to buy your book!',
          to: user_ids
        }, requestCallback);
      }
      
      function requestCallback(response) {
        // Handle callback here
      }
    </script>
  </body>
</html>
