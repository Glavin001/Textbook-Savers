<?php 
header("Content-type: text/css"); 
require 'theme.php';
?>

/* CSS Reset */
* {
  font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
  padding-left: 0px;
  margin: 0px;
  /*
  border: 0;
  border-style: none;
  */
  color: <?PHP echo $defaultTextColour; ?>;
}

*:link
{
  font-style: normal;
  color: <?PHP echo $defaultTextColour; ?>;
  text-decoration: none;
}

*:visited
{
  font-style: italic;
  color: <?PHP echo $defaultTextColour; ?>;
}

a:hover
{
  font-style: normal;
/*  text-shadow: <?PHP echo $shadowColour; ?> 1px 1px; */
  color: <?PHP echo $defaultTextColour; ?>;
}

*:active
{
  font-style: normal;
  color: <?PHP echo $defaultTextColour; ?>;
} 


/* ===== fix CSS reset */
/* for default looking lists */
ul.normalList {
  margin-left: 1em;
  padding-left: 1em;
}

body {
 <?PHP echo $bodyBackground; ?>
}

body div.page {
  margin: 50px 10px 10px 10px;
}


/* Live Validation */
.LV_validation_message{
    font-weight:bold;
    margin:0 0 0 5px;
}

.LV_valid {
    color:#00CC00;
}
	
.LV_invalid {
    color:#CC0000;
}
    
.LV_valid_field,
    input.LV_valid_field:hover, 
    input.LV_valid_field:active,
    textarea.LV_valid_field:hover, 
    textarea.LV_valid_field:active {
    border: 1px solid #00CC00;
}
    
.LV_invalid_field, 
    input.LV_invalid_field:hover, 
    input.LV_invalid_field:active,
    textarea.LV_invalid_field:hover, 
    textarea.LV_invalid_field:active {
    border: 1px solid #CC0000;
}

/* ==== Beta Banner ==== */
#cornerBanner 
{
  position: fixed;
  z-index: 100;
  color: #fff;
  background-color: #CC0000;
  -moz-box-shadow: 2px 2px 20px #888;
  -moz-transform: rotate(45deg);
  -moz-transform-origin: 50% 50%;
  -webkit-transform: rotate(45deg);
  -webkit-transform-origin: 50% 50%;
  width: 300px;
  top: 20px;
  right: -120px;
  text-align: center;
  text-transform:uppercase;
  font-weight: bold;
  font-size: 1.5em;
  line-height: 1.5em;
}

#feedbackButton 
{
  position: fixed;
  z-index: 100;
  width: 150px;
  bottom: 0px;
  right: 0px; 
  color: #fff;
  background-color: rgba(0,0,0,0.7);
  padding: 5px;
  font-weight: bold;
  
  <?PHP
  $tl = 5;
  ?>
  border-top-left-radius: <?PHP echo $tl; ?>px;
  -moz-border-top-left-radius: <?PHP echo $tl; ?>px;
  -webkit-border-top-left-radius: <?PHP echo $tl; ?>px;
  -khtml-border-top-left-radius: <?PHP echo $tl; ?>px;
  
  text-align: center;
  font-weight: bold;
  font-size: 1.2em;
  line-height: 1.2em;

}

/* === inWindowPopup === */
.inWindowPopup 
{
  position: fixed; 
  left: 50%;
  margin-left: -200px; 
  top: 30%; 
  width: 400px; 
  height: 400px; 
  z-index: 200; 
  /* background-color: rgba(255,255,255,0.8); */
  border: 20px solid rgba(87,87,87,0.7);
  border-radius: 10px; 
}

.inWindowPopup .popupContent 
{
  width: 380px; 
  height: 350px;
  padding: 10px;
  background-color: rgba(255,255,255,1.0);
}

.inWindowPopup .closeButton 
{
  background: radial-gradient( 5px -9px, circle, white 8%, red 26px );
  background-color: red;
  border: 2px solid white;
  border-radius: 12px; /* one half of ( (border * 2) + height + padding ) */
  box-shadow: 1px 1px 1px black;
  color: white;
  font: bold 15px/13px Helvetica, Verdana, Tahoma;
  height: 16px; 
  min-width: 14px;
  width: 14px;
  padding: 4px 3px 0 3px;
  text-align: center;
  z-index: 202;
  float: right;
  
  position: relative;
  top: -7px;
  right: -7px;
}

.inWindowPopup .popupTitle
{
  background-color: <?PHP echo $widgetContentBackground; ?>;
  color: <?PHP echo $widgetText; ?>;
  height: 20px;
  padding: 5px;
  text-align: center;
  font-weight: bold;
  z-index: 201;
}


#talkbubble {
   width: 120px;
   height: 80px;
   background: red;
   position: relative;
   -moz-border-radius:    10px;
   -webkit-border-radius: 10px;
   border-radius:         10px;
}
#talkbubble:before {
   content:"";
   position: absolute;
   right: 100%;
   top: 26px;
   width: 0;
   height: 0;
   border-top: 13px solid transparent;
   border-right: 26px solid red;
   border-bottom: 13px solid transparent;
}
