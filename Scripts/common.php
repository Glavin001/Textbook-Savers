<?PHP

// MySQL Functions
function getTableRow($table, $whereStatement)
{
  $sql = "SELECT * FROM ".$table." WHERE ".$whereStatement." LIMIT 0,1;";
  $result = mysql_query($sql);
  $row = mysql_fetch_assoc($result);
  return $row;
}
function getUser($id)
{
  return getTableRow("User","UserId='".$id."'");
}
function getTextbook($id)
{
  return getTableRow("Textbook","TextbookId='".$id."'");
}
function getCourse($id)
{
  return getTableRow("Course","CourseId='".$id."'");
}
function getSubject($id)
{
  return getTableRow("Subject","SubjectId='".$id."'");
}
function getSale($id)
{
  return getTableRow("Sale","SaleId='".$id."'");
}


// Misc Functions
function startsWith($haystack, $needle)
{
    return !strncmp($haystack, $needle, strlen($needle));
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

/**
* Function code source: http://www.phpro.org/examples/URL-to-Link.html
* Function to make URLs into links
* @param string The url string
* @return string
**/
function makeLink($string)
{
/*** make sure there is an http:// on all URLs ***/
$string = preg_replace("/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i", "$1http://$2",$string);
/*** make all URLs links ***/
$string = preg_replace("/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i","<a target=\"_blank\" href=\"$1\">$1</A>",$string);
/*** make all emails hot links ***/
$string = preg_replace("/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i","<A HREF=\"mailto:$1\">$1</A>",$string);
return $string;
}

function emotify($str)
{
  $newStr = $str;
  $emoticons = array(
  'rick roll' => 'emoticonLarge emoticon_rickRolled',
  'duude'=>'emoticonLarge emoticon_YES',
  'NO!'=>'emoticonLarge emoticon_NO',
  ':)'=>'emoticonSmall emoticon_smile',
  ':('=>'emoticonSmall emoticon_frown', 
  ':\'('=>'emoticonSmall emoticon_cry',
  ';)'=>'emoticonSmall emoticon_wink',
  ':P'=>'emoticonSmall emoticon_tongue',
  ':p'=>'emoticonSmall emoticon_tongue',
  ':O'=>'emoticonSmall emoticon_gasp',
  ':o'=>'emoticonSmall emoticon_gasp',
  ':D'=>'emoticonSmall emoticon_grin',
  ':d'=>'emoticonSmall emoticon_grin',
  '(Y)'=>'emoticonSmall emoticon_like',
  '(y)'=>'emoticonSmall emoticon_like'
  );
  foreach ($emoticons as $key=>$value)
  {
    $newStr = str_replace("$key","<span class=\"".$value."\"></span>",$newStr);
  }
  return $newStr;
}

function url_get_contents($Url) 
{
  if (!function_exists('curl_init')){ 
  die('CURL is not installed!');
  }
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $Url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $output = curl_exec($ch);
  curl_close($ch);
  return $output;
}

function getGoogleBookData($ISBN)
{
  $sql = "SELECT * FROM Textbook WHERE ISBN13='".mysql_real_escape_string(strip_tags($ISBN))."' OR ISBN10='".mysql_real_escape_string(strip_tags($ISBN))."' LIMIT 0,1;";
  $result = mysql_query($sql);
  $textbookFromDatabase = mysql_fetch_assoc($result);
  
  if (is_null($textbookFromDatabase['GoogleBooksData']))
  {
    //echo "No database cached.";
    $jsonurl = "https://www.googleapis.com/books/v1/volumes?q=isbn:".$ISBN."&key=AIzaSyCnMoqGsZpKt_0tY6QfQOW5L7lvU9DiC9s";    
    //echo $jsonurl;
    $json = url_get_contents($jsonurl);
    //  echo "<pre>".$json."</pre>";

    $json_output = json_decode($json, true);
    $textbookurl = $json_output['items'][0]['selfLink'];
    $textbookurl .= "?key=AIzaSyCnMoqGsZpKt_0tY6QfQOW5L7lvU9DiC9s";
    $json = url_get_contents($textbookurl);  
    
    $sql = "UPDATE Textbook SET GoogleBooksData='".mysql_real_escape_string(strip_tags($json))."' WHERE TextbookId='".mysql_real_escape_string(strip_tags($textbookFromDatabase['TextbookId']))."';";
    $result = mysql_query($sql);

  }
  else
  {
    //echo "Already cached";
    $json = $textbookFromDatabase['GoogleBooksData'];
  }
  //echo "<pre>".$json."</pre>";
  $bookData = json_decode($json, true);
  
  return $bookData;
  
}




/* ===== Messager API ===== */

function sendMessage($FromUserId, $ToUserId, $messageOptions, $replyOptions)
/*
Brief description:
Sends message through all enabled mediums of ToUser, such as Email, Facebook, SMS.

Example Usage:
sendMessage(1, 2, array( 'plaintext' => "Without formatting.", 'HTML' => "<strong>With HTML Formatting</strong>" ), array( 'Facebook' => true, 'Email' => true, 'Phone' => true ) );

Parameters:
- $FromUserId => integer

- $ToUserId => integer

- $messageOptions => { associative array }
  -- 'plaintext' => string
    This is the plaintext format of the message. Used for sending messages to Facebook messenger and to phone via SMS.
  -- 'HTML' => string
    This is the HTML format of the message. Used for sending messages email and other mediums that allow HTML.  
  -- 'Widget' => Object / Associative Array
    This is the parameters for a custom widget to send. Such examples are sending Map widgets and I-Want-This widgets.
- $replyOptions => array( associative array )
  -- 'Facebook' => boolean
      If true then allow ToUser to see FromUser's Facebook usernames / profile link, else do not.
  -- 'Email' => boolean
      If true then allow ToUser to see FromUser's email, else do not.
  -- 'Phone' => boolean
      If true then allow ToUser to see FromUser's Phone number, else do not.
      
*/
{
  
  // Get User Information
  $FromUser = getUser($FromUserId);
  $ToUser = getUser($ToUserId);
  
  return array(
  // Internal Message
  sendInternalMessage($FromUser, $ToUser, $messageOptions['plaintext']),
  // Email
  sendEmail($FromUser, $ToUser, $messageOptions, "Message from a Textbook Saver!", NULL),
  // Facebook
  sendFacebookMessage($FromUser, $ToUser, $messageOptions['plaintext']),
  // Facebook Notification
  //// sendFacebookNotification($FromUser, $ToUser, $message);
  // SMS 
  sendSMS($FromUser, $ToUser, $messageOptions['plaintext']),
  "Done"
  );
  //return true; // Successful
}

function sendInternalMessage($FromUser, $ToUser, $messagePlaintext)
{
  if ($messagePlaintext != "" || $messagePlaintext != NULL)
  {    
    $query = "INSERT INTO Message (
        MessageId, FromId, ToId,
        MessageContent
    )
    VALUES (
        NULL, '".mysql_real_escape_string(strip_tags($FromUser['UserId']))."', '".
        mysql_real_escape_string(strip_tags($ToUser['UserId']))."', '". 
        mysql_real_escape_string($messagePlaintext)."');";
    $result = mysql_query($query) or die(mysql_error()); 
    return true;
  }
  else
  {
    return false;
  }
}

function sendFacebookMessage($FromUser, $ToUser, $messagePlaintext)
{
  if ($ToUser['FacebookUsername'] != NULL) 
    $ToEmail = $ToUser['FacebookUsername']."@facebook.com";
  else if (endsWith($ToUser['EmailAddress'],"@facebook.com")) 
    $ToEmail = $ToUser['EmailAddress'];
  else
    return false;
  $subject = "";
  $headers = "From: ".$FromUser['FirstName']." ".$FromUser['LastName']." <".$FromUser['EmailAddress'].">\r\n";
  return sendEmail($FromUser, array('EmailAddress'=>$ToEmail), array('plaintext'=>strip_tags($messagePlaintext)), $subject, $headers);
  // return array($FromUser, array('EmailAddress'=>$ToEmail), array('plaintext'=>strip_tags($messagePlaintext)), $subject, $headers);
}

function sendFacebookNotification($FromUser, $ToUser, $message)
{
  return false;
}

function sendEmail($FromUser, $ToUser, $messageOptions, $subject, $headers)
{
  if (!isset($headers) || $headers == NULL)
  {
    $headers = "From: ".$FromUser['FirstName']." ".$FromUser['LastName']." <".$FromUser['EmailAddress'].">\r\n";
    //$headers = "From: " . strip_tags($FromUser['EmailAddress']) . "\r\n";
    $headers .= "Reply-To: ". strip_tags($FromUser['EmailAddress']) . "\r\n";
    $headers .= "CC: ". strip_tags($FromUser['EmailAddress']) ."\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    if (isset($messageOptions['HTML']))
    {
      $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
      $message = $messageOptions['HTML'];
    }
    else
    {
      $headers .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";    
      $message = $messageOptions['plaintext'];
    }
  }
  else
  {
    if (isset($messageOptions['HTML']))
    {
      $message = $messageOptions['HTML'];
    }
    else
    {
      $message = $messageOptions['plaintext'];
    }
  }
  if (!isset($subject) || $subject == NULL ) $subject = "Message from Textbook Savers"; 
  return mail($ToUser['EmailAddress'], $subject, $message, $headers);
  //return array($ToUser['EmailAddress'], $subject, $message, $headers);
  //return true;
}

function sendSMS($FromUser, $ToUser, $messagePlaintext)
{
  if ($ToUser['SMSEmail'] != NULL) 
    $ToEmail = $ToUser['SMSEmail']."";
  else
    return false;
  $headers = "";
  if ($FromUser['EmailAddress'] != NULL) 
    $headers = "From: ".$FromUser['FirstName']." ".$FromUser['LastName']." <".$FromUser['EmailAddress'].">";
  else 
    $headers = "";
  $subject = "Message from Textbook Savers";
  $pieceLength = 160 - (strlen($subject) + 0);
  if (false) // strlen($messagePlaintext) > $pieceLength)
  {
    $messagePieces = str_split(strip_tags($messagePlaintext), $pieceLength);
    for($p=0; $p<count($messagePieces); $p++) 
    {
      $subject = "Message ".($p+1)." of ".count($messagePieces)." from Textbook Savers";
      sendEmail($FromUser, array('EmailAddress'=>$ToEmail), array('plaintext'=>$messagePieces[$p]), $subject, $headers);
    }
    return true;
    //return array( $FromUser, array('EmailAddress'=>$ToEmail), $messagePieces, $subject, $headers );  
  }
  else
  {
    return sendEmail($FromUser, array('EmailAddress'=>$ToEmail), array('plaintext'=>strip_tags($messagePlaintext)), $subject, $headers);
    //return array( $FromUser, array('EmailAddress'=>$ToEmail), array('plaintext'=>strip_tags($messagePlaintext)), $subject, $headers );
  }
  return true;
}

/* ===== Generate Widgets ===== */
function iWantWidget($SaleId, $FromUser, $message)
{
  $Sale = getSale($SaleId);
  $Textbook = getTextbook($Sale['TextbookId']);
  $Course = getCourse($Textbook['CourseId']);
  $Subject = getSubject($Course['SubjectId']);
  
  $widget = "<hr />";
  $widget .= "<div class=\"iWantWidget\">";
  $widget .= "<div class=\"widgetTitle\">Request for Textbook</div>";  
  
  if (isset($FromUser['FacebookUsername']) && ($FromUser['FacebookUsername'] != NULL || $FromUser['FacebookUsername'] != "")) 
    $widget .= "<img src=\"http://graph.facebook.com/".$FromUser['FacebookUsername']."/picture/\" alt=\"User's Facebook profile photo\" />";
  $widget .= $FromUser['FirstName'].(isset($FromUser['MiddleName'])?" ".$FromUser['MiddleName']." ":"").$FromUser['LastName']; 
  
  $widget .= "<div>";
  $widget .= $Textbook['Title'].(($Textbook['Edition']>1)?" (Edition ".$Textbook['Edition'].")":"")." by ". $Textbook['Author'] ."<br />".
      $Subject['ShortTitle']." ".$Course['CourseNumber']." - ".$Course['Title']; 
  $widget .= "</div>";
  /*
  $widget .= 
  "Dear ".$sellerUser['FirstName']." " 
	        .$sellerUser['LastName'].",\r\n\r\n" 
	.$buyerUser['FirstName']." ".$buyerUser['LastName']." is interested in purchasing your textbook: ".$textbook['Title']."\r\n\r\n" .
	"".$buyerUser['FirstName']." can be contacted via:\r\n" .
	((IsChecked("contact","PhoneNumber"))?"Phone Number: " .$buyerUser['PhoneNumber']. "\r\n" : "" ).
	((IsChecked("contact","FacebookUsername"))?"Facebook Email: " .$buyerUser['FacebookUsername']. "@facebook.com\r\n" : "").
	((IsChecked("contact","EmailAddress"))?"Email Address: " .$buyerUser['EmailAddress']."\r\n" : "" );
	if ($_POST['message'] == '')
	{}
	else
	{	
	$messageToSelf .= "Message: ".$_POST['message']."\r\n";
	}
	*/
	
  $widget .= "<div class=\"messageContents\">".$message."</div>";  
  $widget .= "</div>";
  return $widget;
}


?>