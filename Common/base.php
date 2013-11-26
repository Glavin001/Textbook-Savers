<!-- Base tag -->
<base href="http://cs.smu.ca/~g_wiechert/TextbookSavers/">
<!-- Common Styles -->
<link rel="stylesheet" type="text/css" href="Styles/default.php">
<link rel="stylesheet" type="text/css" href="Styles/nav.php">
<!-- jQuery -->
<script src="Scripts/jquery-1.8.3.min.js" ></script>
<script src="Scripts/jquery-ui-1.9.2.custom.min.js" ></script>
<!-- Common Scripts -->
<script src="Scripts/common.js" ></script>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?PHP 
// include 'bootstrap.php'; 
?>

<script>

$(function () {

  var refreshInterval = 10000;
  var highlightDuration = 1000;
  var refreshNotificationCount = function (overwrite) { 
  //console.log("Refreshing conversation");
  var currUserId = "<?PHP echo $_SESSION['UserId']; ?>";
  if (currUserId != "")
  {
    $.ajax({
      type: "POST",
      url: "Scripts/getAllConversations.php",
      data: { unreadCount: true },
      dataType: "json"
      }).done(function( JSONobject ) {
        if (JSONobject.loggedIn == "True")
        {
          if (overwrite || ( parseInt( $("#notificationCounter1").html() ) != parseInt(JSONobject.unreadCount) ))
          {
            if (parseInt(JSONobject.unreadCount) < parseInt( $("#notificationCounter1").html() ) )
            {
              animatedCounter(document.getElementById("notificationCounter1"), 0, parseInt(JSONobject.unreadCount), -1, null, 200, function(){ });
            }
            else
            {
              animatedCounter(document.getElementById("notificationCounter1"), 0, parseInt(JSONobject.unreadCount), 1, null, 200, function(){ });
            }
            //$(".notificationCount").html( data );
            $("#notificationCounter1").effect("highlight", {}, highlightDuration);    
          }
          else
          {
          
          }
        }      
        else
        {
          location.reload();
        }
      }); 
      
    }
    else
    {
      $.ajax({
      type: "POST",
      url: "Scripts/getAllConversations.php",
      data: { unreadCount: true },
      dataType: "json"
      }).done(function( JSONobject ) {
        if (JSONobject.loggedIn == "True")
        {
          location.reload();        
        }      
        else
        {

        }
      }); 
      
    }
    
  } 
  refreshNotificationCount(true);
  setInterval(refreshNotificationCount, refreshInterval);

});

</script>