<?php 
session_start(); 
require_once '../Scripts/db.php';
require_once '../Scripts/common.php';

?>

<!DOCTYPE html>
<html>

<head>
<title>Messages</title>

<?PHP 
require '../Common/base.php'; 
include '../Common/meta.php';
$recipientId = $_GET['uid'];
?>

<link rel="stylesheet" type="text/css" href="Styles/messenger.php">

<script src="Scripts/search.js"></script>
<script src="Scripts/common.js"></script>


<script>

$(document).ready(function() {
    var bodyheight = $(window).height() - 270;
    $("#conversation").height(""+bodyheight+"px");//.delay(3000).height(""+($(window).height())+"px");
    console.log(bodyheight);

  $('#inputMessage').bind("enterKey",function(e){
   // Send message!
   if ($("#enterToSend").is(':checked'))
   {
      $("#sendButton").click();
      //console.log("Sent message!");
    }
  });
  $('#inputMessage').keyup(function(e){
  if(e.keyCode == 13)
  {
    $(this).trigger("enterKey");
  }
  });
  
  // Load & Save settings
  var messageStorageName = "messageToUser<?PHP echo $recipientId; ?>";
  var currentMessageContents = getLocalStorage(messageStorageName);
  $("#inputMessage").val( currentMessageContents );
  $("#inputMessage").keyup( function () {
    setLocalStorage(messageStorageName,$(this).val());
  });
  var currentCheckedState = getLocalStorage("enterToSend");
  //$("#enterToSend").prop('checked', currentCheckedState);
  if ($("#enterToSend").length > 0) document.getElementById("enterToSend").checked = ((currentCheckedState=="false")?false:true);
  $('#enterToSend').click(function ()
  {
    // if (thischeck.is (':checked')) { }
    var currentCheckedState = $(this).is(':checked');
    //console.log(currentCheckedState);
    //currentCheckedState = ((currentCheckedState==true)?true:false);
    console.log(currentCheckedState);
    setLocalStorage("enterToSend", currentCheckedState);
    });    
  });

// for the window resize
$(window).resize(function() {    
    var bodyheight = $(window).height() - 270;
    $("#conversation").height(""+bodyheight+"px");
    console.log(bodyheight);
});

window.blinkTitleId = null;
window.refreshConversation = null;
window.isFocused = true; 
$(function(window) {
    $(window).focus(function() {
        console.log('Focus: '+window.blinkTitleId);
        window.isFocused = true;
        clearInterval(parseInt(window.blinkTitleId));
        document.getElementsByTagName("title")[0].innerHTML = "Messages";
        window.refreshConversation();
    });

    $(window).blur(function() {
        //console.log('Blur');
        window.isFocused = false;
    });
}(window));

</script>

</head>

<body>

<header>
<?PHP require '../Common/header_menu.php'; ?>
</header>

<div class="page">

<?PHP

if (isset($_SESSION['UserId']))
{
  
  ?>
  
  <div id="otherContacts">
    <span id="toggleContacts">Show Contacts</span>
    <div id="allConversations">
    All conversations.
    </div>
  </div>
  
  <script>
  $("#toggleContacts").click( function () {
    var contacts = $("#allConversations");
    if (contacts.height() == 0)
    {
      console.log("Showing contacts!");
      contacts.height("50%");
      $(this).html("Click to Hide Contacts");
    }
    else
    {
      console.log("Hiding contacts!");
      contacts.height("0");
      $(this).html("Click to Show Contacts");
    }
  });
  /*
  $("#otherContacts").hover( 
    function () 
    {
      var contacts = $("#allConversations");
      console.log("Showing contacts!");
      contacts.height("50%");
      $(this).html("Showing Contacts");    
    },
    function () 
    {
      var contacts = $("#allConversations");
      console.log("Hiding contacts!");
      contacts.height("0");
      $(this).html("Hiding Contacts");
    }
  );
  */
  </script>
  
<br />
<hr />
<br />

  <script>
  var refreshInterval = 5000;
  var highlightDuration = 1000;
  window.refreshAllConversations = function (overwrite) { 
  //console.log("Refreshing textbookCatalog");
  $.ajax({
    type: "POST",
    url: "Scripts/getAllConversations.php",
    data: { },
    dataType: "json"
    }).done(function( JSONobject ) {
      //if (overwrite || ($("#allConversations").find(".updateIdentifier").val() != $(data).find(".updateIdentifier").val()))
      console.log(JSONobject);
      if (overwrite || ( $("#allConversations").html() != $(JSONobject.HTML).html() ) )
      {
        //$("#allConversations").replaceWith( $(data) );
        $("#allConversations").html( $(JSONobject.HTML).html() );
        $("#allConversations").effect("highlight", {}, highlightDuration);    
      }
      else
      {
        console.log("Not updating");
      }
      
    }); 
  } 
  window.refreshAllConversations(true);
  setInterval(window.refreshAllConversations, refreshInterval);
  </script>


<?PHP
  
  if (isset($recipientId))
  {
  // Selected 
  $recipientUser = getUser($recipientId);

  ?>
  
  <!--
  <a href="User/Messages.php"><<-Back to All Messages-<<</a>
  <br /><br />
  -->
  <div class="selectedMessage">
  
  <a href="Info/User.php?uid=<?PHP echo $recipientUser['UserId']; ?>" class="recipient">
  <?PHP 
  if (isset($recipientUser['FacebookUsername']) && ($recipientUser['FacebookUsername'] != NULL || $recipientUser['FacebookUsername'] != "")) echo "<img src=\"http://graph.facebook.com/".$recipientUser['FacebookUsername']."/picture/\" alt=\"User's Facebook profile photo\" />";
  echo $recipientUser['FirstName'].(($recipientUser['MiddleName'] != "")?" ".($recipientUser['MiddleName'])." ":" ").$recipientUser['LastName']; 
  ?>
  </a>
  <div id="conversation">
  Have a conversation!
  </div>
  
  <textarea id="inputMessage" placeholder="Type your message here."></textarea>
  <input type="button" id="sendButton" value="Send" />
  <label for="enterToSend">Press Enter to Send</label> <input type="checkbox" id="enterToSend" checked="checked" />
  </div>
  
  <script>
  var refreshInterval = 10000;
  var highlightDuration = 1000;
  window.refreshConversation = function (overwrite) { 
  //console.log("Refreshing conversation");
  $.ajax({
    type: "POST",
    url: "Scripts/getConversation.php",
    data: { uid: <?PHP echo $recipientId; ?>, isReading: window.isFocused },
    dataType: "html"
    }).done(function( data ) {
      //if ($("#textbookCatalog").html() != data)
      if (overwrite || ($("#conversation").find(".updateIdentifier").val() != $(data).find(".updateIdentifier").val()))
      {
        //$("#conversation").replaceWith( $(data) );
        $("#conversation").html( $(unescape(data)).html() );
        $("#conversation").effect("highlight", {}, highlightDuration);    
        
        $(function() {
          var height = $('#conversation')[0].scrollHeight;
          $('#conversation').scrollTop(height);
        });
        
        clearInterval(window.blinkTextId);
        if (!window.isFocused) 
        {
          window.blinkTitleId = setInterval( function () { blinkText( document.getElementsByTagName("title")[0], "(1) New Message", "Messages", "Messages" ) } ,3000);
          console.log("ID: "+window.blinkTitleId+"\n"+"Window is not focused so change title to get user's attention!");
        }
        else
        {
          console.log("Window is focused:"+window.isFocused);
        }
      }
      else
      {
        //console.log("Not updating");
        //console.log(data);
        //console.log( $("#conversation").find(".updateIdentifier").val() );
        //console.log( $(data).find(".updateIdentifier").val() );
      }
      //console.log( $("#conversation").find(".updateIdentifier").val() );
      //console.log( $(data).find(".updateIdentifier").val() );
      //console.log( $(data) );
      
    }); 
            
  } 
  window.refreshConversation(true);
  setInterval(window.refreshConversation, refreshInterval);
  
  
  $("input#sendButton").click(function() {
    var message = $("textarea#inputMessage").val();
    //console.log(nonStripped);
    //message = message.replace(/(<([^>]+)>)/ig,"");
    //console.log(strippedString);
    message = htmlEntities(message);
    
    $.ajax({
      type: "POST",
      url: "Scripts/sendMessage.php",
      data: { ToId: <?PHP echo $recipientId; ?>, messageContent: message },
      dataType: "html"
      }).done(function( data ) {
        //console.log(data);
        $("textarea#inputMessage").val("");
        window.refreshConversation(true);
        var messageStorageName = "messageToUser<?PHP echo $recipientId; ?>";
        setLocalStorage(messageStorageName,"");
      
    });
    
    });
  
  </script>

  <?PHP
  }
  else
  {
  // Have not selected a Recipient yet.
  // Display all available messages and recipients.
  ?>
  
  <!--
  <div id="allConversations" style="width=100%;">
  All conversations.
  </div>
  -->
  
  <script>
  
  var contacts = $("#allConversations");
  console.log("Showing contacts!");
  contacts.height("50%");
  $("#toggleContacts").html("Please select someone to message");
  
  var refreshInterval = 5000;
  var highlightDuration = 1000;
  window.refreshAllConversations = function (overwrite) { 
  //console.log("Refreshing textbookCatalog");
  $.ajax({
    type: "POST",
    url: "Scripts/getAllConversations.php",
    data: { },
    dataType: "json"
    }).done(function( JSONobject ) {
      //if (overwrite || ($("#allConversations").find(".updateIdentifier").val() != $(data).find(".updateIdentifier").val()))
      console.log(JSONobject);
      if (overwrite || ( $("#allConversations").html() != $(JSONobject.HTML).html() ) )
      {
        //$("#allConversations").replaceWith( $(data) );
        $("#allConversations").html( $(JSONobject.HTML).html() );
        $("#allConversations").effect("highlight", {}, highlightDuration);    
      }
      else
      {
        console.log("Not updating");
      }
      
    }); 
  } 
  window.refreshAllConversations(true);
  setInterval(window.refreshAllConversations, refreshInterval);
  </script>

  
  <?PHP
  }

}
else
{
  // No logged in yet.
  ?>
  You are not logged in yet. Please login first.
  <?PHP
}
?>

</div>

<footer>
<?PHP require '../Common/footer_menu.php'; ?>
</footer>

</body>
</html>

