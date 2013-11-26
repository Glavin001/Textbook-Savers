<?PHP
session_start(); 

// Date in the past
header("Expires: Wed, 1 Dec 1993 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$updateIdentifier = "";

$resultData = array();

require_once 'common.php';
require_once 'db.php';



if (isset($_SESSION['UserId']))
{
  $resultData['loggedIn'] = "True";

  if ($_POST['unreadCount'] == 'true')
  {
  
    $sql = "SELECT MessageId, 
    CONCAT(LEAST(FromId,ToId),GREATEST(FromId,ToId)) AS ConversationId, FromId, ToId, MIN(ReadStatus), Timestamp FROM Message 
    WHERE  ( ReadStatus='0' OR ReadStatus='1' ) AND
    ( ToId='".mysql_real_escape_string(strip_tags($_SESSION['UserId']))."' )
    GROUP BY ConversationId ORDER BY ReadStatus ASC, Timestamp DESC;";
    
    $messagesResult = mysql_query($sql) or die(mysql_error());
    $unreadCount = mysql_num_rows($messagesResult);
    $resultData['unreadCount'] = $unreadCount;
    //$resultData['HTML'] = $unreadCount;
    $resultData['updateIdentifier'] = $unreadCount;
    //echo $unreadCount;
    
  }
  else
  {
    
    $resultData['HTML'] = '<div id="allConversations">';
    
    $sql = "SELECT MAX(IF(ReadStatus='0',MessageId,0)) AS MessageId, 
    CONCAT(LEAST(FromId,ToId),GREATEST(FromId,ToId)) AS ConversationId, FromId, ToId, 
    MIN( IF( `ToId` != '".mysql_real_escape_string(strip_tags($_SESSION['UserId']))."', 2 , ReadStatus ) ) AS ReadStatus, MAX(Timestamp) FROM Message 
    WHERE ( FromId='".mysql_real_escape_string(strip_tags($_SESSION['UserId']))."' 
    OR ToId='".mysql_real_escape_string(strip_tags($_SESSION['UserId']))."'
    ) GROUP BY ConversationId ORDER BY ReadStatus ASC, MAX(Timestamp) DESC;";
    
    $messagesResult = mysql_query($sql);
    while ( list($MessageId, $ConversationId, $FromId, $ToId, $ReadStatus, $Timestamp) = mysql_fetch_row($messagesResult) )
    {
      $updateIdentifier .= $MessageId.":".$Timestamp.":".$ReadStatus.","; 
      
      $recipientUser = getUser($ToId);
      $senderUser = getUser($FromId);
      if ($_SESSION['UserId'] == $FromId)
      {
        // Sent from current User
        
        $resultData['HTML'] .= '<a name="User'.$ToId.'" href="User/Messages.php?uid='.$recipientUser['UserId'].'">';
        //echo $Timestamp; 
        $resultData['HTML'] .= '<span class="convo '.(($ReadStatus != 2)? "unread" : "read").'">';
        $resultData['HTML'] .= $recipientUser['FirstName'].(($recipientUser['MiddleName'] != "")?" ".($recipientUser['MiddleName'])." ":" ").$recipientUser['LastName'];
        $resultData['HTML'] .= '</span>';
        $resultData['HTML'] .= '<small>'. "Last message at " . date("F j, Y g:i a", strtotime($Timestamp)) .'</small>';
        $resultData['HTML'] .= '</a>';    
      }
      else
      {
        // Sent to current user
        $resultData['HTML'] .=  '<a name="'.$FromId.'" href="User/Messages.php?uid='.$senderUser['UserId'].'">';
        //echo $Timestamp; 
        $resultData['HTML'] .= '<span class="convo '.(($ReadStatus != 2)? "unread": "read").'">';
        $resultData['HTML'] .= $senderUser['FirstName'].(($senderUser['MiddleName'] != "")?" ".($senderUser['MiddleName'])." ":" ").$senderUser['LastName'];
        $resultData['HTML'] .= '</span>';
        $resultData['HTML'] .= '<small>'. "Last message at " . date("F j, Y g:i a", strtotime($Timestamp)) .'</small>'; 
        $resultData['HTML'] .= '</a>';
      }
      
    }
    
    
    $resultData['updateIdentifier'] = $updateIdentifier;
    $resultData['HTML'] .= '</div>';
    
  }
  
  echo json_encode($resultData);  
}
else
{
  
  $resultData['loggedIn'] = "False";
  $resultData['unreadCount'] = 0;
  $resultData['HTML'] = 'Please login.';
  $resultData['updateIdentifier'] = $updateIdentifier;
  
  echo json_encode($resultData);

}


?>