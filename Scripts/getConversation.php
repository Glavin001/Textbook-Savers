<?PHP

session_start(); 

// Date in the past
header("Expires: Wed, 1 Dec 1993 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$updateIdentifier = "";

?>

<div id="conversation">

<?PHP
require_once 'common.php';
require_once 'db.php';

if (isset($_SESSION['UserId']))
{
  
  $recipientId = $_POST['uid'];
  
  $sql = "SELECT MessageId, FromId, ToId, MessageContent, ReadStatus, UNIX_TIMESTAMP(Timestamp) FROM Message 
  WHERE ( FromId='".mysql_real_escape_string(strip_tags($_SESSION['UserId']))."' 
  AND ToId='".mysql_real_escape_string(strip_tags($recipientId))."'
  ) OR (
  ToId='".mysql_real_escape_string(strip_tags($_SESSION['UserId']))."' 
  AND FromId='".mysql_real_escape_string(strip_tags($recipientId))."'
  ) ORDER BY Timestamp ASC;";
  $messagesResult = mysql_query($sql);
  
  $lastUserId = NULL;
  $lastTimestamp = NULL;
  $maxMessageInterval = 5*60; // 24*60*60; // in seconds
  
  while ( list($MessageId, $FromId, $ToId, $messageContent, $ReadStatus, $Timestamp) = mysql_fetch_row($messagesResult) )
  {
    $updateIdentifier .= $MessageId.",";
    $recipientUser = getUser($ToId);
    $senderUser = getUser($FromId);
    
    $currTimestamp = new DateTime();
    $currTimestamp->setTimestamp($Timestamp);
    
    if (($lastUserId != $FromId) || ($lastTimestamp != NULL && ($Timestamp - $lastTimestamp) > $maxMessageInterval))
    {  
    // New User messaging
      if ($lastUserId != NULL) { echo "</div>"; } // End message block from last User
    ?>
    <div class="message timestamp">
    <hr />
    <a name="<?PHP echo $MessageId; ?>" href="User/Messages.php?uid=<?PHP echo $recipientId; ?>#<?PHP echo $MessageId; ?>" >
    <?PHP 
    //echo $lastTimestamp." - ".$Timestamp." = ".($Timestamp - $lastTimestamp);
    //echo date('M jS, Y g:i A [e]', $Timestamp); 
    echo date('M jS, Y g:i A', $Timestamp); 
    ?>
    </a>
    </div>
    <div class="message <?PHP echo ($_SESSION['UserId'] == $FromId)?"currentUser":"otherUser"; ?>">
    <span>
      <?PHP
      $messageContent = emotify(nl2br(stripcslashes($messageContent)));

      echo ($messageContent);
      ?>
    </span>
    <?PHP  
    }
    else
    {  
    // Same user messaging
    ?>
    <span>
      <?PHP
      $messageContent = emotify(nl2br(stripcslashes($messageContent)));
      echo ($messageContent);
      ?>
    </span>
    <?PHP  
    }
    $lastUserId = $FromId;
    $lastTimestamp = $Timestamp;

  }


if ( $_POST['isReading'] )
{
  $query = "UPDATE Message SET ReadStatus='2' 
  WHERE (
  ( FromId='".mysql_real_escape_string(strip_tags($_SESSION['UserId']))."' 
  AND ToId='".mysql_real_escape_string(strip_tags($recipientId))."'
  ) OR (
  ToId='".mysql_real_escape_string(strip_tags($_SESSION['UserId']))."' 
  AND FromId='".mysql_real_escape_string(strip_tags($recipientId))."'
  )
  )
  AND ( FromId='".mysql_real_escape_string(strip_tags($recipientId))."' )
  ;";
     $result = mysql_query($query) or die(mysql_error());
}


}
else
{
?>
Please login.
<?PHP
}
?>      

<!-- Used to verify if catalog has changed. -->
<input type="hidden" class="updateIdentifier" value="<?PHP echo $updateIdentifier; ?>"/>

</div>