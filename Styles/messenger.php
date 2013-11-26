<?php 
header("Content-type: text/css"); 
require 'theme.php';
?>

a.recipient
{
  margin: 5px;
  font-weight: bold;
  text-align: center;
}

/* === Display All Conversations / Contacts === */

span#toggleContacts
{
  margin: 5px;
  font-weight: bold;
  font-size: 1.5em;
}

div#allConversations
{
  padding: 5px;
  width: 100%;
  height: 0em;
  overflow: scroll;
}

div#allConversations:hover
{
  height: 50%;
}

div.page {
  overflow: hidden;
}

div#allConversations a 
{
  display: block;
  margin: 5px;
}

div#allConversations span.convo
{
  margin: 5px;
/*  padding: 5px; */
}

div#allConversations a:hover
{
  background-color: rgba(0,0,0,0.1);
}

div#allConversations span.convo.read
{
  color: blue;
}

div#allConversations span.convo.unread
{
  color: red;
}

div#allConversations span.convo.unread:after
{
  content: " (Unread)";
}

/* === Private Conversation === */
div.selectedMessage 
{
  float: left;
  margin: 5px 5px 5px 5px;
  width: 100%;
  
  -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	-moz-box-sizing: border-box;    /* Firefox, other Gecko */
	box-sizing: border-box;         /* Opera/IE 8+ */

}

div.selectedMessage .recipient
{
  font-size: 2em;
  /* background-color: rgba(0,0,255,0.1); */
  color: blue;
}

div#conversation 
{
/*
  float: left;
  margin: 5px 5px 5px 5px;
*/
/*  padding: 5px; */
  overflow: scroll;
  height: 300px;
  background-color: white;
  border: 1px solid gray;
  width: 99%;
  
  transition:height 1s;
  -moz-transition:height 1s; /* Firefox 4 */
  -webkit-transition:height 1s; /* Safari and Chrome */
  -o-transition:height 1s; /* Opera */
  
  -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	-moz-box-sizing: border-box;    /* Firefox, other Gecko */
	box-sizing: border-box;         /* Opera/IE 8+ */
}

div#conversation:hover
{
  width: 99%;
}

div#conversation div.message
{
  border: 1px dotted grey;
  margin: 2px 0;
  /* padding: 2px; */
}

/*
div#conversation div.message a {
  display: none;
}

div#conversation div.message:hover a {
  display: inline;
  visibility: visible;
}
div#conversation div.message:hover a:after {
  content: '\a' attr(title);
  white-space: pre;
}
*/

div#conversation div.message.timestamp
{
  border: none;
  text-align: center;
}

div#conversation div.message.currentUser
{
  color: red;
  background-color: rgba(255,0,0,0.1);
  margin-left: 5%;
  padding: 5px;
  <?PHP
  $tl = 10;
  $bl = 10;
  $tr = 0;
  $br = 0;
  ?>  
  border-top-left-radius: <?PHP echo $tl; ?>px;
  border-bottom-left-radius: <?PHP echo $bl; ?>px;
  border-top-right-radius: <?PHP echo $tr; ?>px;
  border-bottom-right-radius: <?PHP echo $br; ?>px;
    
  -moz-border-top-left-radius: <?PHP echo $tl; ?>px;
  -moz-border-bottom-left-radius: <?PHP echo $bl; ?>px;
  -moz-border-top-right-radius: <?PHP echo $tr; ?>px;
  -moz-border-bottom-right-radius: <?PHP echo $br; ?>px;
  
  -webkit-border-top-left-radius: <?PHP echo $tl; ?>px;
  -webkit-border-bottom-left-radius: <?PHP echo $bl; ?>px;
  -webkit-border-top-right-radius: <?PHP echo $tr; ?>px;
  -webkit-border-bottom-right-radius: <?PHP echo $br; ?>px;

  -khtml-border-top-left-radius: <?PHP echo $tl; ?>px;
  -khtml-border-bottom-left-radius: <?PHP echo $bl; ?>px;
  -khtml-border-top-right-radius: <?PHP echo $tr; ?>px;
  -khtml-border-bottom-right-radius: <?PHP echo $br; ?>px;

}

div#conversation div.message.otherUser
{
  color: blue;
  background-color: rgba(0,0,255,0.1);
  margin-right: 5%;
  padding: 5px;
  <?PHP
  $tl = 0;
  $bl = 0;
  $tr = 10;
  $br = 10;
  ?>  
  border-top-left-radius: <?PHP echo $tl; ?>px;
  border-bottom-left-radius: <?PHP echo $bl; ?>px;
  border-top-right-radius: <?PHP echo $tr; ?>px;
  border-bottom-right-radius: <?PHP echo $br; ?>px;
    
  -moz-border-top-left-radius: <?PHP echo $tl; ?>px;
  -moz-border-bottom-left-radius: <?PHP echo $bl; ?>px;
  -moz-border-top-right-radius: <?PHP echo $tr; ?>px;
  -moz-border-bottom-right-radius: <?PHP echo $br; ?>px;
  
  -webkit-border-top-left-radius: <?PHP echo $tl; ?>px;
  -webkit-border-bottom-left-radius: <?PHP echo $bl; ?>px;
  -webkit-border-top-right-radius: <?PHP echo $tr; ?>px;
  -webkit-border-bottom-right-radius: <?PHP echo $br; ?>px;

  -khtml-border-top-left-radius: <?PHP echo $tl; ?>px;
  -khtml-border-bottom-left-radius: <?PHP echo $bl; ?>px;
  -khtml-border-top-right-radius: <?PHP echo $tr; ?>px;
  -khtml-border-bottom-right-radius: <?PHP echo $br; ?>px;
  
}

div#conversation div.message.currentUser:hover
{
  color: red;
  background-color: rgba(255,0,0,0.2);
  
}

div#conversation div.message.otherUser:hover
{
  color: blue;
  background-color: rgba(0,0,255,0.2);
  
}


textarea#inputMessage
{
  margin: 5px;
  padding: 5px;
  width: 100%;
  background-color: rgba(255,0,0,0.1);
  color: red;
  
  -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	-moz-box-sizing: border-box;    /* Firefox, other Gecko */
	box-sizing: border-box;         /* Opera/IE 8+ */
}

textarea#inputMessage:focus
{
  font-size: 1.1em;
}

input#sendButton
{

}

/* ===== Emoticons ===== */
.emoticonSmall
{
width: 16px;
height: 16px;
display: inline-block;
vertical-align: top;
}
.emoticonLarge
{
width: 128px;
height: 128px;
display: inline-block;
vertical-align: top;
}


.emoticon_smile
{
background-image: url(http://static.ak.fbcdn.net/rsrc.php/v2/y0/x/FI5orUDgxmt.png);
background-repeat: no-repeat;
background-size: 100px 1062px;
background-position: -17px -484px;
}

.emoticon_frown
{
background-image: url(http://static.ak.fbcdn.net/rsrc.php/v2/y0/x/FI5orUDgxmt.png);
background-repeat: no-repeat;
background-size: 100px 1062px;
background-position: -34px -433px;
}

.emoticon_cry
{
/*
background-image: url(http://www.worldwidereaction.com/smileys/images/large_smileys/emotions/36_2_18.gif);
background-repeat: no-repeat;
background-size: 32px 32px;
*/
background-image: url(http://static.ak.fbcdn.net/rsrc.php/v2/y0/x/FI5orUDgxmt.png);
background-repeat: no-repeat;
background-size: 100px 1062px;
background-position: -34px -569px;
}

.emoticon_tongue
{
background-image: url(http://static.ak.fbcdn.net/rsrc.php/v2/y0/x/FI5orUDgxmt.png);
background-repeat: no-repeat;
background-size: 100px 1062px;
background-position: -68px -484px;
}

.emoticon_grin
{
background-image: url(https://fbstatic-a.akamaihd.net/rsrc.php/v2/y0/x/FI5orUDgxmt.png);
background-repeat: no-repeat;
background-size: 100px 1062px;
background-position: 0 -450px;
}

.emoticon_gasp
{
background-image: url(https://fbstatic-a.akamaihd.net/rsrc.php/v2/y0/x/FI5orUDgxmt.png);
background-repeat: no-repeat;
background-size: 100px 1062px;
background-position: -51px -433px;
}

.emoticon_wink
{
background-image: url(https://fbstatic-a.akamaihd.net/rsrc.php/v2/y0/x/FI5orUDgxmt.png);
background-repeat: no-repeat;
background-size: 100px 1062px;
background-position: -34px -501px;
}

.emoticon_like
{
background-image: url(https://fbstatic-a.akamaihd.net/rsrc.php/v2/y0/x/FI5orUDgxmt.png);
background-repeat: no-repeat;
background-size: 100px 1062px;
background-position: -68px -1045px;
}

.emoticon_NO
{
background-image: url(http://24.media.tumblr.com/f4a4aeb269d94e79ce4b9fba5716dc60/tumblr_mff1txlfPu1rs7k3ko1_500.jpg);
background-repeat: no-repeat;
background-size: 128px 128px;
}

.emoticon_YES
{
background-image: url(http://www.yourorganicpet.com/images/smiling-dog-2.jpg);
background-repeat: no-repeat;
background-size: 128px 128px;
}

.emoticon_rickRolled
{
background-image: url(http://www.alightintherain.com/blog/wp-content/uploads/2012/04/rickroll.gif);
background-repeat: no-repeat;
background-size: 128px 128px;
}


/* ===== Widgets ====== */
div.iWantWidget
{
  
}

div.iWantWidget .widgetTitle
{
  font-weight: bold;
  font-size: 2em;
}

div.iWantWidget .messageContents
{
  
}