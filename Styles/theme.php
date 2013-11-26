<?php
session_start(); 
require_once '../Scripts/common.php';

// theme.php
/*
This is a file containing the default colour themes for the PHP generated CSS files.
*/

// HowItWorks Links
$linkUnderlineColour = "rgba(186, 0, 0, 1)";//#ba000;

// Initializing Default Theme
$themeData = array(
'backgroundTile' => '../Images/backgroundTiles/paper.png',
'bodyBackground' => "background:url('".$theme['backgroundTile']."') repeat;",
'defaultTextColour' => "rgba(0, 0, 0, 0.95)",
'lightColour' => "rgba(248, 248, 248, 0.6)",
'darkColour' => "rgba(136, 136, 136, 0.7)",
'shadowColour' => "rgba(40, 40, 40, 0.95)",

/* Nav bar */
'navTextColour' => "rgba(0, 0, 0, 0.95)",
'navTextFontFam' => "'lucida grande',tahoma,verdana,arial,sans-serif",

// Catalog
'widgetBackground' => "rgba(160, 160, 160, 1)",
'widgetTitleBackground' => "rgba(120, 120, 120, 0.95)",
'widgetContentBackground' => "rgba(104, 104, 104, 0.95)",
'widgetBorder' => "rgba(48, 48, 48, 0.95)",
'widgetText' => "rgba(240, 240, 240, 1)"
);

//if (isset($_SESSION['UserId']))
if ($_SESSION['theme'] == "Red")
{

// Basic / Nav / Etc
$backgroundTile = '../Images/backgroundTiles/paper.png';
$bodyBackground = "background:url('".$backgroundTile."') repeat;";
$lightColour = "rgba(242, 75, 102, 0.6)";//"#F24B66";//"EB2646";//"2F7BA3"; //"963AD6";
$darkColour = "rgba(201, 32, 60, 0.8)";//"#C9203C";//"2C5463"; //"4E0085";
$shadowColour = "rgba(39, 6, 68, 0.95)";//"#270644";
$navTextColour = "rgba(255, 255, 255, 0.95)";//"#fff";
$navTextFontFam = "Arial, Verdana, sans-serif";//"'lucida grande',tahoma,verdana,arial,sans-serif";
//$defaultTextSize = "";
$defaultTextColour = "rgba(0, 0, 0, 0.95)";//"#fff";

// Catalog
$widgetBackground = "rgba(255, 170, 170, 1)";//"#FAA"; //"d1dce6";
$widgetTitleBackground = "rgba(242, 75, 102, 0.95)";//$lightColour; //"8FBDE3";
$widgetContentBackground = "rgba(242, 75, 102, 0.95)";//$lightColour; //"8FBDE3";
$widgetBorder = "rgba(242, 75, 102, 0.95)";//$darkColour; //"8FBDE3";
$widgetText = "rgba(250, 222, 222, 1)";//"#FADEDE";//"2B71AD";

}
else if ($_SESSION['theme'] == "Green")
{

// Basic / Nav / Etc
$backgroundTile = '../Images/backgroundTiles/paper.png';
$bodyBackground = "background:url('".$backgroundTile."') repeat;";
$lightColour = "#28D450";//"EB2646";//"2F7BA3"; //"963AD6";
$darkColour = "#39C920";//"2C5463"; //"4E0085";
$shadowColour = "#224406";
$navTextColour = "#fff";
$navTextFontFam = "Arial, Verdana, sans-serif";//"'lucida grande',tahoma,verdana,arial,sans-serif";
$defaultTextColour = "rgba(0, 0, 0, 0.95)";//"#fff";

// Catalog
$widgetBackground = "#00FF1E"; //"d1dce6";
$widgetTitleBackground = $lightColour; //"8FBDE3";
$widgetContentBackground = $lightColour; //"8FBDE3";
$widgetBorder = $darkColour; //"8FBDE3";
$widgetText = "#E3FADE";//"2B71AD";

}
else if ($_SESSION['theme'] == "FacebookBlue")
{

/* === Facebook-Like Theme === */
// Basic / Nav / Etc
$backgroundTile = '../Images/backgroundTiles/paper.png';
$bodyBackground = "background:url('".$backgroundTile."') repeat;";
$lightColour = "#3b5998";//"EB2646";//"2F7BA3"; //"963AD6";
$darkColour = "#3b5998";//"2C5463"; //"4E0085";
$shadowColour = "#3b5998";
$navTextColour = "#d8dfea";
$navTextFontFam = "Helvetica, Arial, 'lucida grande',tahoma,verdana,arial,sans-serif";
$defaultTextColour = "rgba(0, 0, 0, 0.95)";//"#fff";

// Catalog
$widgetBackground = "#FFF";
$widgetTitleBackground = $darkColour;
$widgetContentBackground = $darkColour;
$widgetBorder = $darkColour;
$widgetText = "#d8dfea";
$hoverColour = "#E9E9E9";
$hoverBorder = $darkColour;

}
else if ($_SESSION['theme'] == "White")
{
/* === White Theme === */
// Basic / Nav / Etc
$backgroundTile = '../Images/backgroundTiles/paper.png';
$bodyBackground = "";//"background:url('".$backgroundTile."') repeat;";
$lightColour = "rgba(255,255,255,0.5)";//"#3b5998";//"EB2646";//"2F7BA3"; //"963AD6";
$darkColour = "rgba(255,255,255,0.5)";//"#3b5998";//"2C5463"; //"4E0085";
$shadowColour = "rgba(255,255,255,0.95)";//"#3b5998";
$navTextColour = "rgba(0,0,0,0.95)";//"#d8dfea";
$navTextFontFam = "Arial, Verdana, sans-serif";//"'lucida grande',tahoma,verdana,arial,sans-serif";
$navBorderColour = "rgba(100,100,100,0.5);";
$defaultTextColour = "rgba(0, 0, 0, 0.95)";//"#fff";

// Catalog
$widgetBackground = "rgba(255,255,255,0.95)";//"#FFF";
$widgetTitleBackground = "rgba(255,255,255,0.95)";//$darkColour;
$widgetContentBackground = "rgba(255,255,255,0.95)";//$darkColour;
$widgetBorder = "rgba(255,255,255,0.95)";//$darkColour;
$widgetText = "rgba(0,0,0,0.65)";//"#d8dfea";
$hoverColour = "rgba(255,255,255,0.95)";//"#E9E9E9";
$hoverBorder = "rgba(255,255,255,0.95)";//$darkColour;

}
else
{

/* === Minimalist Theme === */
// Basic / Nav / Etc
$backgroundTile = '../Images/backgroundTiles/paper.png';
$bodyBackground = "background:url('".$backgroundTile."') repeat;";
$lightColour = "rgba(248, 248, 248, 0.6)";//"#F24B66";//"EB2646";//"2F7BA3"; //"963AD6";
$darkColour = "rgba(136, 136, 136, 0.7)";//"#C9203C";//"2C5463"; //"4E0085";
$shadowColour = "rgba(40, 40, 40, 0.95)";//"#270644";
$navTextColour = "rgba(0, 0, 0, 0.95)";//"#fff";
$navTextFontFam = "Arial, Verdana, sans-serif";//"'lucida grande',tahoma,verdana,arial,sans-serif";
$defaultTextColour = "rgba(0, 0, 0, 0.95)";//"#fff";

// Catalog
$widgetBackground = "rgba(160, 160, 160, 1)";//"#FAA"; //"d1dce6";
$widgetTitleBackground = "rgba(120, 120, 120, 0.95)";//$lightColour; //"8FBDE3";
$widgetContentBackground = "rgba(104, 104, 104, 0.95)";//$lightColour; //"8FBDE3";
$widgetBorder = "rgba(48, 48, 48, 0.95)";//$darkColour; //"8FBDE3";
$widgetText = "rgba(240, 240, 240, 1)";//"#FADEDE";//"2B71AD";
$hoverColour = $darkColour;
$hoverBorder = $darkColour;

}

?>