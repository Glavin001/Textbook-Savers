<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"
      xmlns:fb="https://www.facebook.com/2008/fbml"> 
<head>
  <title>Test Facebook Post</title>
</head>
<body>
  <div id="fb-root"></div>
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '491456304233582', // App ID
        status     : true, // check login status
        cookie     : true, // enable cookies to allow the server to access the session
        xfbml      : true  // parse XFBML
      });
    };

    // Load the SDK Asynchronously
    (function(d){
      var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
      js = d.createElement('script'); js.id = id; js.async = true;
      js.src = "//connect.facebook.net/en_US/all.js";
      d.getElementsByTagName('head')[0].appendChild(js);
    }(document));
  </script>

  <fb:login-button show-faces="false" width="200" max-rows="1" scope="publish_actions">
  </fb:login-button>

</body>
</html>

<!--<script type="text/javascript">
 <fb:login-button show-faces="true" width="200" max-rows="1" scope="publish_actions">
function read()
{
FB.api(‘/me/Your_Namespace:action‘ + 
‘?object=Yoursite.com/test.html&access_token=Paste the access token copied in step 3‘,’post’,
function(response) {
var msg = ‘Error occured’;
if (!response || response.error) {
if (response.error) {
msg += "\n\nType: "+response.error.type+"\n\nMessage: "+response.error.message;
}
alert(msg);
} 
else {
alert(‘Post was successful! Action ID: ‘ + response.id);
}
});
}
</script>

</head>

<body> 
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
FB.init({ 
appId:’491456304233582‘, cookie:true, 
status:true, xfbml:true, oauth:true
});
</script>
<form>
<input type="button" value="Post To Your Timeline " onclick="read()" />
</form>
</body> 
</html>