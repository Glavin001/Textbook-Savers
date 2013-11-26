<?PHP
header("Content-type: text/css"); 
require 'theme.php';
?>

div.textbookWall#wallMessage
{
  text-align: center; 
  overflow: auto; 
  top: 40px; 
  height: 320px; 
  width: 100%; 
  position: relative; 
  background-color: rgba(0,0,0,0.1); 
  /* border-bottom: 5px solid rgba(0,0,0,0.9); */
  margin-bottom: 40px;
}

div.textbookWall#wallMessage #messageBlock
{
  font-size: 2em; 
  font-weight: bold; 
  box-shadow: 10px; 
  background-color: rgba(255,255,255,0.9); 
  box-shadow: 0 0 100px 40px #FFF; 
  z-index: -6;
  padding: 10px;
  margin: 5px 0;
}


div.textbookWall#wallImages
{
  z-index: -100; 
  position: absolute; 
  top:40px; 
  opacity: 0.9; 
  width: 100%; 
  height: 320px; 
  overflow: hidden; 
  text-align: center; 
  background-color: rgba(0,0,0,1.0);
}

div.textbookWall#wallImages img
{
width:"64"; 
height:"80";
}

.signupNowButton
{
  background-color: rgba(162, 69, 66, 1);
  <?PHP $r = 5; ?>
  border-radius: <?PHP echo $r; ?>px;
  -moz-border-radius: <?PHP echo $r; ?>px;
  -webkit-border--radius: <?PHP echo $r; ?>px;
  -khtml-border--radius: <?PHP echo $r; ?>px;
  color: white;
  width: 200px;
  height: 30px;
  line-height: 30px;
  text-align: center;
  position: absolute;
  left: 50%;
  margin-left: -100px;
}
.signupNowButton a 
{
  color: white;
}


/* === Getting Started === */
div#getStarted 
{
  border-top: 3px solid rgba(0,0,0,0.9);
  border-bottom: 3px solid rgba(0,0,0,0.9);
    
  background-color: rgba(0,0,0,1.0);
  text-align: center;

  transition:height ease-in-out 750ms;
  -moz-transition:height ease-in-out 750ms; /* Firefox 4 */
  -webkit-transition:height ease-in-out 750ms; /* Safari and Chrome */
  -o-transition:height ease-in-out 750ms; /* Opera */

  <?PHP
  $tl = 0;
  $bl = 0;
  $tr = 0;
  $br = 0;
  ?>
  border-top-left-radius: <?PHP echo $tl; ?>px;
  border-bottom-left-radius: <?PHP echo $tl; ?>px;
  border-top-right-radius: <?PHP echo $tl; ?>px;
  border-bottom-right-radius: <?PHP echo $tl; ?>px;
    
  -moz-border-top-left-radius: <?PHP echo $tl; ?>px;
  -moz-border-bottom-left-radius: <?PHP echo $tl; ?>px;
  -moz-border-top-right-radius: <?PHP echo $tl; ?>px;
  -moz-border-bottom-right-radius: <?PHP echo $tl; ?>px;
  
  -webkit-border-top-left-radius: <?PHP echo $tl; ?>px;
  -webkit-border-bottom-left-radius: <?PHP echo $tl; ?>px;
  -webkit-border-top-right-radius: <?PHP echo $tl; ?>px;
  -webkit-border-bottom-right-radius: <?PHP echo $tl; ?>px;

  -khtml-border-top-left-radius: <?PHP echo $tl; ?>px;
  -khtml-border-bottom-left-radius: <?PHP echo $tl; ?>px;
  -khtml-border-top-right-radius: <?PHP echo $tl; ?>px;
  -khtml-border-bottom-right-radius: <?PHP echo $tl; ?>px;
  
}


div#getStarted.deactivated
{
  height: 0px;
  padding: 0px;
  overflow: hidden;
}

div#getStarted.activated
{
  height: 720px;
  padding: 5px;
  overflow: scroll;
}